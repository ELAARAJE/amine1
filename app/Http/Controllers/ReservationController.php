<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(): View
    {
        $reservations = auth()->user()
            ->reservations()
            ->orderByDesc('date')
            ->orderByDesc('time')
            ->paginate(10);

        return view('reservation.my-reservations', compact('reservations'));
    }

    public function cancel(Reservation $reservation): RedirectResponse
    {
        abort_if($reservation->user_id !== auth()->id(), 403);

        $reservationAt = Carbon::parse($reservation->date)
            ->setTimeFromTimeString($reservation->time);

        abort_if(
            $reservationAt->isPast() || !in_array($reservation->status, ['pending', 'confirmed']),
            403,
            'Cette réservation ne peut pas être annulée.'
        );

        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('reservation.history')
            ->with('success', 'Votre réservation a bien été annulée.');
    }
}
