<x-app-layout>
    <x-slot name="header"><h4 class="mb-0">{{ __('app.edit_event') }}</h4></x-slot>
    @include('partials.flash')
    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('events.update', $event) }}">
            @csrf
            @method('PUT')
            @include('partials.event-form', ['event' => $event])
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
                <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">{{ __('app.cancel') }}</a>
            </div>
        </form>
    </div></div>
</x-app-layout>
