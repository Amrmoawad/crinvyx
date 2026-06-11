<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-0">{{ __('app.dashboard') }}</h4>
    </x-slot>

    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card"><div class="card-body">
                <p class="text-heading mb-1">{{ __('app.total_events') }}</p>
                <h4 class="mb-0">{{ $totalEvents }}</h4>
            </div></div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card"><div class="card-body">
                <p class="text-heading mb-1">{{ __('app.total_attendees') }}</p>
                <h4 class="mb-0">{{ $totalAttendees }}</h4>
            </div></div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card"><div class="card-body">
                <p class="text-heading mb-1">{{ __('app.todays_attendees') }}</p>
                <h4 class="mb-0">{{ $todayAttendees }}</h4>
            </div></div>
        </div>
        @if ($canManageUsers)
        <div class="col-sm-6 col-xl-3">
            <div class="card"><div class="card-body">
                <p class="text-heading mb-1">{{ __('app.total_users') }}</p>
                <h4 class="mb-0">{{ $totalUsers }}</h4>
            </div></div>
        </div>
        @endif
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard') }}" class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label for="event_ids" class="form-label">{{ __('app.filter_by_events') }}</label>
                    <select name="event_ids[]" id="event_ids" class="form-select tom-select-multi" multiple>
                        @foreach ($filterEvents as $event)
                            <option value="{{ $event->id }}" @selected(in_array($event->id, $selectedEventIds))>{{ $event->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">{{ __('app.filter') }}</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">{{ __('app.clear') }}</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ __('app.recent_attendees') }}</h5>
        </div>
        <div class="card-body">
            <livewire:recent-attendees-table :event-ids="$selectedEventIds" />
        </div>
    </div>

    @push('page-js')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                if (window.TomSelect && document.getElementById('event_ids')) {
                    new TomSelect('#event_ids', { plugins: ['remove_button'], persist: false });
                }
            });
        </script>
    @endpush
</x-app-layout>
