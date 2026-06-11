@php($selectedEvents = old('event_ids', isset($user) ? $user->events->pluck('id')->all() : []))

<div class="row g-4">
    <div class="col-md-6">
        <div class="form-floating form-floating-outline">
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username ?? '') }}" required>
            <label for="username">{{ __('app.username') }}</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-floating form-floating-outline">
            <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name', $user->full_name ?? '') }}" required>
            <label for="full_name">{{ __('app.full_name') }}</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-floating form-floating-outline">
            <input type="password" name="password" id="password" class="form-control" @isset($user) @else required @endisset>
            <label for="password">{{ isset($user) ? __('app.new_password') : __('app.password') }}</label>
        </div>
    </div>
    @isset($user)
    <div class="col-md-6">
        <div class="form-floating form-floating-outline">
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            <label for="password_confirmation">{{ __('app.confirm_password') }}</label>
        </div>
    </div>
    @else
    <div class="col-md-6">
        <div class="form-floating form-floating-outline">
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            <label for="password_confirmation">{{ __('app.confirm_password') }}</label>
        </div>
    </div>
    @endisset

    <div class="col-12">
        <label class="form-label d-block">{{ __('app.permissions') }}</label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="access_create_users" id="access_create_users" value="1" @checked(old('access_create_users', $user->access_create_users ?? false))>
            <label class="form-check-label" for="access_create_users">{{ __('app.access_create_users') }}</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="access_manage_events" id="access_manage_events" value="1" @checked(old('access_manage_events', $user->access_manage_events ?? false))>
            <label class="form-check-label" for="access_manage_events">{{ __('app.access_manage_events') }}</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="access_record_attendees" id="access_record_attendees" value="1" @checked(old('access_record_attendees', $user->access_record_attendees ?? false))>
            <label class="form-check-label" for="access_record_attendees">{{ __('app.access_record_attendees') }}</label>
        </div>
    </div>

    <div class="col-12">
        <label for="event_ids" class="form-label">{{ __('app.accessible_events') }}</label>
        <select name="event_ids[]" id="event_ids" class="form-select tom-select-multi" multiple>
            @foreach ($events as $event)
                <option value="{{ $event->id }}" @selected(in_array($event->id, $selectedEvents))>{{ $event->name }}</option>
            @endforeach
        </select>
    </div>
</div>
