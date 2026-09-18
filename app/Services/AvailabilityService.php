<?php

namespace App\Services;

use App\Models\ExceptionalClosure;
use App\Models\OpeningHour;
use App\Models\Reservation;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AvailabilityService
{
    /**
     * Returns bookable time slots for the given date.
     *
     * Each element: ['time' => Carbon, 'remaining' => int]
     * Slots are excluded when they fall at or before now + min_advance_hours.
     *
     * @return Collection<int, array{time: Carbon, remaining: int}>
     */
    public function getSlots(\DateTimeInterface|string $date): Collection
    {
        $date = Carbon::parse($date)->startOfDay();

        // Exceptional closure?
        if (ExceptionalClosure::whereDate('date', $date->toDateString())->exists()) {
            return collect();
        }

        // Open services for this day of week
        $services = OpeningHour::where('day_of_week', $date->dayOfWeek)
            ->where('is_open', true)
            ->orderBy('id')
            ->get();

        if ($services->isEmpty()) {
            return collect();
        }

        $slotInterval    = (int) Setting::get('slot_interval', 30);
        $mealDuration    = (int) Setting::get('meal_duration', 120);
        $capacity        = (int) Setting::get('capacity', 40);
        $minAdvanceHours = (int) Setting::get('min_advance_hours', 2);
        $cutoff          = now()->addHours($minAdvanceHours);

        // Fetch all active reservations for the date in one query
        $reservations = Reservation::whereDate('date', $date->toDateString())
            ->whereIn('status', ['pending', 'confirmed'])
            ->get(['time', 'guests']);

        $slots = collect();

        foreach ($services as $service) {
            $cursor    = $date->copy()->setTimeFromTimeString($service->start_time);
            $lastStart = $date->copy()->setTimeFromTimeString($service->end_time)
                ->subMinutes($mealDuration);

            while ($cursor->lte($lastStart)) {
                $slotStart = $cursor->copy();
                $slotEnd   = $slotStart->copy()->addMinutes($mealDuration);

                if ($slotStart->gt($cutoff)) {
                    // Sum guests from reservations whose meal window overlaps [slotStart, slotEnd)
                    $booked = $reservations->filter(
                        function (Reservation $r) use ($date, $slotStart, $slotEnd, $mealDuration) {
                            $resStart = $date->copy()->setTimeFromTimeString($r->time);
                            $resEnd   = $resStart->copy()->addMinutes($mealDuration);

                            // Overlap: resStart < slotEnd AND slotStart < resEnd
                            return $resStart->lt($slotEnd) && $slotStart->lt($resEnd);
                        }
                    )->sum('guests');

                    $slots->push([
                        'time'      => $slotStart,
                        'remaining' => max(0, $capacity - $booked),
                    ]);
                }

                $cursor->addMinutes($slotInterval);
            }
        }

        return $slots;
    }

    /**
     * Returns true when the slot at $time on $date can accommodate $guests people.
     */
    public function isAvailable(\DateTimeInterface|string $date, string $time, int $guests): bool
    {
        $timeKey = Carbon::parse($time)->format('H:i');

        $slot = $this->getSlots($date)->first(
            fn (array $s) => $s['time']->format('H:i') === $timeKey
        );

        return $slot !== null && $slot['remaining'] >= $guests;
    }
}
