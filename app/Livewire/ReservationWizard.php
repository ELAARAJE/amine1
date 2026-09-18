<?php

namespace App\Livewire;

use App\Models\ExceptionalClosure;
use App\Models\OpeningHour;
use App\Models\Reservation;
use App\Models\Setting;
use App\Services\AvailabilityService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReservationWizard extends Component
{
    public int $step = 1;

    public string $calendarMonth = '';
    public ?string $selectedDate = null;
    public ?string $selectedTime = null;
    public int $guests = 2;
    public string $comment = '';

    public array $slotsGrouped = [];
    public ?string $bookingError = null;
    public bool $success = false;

    public function mount(): void
    {
        $this->calendarMonth = now()->format('Y-m');
    }

    public function prevMonth(): void
    {
        $current = Carbon::parse($this->calendarMonth . '-01');
        if ($current->lte(now()->startOfMonth())) {
            return;
        }
        $this->calendarMonth = $current->subMonth()->format('Y-m');
    }

    public function nextMonth(): void
    {
        $this->calendarMonth = Carbon::parse($this->calendarMonth . '-01')
            ->addMonth()
            ->format('Y-m');
    }

    public function selectDate(string $date): void
    {
        $this->selectedDate  = $date;
        $this->selectedTime  = null;
        $this->slotsGrouped  = $this->buildSlotsGrouped($date);
        $this->bookingError  = null;
        $this->step          = 2;
    }

    public function selectTime(string $time): void
    {
        $this->selectedTime = $time;
        $this->step         = 3;
    }

    public function incrementGuests(): void
    {
        if ($this->guests < (int) Setting::get('max_guests', 10)) {
            $this->guests++;
        }
    }

    public function decrementGuests(): void
    {
        if ($this->guests > 1) {
            $this->guests--;
        }
    }

    public function backToDate(): void
    {
        $this->selectedTime = null;
        $this->step         = 1;
    }

    public function backToSlots(): void
    {
        $this->selectedTime = null;
        $this->step         = 2;
    }

    public function backToDetails(): void
    {
        $this->step = 3;
    }

    public function goToSummary(): void
    {
        $max = (int) Setting::get('max_guests', 10);

        $this->validate(
            [
                'guests'  => ['required', 'integer', 'min:1', "max:{$max}"],
                'comment' => ['nullable', 'string', 'max:500'],
            ],
            [
                'guests.required' => 'Le nombre de couverts est requis.',
                'guests.min'      => 'Minimum 1 couvert.',
                'guests.max'      => "Maximum {$max} couverts par réservation.",
                'comment.max'     => 'Le commentaire ne peut pas dépasser 500 caractères.',
            ]
        );

        $this->step = 4;
    }

    public function submit(): void
    {
        $this->bookingError = null;

        try {
            DB::transaction(function () {
                // Pessimistic lock on all active reservations for this date
                Reservation::whereDate('date', $this->selectedDate)
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->lockForUpdate()
                    ->get();

                if (!app(AvailabilityService::class)->isAvailable(
                    $this->selectedDate,
                    $this->selectedTime,
                    $this->guests
                )) {
                    throw new \RuntimeException(
                        'Ce créneau n\'est plus disponible pour le nombre de couverts demandé.'
                    );
                }

                Reservation::create([
                    'user_id' => auth()->id(),
                    'date'    => $this->selectedDate,
                    'time'    => $this->selectedTime . ':00',
                    'guests'  => $this->guests,
                    'comment' => $this->comment ?: null,
                    'status'  => 'pending',
                ]);
            });

            $this->success = true;

        } catch (\RuntimeException $e) {
            $this->bookingError = $e->getMessage();
            $this->slotsGrouped = $this->buildSlotsGrouped($this->selectedDate);
            $this->step         = 2;
        }
    }

    protected function buildSlotsGrouped(?string $date): array
    {
        if (!$date) {
            return [];
        }

        $rawSlots = app(AvailabilityService::class)->getSlots($date);

        if ($rawSlots->isEmpty()) {
            return [];
        }

        $carbonDate   = Carbon::parse($date);
        $mealDuration = (int) Setting::get('meal_duration', 120);

        $openingHours = OpeningHour::where('day_of_week', $carbonDate->dayOfWeek)
            ->where('is_open', true)
            ->orderBy('id')
            ->get();

        $grouped = [];

        foreach ($rawSlots as $slot) {
            $slotTime = $slot['time'];

            $serviceRecord = $openingHours->first(
                function (OpeningHour $oh) use ($slotTime, $carbonDate, $mealDuration) {
                    $start = $carbonDate->copy()->setTimeFromTimeString($oh->start_time);
                    $end   = $carbonDate->copy()->setTimeFromTimeString($oh->end_time)
                        ->subMinutes($mealDuration);

                    return $slotTime->gte($start) && $slotTime->lte($end);
                }
            );

            $label = match ($serviceRecord?->service) {
                'lunch'  => 'Déjeuner',
                'dinner' => 'Dîner',
                default  => 'Service',
            };

            $grouped[$label][] = [
                'time'      => $slotTime->format('H:i'),
                'remaining' => $slot['remaining'],
            ];
        }

        return $grouped;
    }

    protected function buildCalendarDays(): array
    {
        $monthFirst = Carbon::parse($this->calendarMonth . '-01');
        $monthLast  = $monthFirst->copy()->endOfMonth();

        $start = $monthFirst->copy()->startOfWeek(Carbon::MONDAY);
        $end   = $monthLast->copy()->endOfWeek(Carbon::MONDAY);

        $today = now()->startOfDay();

        $openDaysOfWeek = OpeningHour::where('is_open', true)
            ->pluck('day_of_week')
            ->unique()
            ->map(fn ($d) => (int) $d)
            ->values()
            ->all();

        $closures = ExceptionalClosure::whereDate('date', '>=', $monthFirst->toDateString())
            ->whereDate('date', '<=', $monthLast->toDateString())
            ->get()
            ->map(fn (ExceptionalClosure $c) => $c->date->toDateString())
            ->all();

        $days    = [];
        $current = $start->copy();

        while ($current->lte($end)) {
            $dateStr        = $current->toDateString();
            $isCurrentMonth = $current->month === $monthFirst->month;
            $isPast         = $current->lt($today);
            $isAvailable    = $isCurrentMonth
                && !$isPast
                && in_array($current->dayOfWeek, $openDaysOfWeek, true)
                && !in_array($dateStr, $closures, true);

            $days[] = [
                'date'           => $dateStr,
                'day'            => $current->day,
                'isCurrentMonth' => $isCurrentMonth,
                'isAvailable'    => $isAvailable,
                'isSelected'     => $dateStr === $this->selectedDate,
                'isToday'        => $current->isSameDay($today),
            ];

            $current->addDay();
        }

        return array_chunk($days, 7);
    }

    public function render()
    {
        $maxGuests      = (int) Setting::get('max_guests', 10);
        $calendarDays   = $this->buildCalendarDays();
        $monthFirst     = Carbon::parse($this->calendarMonth . '-01');
        $calendarLabel  = ucfirst($monthFirst->translatedFormat('F Y'));
        $canGoPrev      = $monthFirst->gt(now()->startOfMonth());
        $formattedDate  = $this->selectedDate
            ? ucfirst(Carbon::parse($this->selectedDate)->translatedFormat('l d F Y'))
            : null;

        return view('livewire.reservation-wizard', compact(
            'calendarDays',
            'calendarLabel',
            'canGoPrev',
            'maxGuests',
            'formattedDate',
        ));
    }
}
