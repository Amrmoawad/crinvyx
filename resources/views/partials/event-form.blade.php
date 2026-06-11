<div class="row g-4">
    <div class="col-md-6">
        <div class="form-floating form-floating-outline">
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $event->name ?? '') }}" required>
            <label for="name">{{ __('app.event_name') }}</label>
        </div>
    </div>
    <div class="col-12">
        <div class="form-floating form-floating-outline">
            <textarea name="description" id="description" class="form-control" style="height: 120px">{{ old('description', $event->description ?? '') }}</textarea>
            <label for="description">{{ __('app.description') }}</label>
        </div>
    </div>
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="active" id="active" value="1" @checked(old('active', $event->active ?? true))>
            <label class="form-check-label" for="active">{{ __('app.active') }}</label>
        </div>
    </div>
</div>
