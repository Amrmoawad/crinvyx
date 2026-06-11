@php($selectedEvent = old('event_id', $attendee->event_id ?? ($defaultEventId ?? null)))
@php($hideEventSelect = isset($defaultEventId) && $defaultEventId && ! isset($attendee))
@php($cities = config('attendee_cities'))
@php($selectedCity = old('city', $attendee->city ?? ''))
@php($serviceTypes = config('attendee_service_types'))
@php($selectedServiceType = old('service_type', $attendee->service_type ?? ''))

<div class="row g-4">
    @if ($hideEventSelect)
        <input type="hidden" name="event_id" value="{{ $defaultEventId }}">
        <div class="col-12">
            <p class="mb-0"><strong>{{ __('app.event') }}:</strong> {{ $events->first()->name }}</p>
        </div>
    @else
        <div class="col-md-6">
            <label for="event_id" class="form-label">{{ __('app.event') }}</label>
            <select name="event_id" id="event_id" class="form-select" required>
                <option value="">{{ __('app.select_event') }}</option>
                @foreach ($events as $event)
                    <option value="{{ $event->id }}" @selected((int) $selectedEvent === $event->id)>{{ $event->name }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <div class="col-md-6">
        <label for="name" class="form-label">{{ __('app.name') }}</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $attendee->name ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label for="city" class="form-label">{{ __('app.city') }}</label>
        <select name="city" id="city" class="form-select select2">
            <option value="">{{ __('app.select_city') }}</option>
            @foreach ($cities as $city)
                <option value="{{ $city }}" @selected($selectedCity === $city)>{{ $city }}</option>
            @endforeach
            @if ($selectedCity && ! in_array($selectedCity, $cities, true))
                <option value="{{ $selectedCity }}" selected>{{ $selectedCity }}</option>
            @endif
        </select>
    </div>

    <div class="col-md-6">
        <label for="home_group" class="form-label">{{ __('app.home_group') }}</label>
        <input type="text" name="home_group" id="home_group" class="form-control" value="{{ old('home_group', $attendee->home_group ?? '') }}">
    </div>

    <div class="col-md-6">
        <label for="service_type" class="form-label">{{ __('app.service_type') }}</label>
        <select name="service_type" id="service_type" class="form-select select2">
            <option value="">{{ __('app.select_service_type') }}</option>
            @foreach ($serviceTypes as $serviceType)
                <option value="{{ $serviceType }}" @selected($selectedServiceType === $serviceType)>{{ $serviceType }}</option>
            @endforeach
            @if ($selectedServiceType && ! in_array($selectedServiceType, $serviceTypes, true))
                <option value="{{ $selectedServiceType }}" selected>{{ $selectedServiceType }}</option>
            @endif
        </select>
    </div>

    <div class="w-100"></div>

    <div class="col-md-4">
        <label for="year" class="form-label">{{ __('app.year') }}</label>
        <input
            type="text"
            name="year"
            id="year"
            class="form-control integer-only"
            inputmode="numeric"
            pattern="[0-9]*"
            autocomplete="off"
            value="{{ old('year', isset($attendee) ? $attendee->year : '') }}"
            required>
    </div>

    <div class="col-md-4">
        <label for="month" class="form-label">{{ __('app.month') }}</label>
        <input
            type="text"
            name="month"
            id="month"
            class="form-control integer-only"
            inputmode="numeric"
            pattern="[0-9]*"
            autocomplete="off"
            value="{{ old('month', isset($attendee) ? $attendee->month : '') }}"
            required>
    </div>

    <div class="col-md-4">
        <label for="day" class="form-label">{{ __('app.day') }}</label>
        <input
            type="text"
            name="day"
            id="day"
            class="form-control integer-only"
            inputmode="numeric"
            pattern="[0-9]*"
            autocomplete="off"
            value="{{ old('day', isset($attendee) ? $attendee->day : '') }}"
            required>
    </div>
</div>

@push('vendor-css')
    <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/select2/select2.css') }}">
@endpush

@push('vendor-js')
    <script src="{{ asset('materialize/assets/vendor/libs/select2/select2.js') }}"></script>
@endpush

@push('page-js')
    <script>
        $(function () {
            if (typeof $.fn.select2 !== 'function') {
                return;
            }

            const selects = [
                { el: '#city', placeholder: @json(__('app.select_city')) },
                { el: '#service_type', placeholder: @json(__('app.select_service_type')) },
            ];

            selects.forEach(({ el, placeholder }) => {
                const $select = $(el);

                if (!$select.length) {
                    return;
                }

                $select.wrap('<div class="position-relative"></div>').select2({
                    placeholder,
                    allowClear: true,
                    dropdownParent: $select.parent(),
                    width: '100%',
                });
            });
        });
    </script>
@endpush
