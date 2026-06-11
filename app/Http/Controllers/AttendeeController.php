<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendeeRequest;
use App\Http\Requests\UpdateAttendeeRequest;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AttendeeController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', Attendee::class);

        $user = auth()->user();

        return view('attendees.index', [
            'attendeesCount' => Attendee::query()->forUserEvents($user)->count(),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Attendee::class);

        $events = $this->assignedEvents();

        return view('attendees.create', [
            'events' => $events,
            'defaultEventId' => $events->count() === 1 ? $events->first()->id : null,
        ]);
    }

    public function store(StoreAttendeeRequest $request): RedirectResponse
    {
        $this->authorize('create', Attendee::class);

        Attendee::create($request->validated());

        return redirect()->route('attendees.index')->with('status', 'attendee-saved');
    }

    public function show(Attendee $attendee): View
    {
        $this->authorize('view', $attendee);

        $attendee->load(['event', 'creator']);

        return view('attendees.show', compact('attendee'));
    }

    public function edit(Attendee $attendee): View
    {
        $this->authorize('update', $attendee);

        $events = $this->assignedEvents();

        return view('attendees.edit', [
            'attendee' => $attendee,
            'events' => $events,
            'defaultEventId' => $events->count() === 1 ? $events->first()->id : null,
        ]);
    }

    public function update(UpdateAttendeeRequest $request, Attendee $attendee): RedirectResponse
    {
        $this->authorize('update', $attendee);

        $attendee->update($request->validated());

        return redirect()->route('attendees.index')->with('status', 'attendee-saved');
    }

    public function destroy(Attendee $attendee): RedirectResponse
    {
        $this->authorize('delete', $attendee);

        $attendee->delete();

        return redirect()->route('attendees.index')->with('status', 'attendee-deleted');
    }

    private function assignedEvents()
    {
        return Event::query()
            ->whereIn('id', auth()->user()->assignedEventIds())
            ->where('active', true)
            ->orderBy('name')
            ->get();
    }
}
