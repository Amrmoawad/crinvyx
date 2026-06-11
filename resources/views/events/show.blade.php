<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ __('app.event_details') }}</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('events.edit', $event) }}" class="btn btn-primary">{{ __('app.edit') }}</a>
                <form method="POST" action="{{ route('events.destroy', $event) }}" onsubmit="return confirm(@json(__('app.confirm_delete')))">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('app.delete') }}</button>
                </form>
            </div>
        </div>
    </x-slot>
    <div class="card"><div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">{{ __('app.event_name') }}</dt><dd class="col-sm-9">{{ $event->name }}</dd>
            <dt class="col-sm-3">{{ __('app.description') }}</dt><dd class="col-sm-9">{{ $event->description ?? '—' }}</dd>
            <dt class="col-sm-3">{{ __('app.active') }}</dt><dd class="col-sm-9">{{ $event->active ? __('app.yes') : __('app.no') }}</dd>
            <dt class="col-sm-3">{{ __('app.created_by') }}</dt><dd class="col-sm-9">{{ $event->creator?->full_name ?? '—' }}</dd>
            <dt class="col-sm-3">{{ __('app.updated_by') }}</dt><dd class="col-sm-9">{{ $event->updater?->full_name ?? '—' }}</dd>
        </dl>
    </div></div>
</x-app-layout>
