<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ __('app.attendee_details') }}</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('attendees.edit', $attendee) }}" class="btn btn-primary">{{ __('app.edit') }}</a>
                <form method="POST" action="{{ route('attendees.destroy', $attendee) }}" onsubmit="return confirm(@json(__('app.confirm_delete')))">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('app.delete') }}</button>
                </form>
            </div>
        </div>
    </x-slot>
    <div class="card"><div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">{{ __('app.event') }}</dt><dd class="col-sm-9">{{ $attendee->event?->name }}</dd>
            <dt class="col-sm-3">{{ __('app.name') }}</dt><dd class="col-sm-9">{{ $attendee->name }}</dd>
            <dt class="col-sm-3">{{ __('app.city') }}</dt><dd class="col-sm-9">{{ $attendee->city ?? '—' }}</dd>
            <dt class="col-sm-3">{{ __('app.home_group') }}</dt><dd class="col-sm-9">{{ $attendee->home_group ?? '—' }}</dd>
            <dt class="col-sm-3">{{ __('app.service_type') }}</dt><dd class="col-sm-9">{{ $attendee->service_type ?? '—' }}</dd>
            <dt class="col-sm-3">{{ __('app.date') }}</dt><dd class="col-sm-9">{{ $attendee->year }}-{{ $attendee->month }}-{{ $attendee->day }}</dd>
            <dt class="col-sm-3">{{ __('app.created_by') }}</dt><dd class="col-sm-9">{{ $attendee->creator?->full_name }}</dd>
        </dl>
    </div></div>
</x-app-layout>
