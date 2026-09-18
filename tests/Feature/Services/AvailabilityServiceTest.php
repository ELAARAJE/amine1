<?php

use App\Models\ExceptionalClosure;
use App\Models\OpeningHour;
use App\Models\Reservation;
use App\Models\Setting;
use App\Models\User;
use App\Services\AvailabilityService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

uses(RefreshDatabase::class);

// ─── Helpers ────────────────────────────────────────────────────────────────

/**
 * 2026-10-01 is a Thursday (day_of_week = 4).
 * The test clock is pinned to 09:00 on that day, so all lunch/dinner slots
 * are safely beyond the min_advance_hours cutoff.
 */
const TEST_DATE = '2026-10-01';

function service(): AvailabilityService
{
    return new AvailabilityService();
}

/** Seed settings, merging overrides over sensible defaults. */
function seedSettings(array $overrides = []): void
{
    foreach (array_merge([
        'slot_interval'     => 30,
        'meal_duration'     => 120,
        'capacity'          => 40,
        'min_advance_hours' => 2,
    ], $overrides) as $key => $value) {
        Setting::set($key, $value);
    }
}

/** Create an open service for Thursday (day_of_week = 4). */
function thursdayService(
    string $start = '12:00:00',
    string $end = '15:00:00',
    string $name = 'lunch',
): void {
    OpeningHour::create([
        'day_of_week' => 4,
        'service'     => $name,
        'start_time'  => $start,
        'end_time'    => $end,
        'is_open'     => true,
    ]);
}

/** Create a reservation on TEST_DATE (requires a user for the FK). */
function makeReservation(array $attrs = []): Reservation
{
    return Reservation::create(array_merge([
        'user_id' => User::factory()->create()->id,
        'date'    => TEST_DATE,
        'time'    => '12:00:00',
        'guests'  => 2,
        'status'  => 'confirmed',
    ], $attrs));
}

// ─── Setup / teardown ───────────────────────────────────────────────────────

beforeEach(function () {
    Cache::flush();                              // reset Setting cache
    Carbon::setTestNow('2026-10-01 09:00:00');  // Thursday 09:00
});

afterEach(function () {
    Carbon::setTestNow(null);
});

// ─── Slot generation ────────────────────────────────────────────────────────

it('generates the expected slots within a service window', function () {
    seedSettings(['slot_interval' => 30, 'meal_duration' => 120]);
    thursdayService('12:00:00', '15:00:00');

    // lastStart = 15:00 − 120 min = 13:00  →  slots: 12:00, 12:30, 13:00
    $slots = service()->getSlots(TEST_DATE);

    expect($slots)->toHaveCount(3)
        ->and($slots->pluck('time')->map->format('H:i')->values()->all())
        ->toBe(['12:00', '12:30', '13:00']);
});

it('aggregates slots from multiple services (lunch + dinner)', function () {
    seedSettings(['slot_interval' => 60, 'meal_duration' => 60]);
    thursdayService('12:00:00', '14:00:00', 'lunch');   // 12:00, 13:00
    thursdayService('19:00:00', '21:00:00', 'dinner');  // 19:00, 20:00

    $times = service()->getSlots(TEST_DATE)->pluck('time')->map->format('H:i')->values()->all();

    expect($times)->toBe(['12:00', '13:00', '19:00', '20:00']);
});

it('returns full capacity as remaining when no reservations exist', function () {
    seedSettings(['capacity' => 10]);
    thursdayService();

    $remaining = service()->getSlots(TEST_DATE)->pluck('remaining')->unique()->all();

    expect($remaining)->toBe([10]);
});

// ─── Fermeture exceptionnelle ────────────────────────────────────────────────

it('returns no slots on an exceptional closure day', function () {
    seedSettings();
    thursdayService();
    ExceptionalClosure::create(['date' => TEST_DATE, 'reason' => 'Congés annuels']);

    expect(service()->getSlots(TEST_DATE))->toBeEmpty();
});

it('returns slots on other days even when a closure exists', function () {
    seedSettings(['slot_interval' => 60, 'meal_duration' => 60]);
    ExceptionalClosure::create(['date' => TEST_DATE, 'reason' => 'Congés']);

    // Friday (day 5) has an open service; the closure only covers Thursday
    OpeningHour::create([
        'day_of_week' => 5,
        'service'     => 'dinner',
        'start_time'  => '19:00:00',
        'end_time'    => '21:00:00',
        'is_open'     => true,
    ]);

    expect(service()->getSlots('2026-10-02'))->toHaveCount(2); // 19:00, 20:00
});

