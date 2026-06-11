<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ __('app.users_management') }}</h4>
            <a href="{{ route('users.create') }}" class="btn btn-primary">{{ __('app.add_user') }}</a>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <p class="text-heading mb-1">{{ __('app.total_users') }}</p>
                    <h4 class="mb-0">{{ $usersCount }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <livewire:users-table />
        </div>
    </div>
</x-app-layout>
