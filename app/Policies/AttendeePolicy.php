<?php

namespace App\Policies;

use App\Models\Attendee;
use App\Models\User;

class AttendeePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->canRecordAttendees();
    }

    public function view(User $user, Attendee $attendee): bool
    {
        return $user->canRecordAttendees()
            && in_array($attendee->event_id, $user->assignedEventIds(), true);
    }

    public function create(User $user): bool
    {
        return $user->canRecordAttendees() && count($user->assignedEventIds()) > 0;
    }

    public function update(User $user, Attendee $attendee): bool
    {
        return $this->view($user, $attendee);
    }

    public function delete(User $user, Attendee $attendee): bool
    {
        return $this->view($user, $attendee);
    }
}
