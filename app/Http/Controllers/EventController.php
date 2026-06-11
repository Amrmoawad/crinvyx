<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Event::class);

        return view('events.index', [
            'eventsCount' => Event::count(),
            'activeEventsCount' => Event::where('active', true)->count(),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Event::class);

        return view('events.create');
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $this->authorize('create', Event::class);

        Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'active' => $request->boolean('active', true),
        ]);

        return redirect()->route('events.index')->with('status', 'event-saved');
    }

    public function show(Event $event): View
    {
        $this->authorize('view', $event);

        $event->load(['creator', 'updater']);

        return view('events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        $this->authorize('update', $event);

        return view('events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $event->update([
            'name' => $request->name,
            'description' => $request->description,
            'active' => $request->boolean('active'),
        ]);

        return redirect()->route('events.index')->with('status', 'event-saved');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('events.index')->with('status', 'event-deleted');
    }
}
