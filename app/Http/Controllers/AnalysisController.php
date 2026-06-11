<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Event;
use App\Support\AttendeeTenure;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnalysisController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $assignedEventIds = $user->assignedEventIds();

        $events = Event::query()
            ->whereIn('id', $assignedEventIds)
            ->orderBy('name')
            ->get();

        $selectedEventId = (int) $request->input('event_id');
        if (! in_array($selectedEventId, $assignedEventIds, true)) {
            $selectedEventId = $events->first()?->id ?? 0;
        }

        $selectedEvent = $events->firstWhere('id', $selectedEventId);

        $totalTime = ['years' => 0, 'months' => 0, 'days' => 0, 'attendees' => 0];
        $byServiceType = collect();
        $byCity = collect();
        $serviceTypeCards = collect(config('attendee_service_types', []))
            ->map(fn (string $serviceType) => (object) [
                'service_type' => $serviceType,
                'cities' => collect(),
                'attendees' => 0,
            ]);
        $longestTenureAttendee = null;

        if ($selectedEventId) {
            $attendeesQuery = Attendee::query()
                ->forUserEvents($user)
                ->where('event_id', $selectedEventId);

            $totalTime = AttendeeTenure::sum($attendeesQuery);
            $byServiceType = AttendeeTenure::groupedBy($attendeesQuery, 'service_type');
            $byCity = AttendeeTenure::groupedBy($attendeesQuery, 'city');
            $serviceTypeCards = AttendeeTenure::serviceTypeCityBreakdown($attendeesQuery);
            $longestTenureAttendee = AttendeeTenure::longestAttendee($attendeesQuery);
        }

        return view('analysis', [
            'events' => $events,
            'selectedEventId' => $selectedEventId,
            'selectedEvent' => $selectedEvent,
            'totalTime' => $totalTime,
            'byServiceType' => $byServiceType,
            'byCity' => $byCity,
            'serviceTypeCards' => $serviceTypeCards,
            'longestTenureAttendee' => $longestTenureAttendee,
        ]);
    }
}