// ─── Jour fermé ─────────────────────────────────────────────────────────────

it('returns no slots when the day has no opening-hour records', function () {
    seedSettings();
    // No OpeningHour created for Thursday

    expect(service()->getSlots(TEST_DATE))->toBeEmpty();
});

it('returns no slots when all services for the day are closed', function () {
    seedSettings();
    OpeningHour::create([
        'day_of_week' => 4,
        'service'     => 'lunch',
        'start_time'  => '12:00:00',
        'end_time'    => '15:00:00',
        'is_open'     => false,
    ]);

    expect(service()->getSlots(TEST_DATE))->toBeEmpty();
});

// ─── Délai minimum (min_advance_hours) ──────────────────────────────────────

it('excludes slots that fall within the minimum advance notice window', function () {
    // now = 09:00, min_advance_hours = 4 → cutoff = 13:00
    // Service 12:00–16:00 with 30-min slots, 120-min meal → lastStart = 14:00
    // Slots: 12:00, 12:30, 13:00, 13:30, 14:00
    // Slots > 13:00 (strictly): 13:30, 14:00 → 2 slots
    seedSettings(['min_advance_hours' => 4, 'slot_interval' => 30, 'meal_duration' => 120]);
    thursdayService('12:00:00', '16:00:00');

    $times = service()->getSlots(TEST_DATE)->pluck('time')->map->format('H:i')->values()->all();

    expect($times)->toBe(['13:30', '14:00']);
});

it('excludes all slots when the current time is past the last slot of the day', function () {
    Carbon::setTestNow('2026-10-01 14:00:00'); // after last possible start (13:00)
    seedSettings(['min_advance_hours' => 0]);
    thursdayService('12:00:00', '15:00:00');

    expect(service()->getSlots(TEST_DATE))->toBeEmpty();
});

// ─── Chevauchement ───────────────────────────────────────────────────────────

it('deducts guests from all slots whose window overlaps the reservation window', function () {
    // Reservation at 12:00, meal 120 min → occupies [12:00, 14:00)
    // Slots 12:00 [12:00,14:00), 12:30 [12:30,14:30), 13:00 [13:00,15:00) all overlap
    seedSettings(['capacity' => 10, 'meal_duration' => 120, 'slot_interval' => 30]);
    thursdayService('12:00:00', '15:00:00');
    makeReservation(['time' => '12:00:00', 'guests' => 4, 'status' => 'confirmed']);

    $remaining = service()->getSlots(TEST_DATE)->pluck('remaining')->all();

    expect($remaining)->each->toBe(6); // all 3 slots see 4 guests booked
});

it('does not deduct guests for a reservation that starts exactly at slot end', function () {
    // Slot 12:00 window: [12:00, 14:00). Reservation at 14:00: resStart = 14:00.
    // Overlap condition: resStart(14:00) < slotEnd(14:00)  → FALSE → no overlap.
    seedSettings(['capacity' => 10, 'meal_duration' => 120, 'slot_interval' => 30]);
    thursdayService('12:00:00', '15:00:00');
    makeReservation(['time' => '14:00:00', 'guests' => 3, 'status' => 'confirmed']);

    $slotAt12 = service()->getSlots(TEST_DATE)
        ->first(fn ($s) => $s['time']->format('H:i') === '12:00');

    expect($slotAt12['remaining'])->toBe(10); // not affected
});

it('deducts guests from later slots that overlap a late-starting reservation', function () {
    // Reservation at 14:00, meal 120 min → [14:00, 16:00)
    // Slot 12:00 [12:00,14:00): 14:00 < 14:00? NO → no overlap
    // Slot 12:30 [12:30,14:30): 14:00 < 14:30? YES → overlap
    // Slot 13:00 [13:00,15:00): 14:00 < 15:00? YES → overlap
    seedSettings(['capacity' => 10, 'meal_duration' => 120, 'slot_interval' => 30]);
    thursdayService('12:00:00', '15:00:00');
    makeReservation(['time' => '14:00:00', 'guests' => 3, 'status' => 'confirmed']);

    $slots = service()->getSlots(TEST_DATE)->keyBy(fn ($s) => $s['time']->format('H:i'));

    expect($slots['12:00']['remaining'])->toBe(10) // no overlap
        ->and($slots['12:30']['remaining'])->toBe(7)  // overlap
        ->and($slots['13:00']['remaining'])->toBe(7); // overlap
});

