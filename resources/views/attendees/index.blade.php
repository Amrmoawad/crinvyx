<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ __('app.attendees_management') }}</h4>
            <a href="{{ route('attendees.create') }}" class="btn btn-primary btn-lg attendees-add-btn d-inline-flex align-items-center justify-content-center gap-2 fw-semibold shadow-sm">
                <i class="ri-user-add-line fs-5"></i>
                <span>{{ __('app.add_attendee') }}</span>
            </a>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card"><div class="card-body">
                <p class="text-heading mb-1">{{ __('app.total_attendees') }}</p>
                <h4 class="mb-0">{{ $attendeesCount }}</h4>
            </div></div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <livewire:attendees-table />
        </div>
    </div>

    @push('page-css')
        <style>
            .attendees-add-btn {
                min-width: 13.5rem;
                padding-inline: 2rem;
                border-radius: 0.75rem;
                transition: transform 0.15s ease, box-shadow 0.15s ease;
            }

            .attendees-add-btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 0.5rem 1.25rem rgba(var(--bs-primary-rgb), 0.35) !important;
            }
        </style>
    @endpush
</x-app-layout>
