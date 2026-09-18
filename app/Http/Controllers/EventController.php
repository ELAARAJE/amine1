<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::where('is_published', true)
            ->where('starts_at', '>', now())
            ->orderBy('starts_at')
            ->get();

        return view('events.index', compact('events'));
    }

    public function show(string $slug): View|RedirectResponse
    {
        $event = Event::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('events.show', compact('event'));
    }
}