it('sums guests across multiple overlapping reservations', function () {
    seedSettings(['capacity' => 20, 'meal_duration' => 120, 'slot_interval' => 30]);
    thursdayService('12:00:00', '15:00:00');
    makeReservation(['time' => '12:00:00', 'guests' => 6, 'status' => 'confirmed']);
    makeReservation(['time' => '12:30:00', 'guests' => 5, 'status' => 'confirmed']);

    // Slot 12:00 [12:00,14:00): both reservations overlap → booked = 11
    $slotAt12 = service()->getSlots(TEST_DATE)
        ->first(fn ($s) => $s['time']->format('H:i') === '12:00');

    expect($slotAt12['remaining'])->toBe(9);
});

it('counts pending reservations toward booked capacity', function () {
    seedSettings(['capacity' => 10, 'meal_duration' => 120, 'slot_interval' => 30]);
    thursdayService('12:00:00', '15:00:00');
    makeReservation(['time' => '12:00:00', 'guests' => 4, 'status' => 'pending']);

    $slotAt12 = service()->getSlots(TEST_DATE)
        ->first(fn ($s) => $s['time']->format('H:i') === '12:00');

    expect($slotAt12['remaining'])->toBe(6);
});

// ─── Capacité atteinte ───────────────────────────────────────────────────────

it('clamps remaining to 0 when booked guests exceed capacity', function () {
    seedSettings(['capacity' => 4, 'meal_duration' => 120, 'slot_interval' => 30]);
    thursdayService('12:00:00', '15:00:00');
    makeReservation(['time' => '12:00:00', 'guests' => 6, 'status' => 'confirmed']); // overbooking

    $slotAt12 = service()->getSlots(TEST_DATE)
        ->first(fn ($s) => $s['time']->format('H:i') === '12:00');

    expect($slotAt12['remaining'])->toBe(0);
});

it('isAvailable returns false when the slot is at full capacity', function () {
    seedSettings(['capacity' => 5, 'meal_duration' => 120, 'slot_interval' => 30]);
    thursdayService('12:00:00', '15:00:00');
    makeReservation(['time' => '12:00:00', 'guests' => 5, 'status' => 'confirmed']);

    expect(service()->isAvailable(TEST_DATE, '12:00', 1))->toBeFalse();
});

it('isAvailable returns true when enough seats remain', function () {
    seedSettings(['capacity' => 10, 'meal_duration' => 120, 'slot_interval' => 30]);
    thursdayService('12:00:00', '15:00:00');
    makeReservation(['time' => '12:00:00', 'guests' => 6, 'status' => 'confirmed']);

    expect(service()->isAvailable(TEST_DATE, '12:00', 4))->toBeTrue()
        ->and(service()->isAvailable(TEST_DATE, '12:00', 5))->toBeFalse();
});

// ─── Réservation refusée / annulée libère les places ─────────────────────────

it('does not count a refused reservation toward capacity', function () {
    seedSettings(['capacity' => 5, 'meal_duration' => 120, 'slot_interval' => 30]);
    thursdayService('12:00:00', '15:00:00');

    makeReservation(['time' => '12:00:00', 'guests' => 5, 'status' => 'refused']);   // should NOT block
    makeReservation(['time' => '12:00:00', 'guests' => 3, 'status' => 'confirmed']); // counts: 3

    // remaining = 5 − 3 = 2; the refused reservation does NOT consume seats
    expect(service()->isAvailable(TEST_DATE, '12:00', 2))->toBeTrue()
        ->and(service()->isAvailable(TEST_DATE, '12:00', 3))->toBeFalse();
});

it('does not count a cancelled reservation toward capacity', function () {
    seedSettings(['capacity' => 5, 'meal_duration' => 120, 'slot_interval' => 30]);
    thursdayService('12:00:00', '15:00:00');

    makeReservation(['time' => '12:00:00', 'guests' => 5, 'status' => 'cancelled']); // should NOT block
    makeReservation(['time' => '12:00:00', 'guests' => 2, 'status' => 'confirmed']);

    expect(service()->isAvailable(TEST_DATE, '12:00', 3))->toBeTrue();
});

it('isAvailable returns false for a time not matching any slot', function () {
    seedSettings(['slot_interval' => 60, 'meal_duration' => 60]);
    thursdayService('12:00:00', '14:00:00');

    // Slots: 12:00, 13:00 — 12:15 is not a slot
    expect(service()->isAvailable(TEST_DATE, '12:15', 1))->toBeFalse();
});
