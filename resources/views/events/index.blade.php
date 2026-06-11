<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ __('app.events_management') }}</h4>
            <a href="{{ route('events.create') }}" class="btn btn-primary">{{ __('app.add_event') }}</a>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card"><div class="card-body">
                <p class="text-heading mb-1">{{ __('app.total_events') }}</p>
                <h4 class="mb-0">{{ $eventsCount }}</h4>
            </div></div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card"><div class="card-body">
                <p class="text-heading mb-1">{{ __('app.active_events') }}</p>
                <h4 class="mb-0">{{ $activeEventsCount }}</h4>
            </div></div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <livewire:events-table />
        </div>
    </div>
</x-app-layout>
