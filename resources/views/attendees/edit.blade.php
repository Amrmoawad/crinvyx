<x-app-layout>
    <x-slot name="header"><h4 class="mb-0">{{ __('app.edit_attendee') }}</h4></x-slot>
    @include('partials.flash')
    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('attendees.update', $attendee) }}">
            @csrf
            @method('PUT')
            @include('partials.attendee-form', ['attendee' => $attendee, 'events' => $events, 'defaultEventId' => $defaultEventId])
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
                <a href="{{ route('attendees.index') }}" class="btn btn-outline-secondary">{{ __('app.cancel') }}</a>
            </div>
        </form>
    </div></div>
</x-app-layout>
