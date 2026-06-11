<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManageUsers() ?? false;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($userId)],
            'full_name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'access_create_users' => ['sometimes', 'boolean'],
            'access_manage_events' => ['sometimes', 'boolean'],
            'access_record_attendees' => ['sometimes', 'boolean'],
            'event_ids' => ['nullable', 'array'],
            'event_ids.*' => ['integer', Rule::exists('events', 'id')],
        ];
    }
}
