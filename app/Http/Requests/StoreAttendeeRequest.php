<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttendeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canRecordAttendees() ?? false;
    }

    public function rules(): array
    {
        $allowedEvents = $this->user()?->assignedEventIds() ?? [];

        return [
            'event_id' => ['required', 'integer', Rule::in($allowedEvents)],
            'name' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', Rule::in(config('attendee_cities'))],
            'home_group' => ['nullable', 'string', 'max:255'],
            'service_type' => ['nullable', 'string', Rule::in(config('attendee_service_types'))],
            'year' => ['required', 'integer', 'min:0'],
            'month' => ['required', 'integer', 'min:0'],
            'day' => ['required', 'integer', 'min:0'],
        ];
    }
}
