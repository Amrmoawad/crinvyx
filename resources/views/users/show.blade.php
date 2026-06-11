<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ __('app.user_details') }}</h4>
            <div class="d-flex gap-2">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">{{ __('app.edit') }}</a>
                @if ($user->id !== auth()->id())
                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm(@json(__('app.confirm_delete')))">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('app.delete') }}</button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">{{ __('app.username') }}</dt>
                <dd class="col-sm-9">{{ $user->username }}</dd>
                <dt class="col-sm-3">{{ __('app.full_name') }}</dt>
                <dd class="col-sm-9">{{ $user->full_name }}</dd>
                <dt class="col-sm-3">{{ __('app.permissions') }}</dt>
                <dd class="col-sm-9">
                    <ul class="mb-0">
                        @if ($user->access_create_users)<li>{{ __('app.access_create_users') }}</li>@endif
                        @if ($user->access_manage_events)<li>{{ __('app.access_manage_events') }}</li>@endif
                        @if ($user->access_record_attendees)<li>{{ __('app.access_record_attendees') }}</li>@endif
                    </ul>
                </dd>
                <dt class="col-sm-3">{{ __('app.accessible_events') }}</dt>
                <dd class="col-sm-9">{{ $user->events->pluck('name')->implode(', ') ?: '—' }}</dd>
            </dl>
        </div>
    </div>
</x-app-layout>
