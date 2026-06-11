<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-0">{{ __('app.add_user') }}</h4>
    </x-slot>

    @include('partials.flash')

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                @include('partials.user-form', ['events' => $events])
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">{{ __('app.cancel') }}</a>
                </div>
            </form>
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
