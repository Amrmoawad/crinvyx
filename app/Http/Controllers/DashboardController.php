<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $assignedEventIds = $user->assignedEventIds();

        $eventsQuery = Event::query()->whereIn('id', $assignedEventIds);
        $attendeesQuery = Attendee::query()->forUserEvents($user);

        $selectedEventIds = collect($request->input('event_ids', []))
            ->filter(fn ($id) => in_array((int) $id, $assignedEventIds, true))
            ->map(fn ($id) => (int) $id)
            ->values()
            ->all();

        if (! empty($selectedEventIds)) {
            $attendeesQuery->whereIn('event_id', $selectedEventIds);
        }

        return view('dashboard', [
            'totalEvents' => $eventsQuery->count(),
            'totalAttendees' => (clone $attendeesQuery)->count(),
            'todayAttendees' => (clone $attendeesQuery)->createdToday()->count(),
            'totalUsers' => $user->canManageUsers() ? User::count() : 0,
            'filterEvents' => Event::query()->whereIn('id', $assignedEventIds)->orderBy('name')->get(),
            'selectedEventIds' => $selectedEventIds,
            'canManageUsers' => $user->canManageUsers(),
        ]);
    }
}
