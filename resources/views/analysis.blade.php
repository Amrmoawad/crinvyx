@php
    $formatTenure = fn (array $totals) => \App\Support\AttendeeTenure::format($totals);
    $toTenureArray = fn (object $row) => [
        'years' => $row->years,
        'months' => $row->months,
        'days' => $row->days,
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <h4 class="mb-0">{{ __('app.analysis') }}</h4>
    </x-slot>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('analysis') }}" class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label for="event_id" class="form-label">{{ __('app.filter_by_event') }}</label>
                    <select name="event_id" id="event_id" class="form-select" @disabled($events->isEmpty())>
                        @forelse ($events as $event)
                            <option value="{{ $event->id }}" @selected($selectedEventId === $event->id)>{{ $event->name }}</option>
                        @empty
                            <option value="">{{ __('app.no_events_available') }}</option>
                        @endforelse
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary" @disabled($events->isEmpty())>{{ __('app.filter') }}</button>
                    @if ($selectedEventId)
                        <a href="{{ route('analysis') }}" class="btn btn-outline-secondary">{{ __('app.clear') }}</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if ($events->isEmpty())
        <div class="alert alert-info mb-0">{{ __('app.no_events_available') }}</div>
    @elseif ($selectedEvent)
        <div class="row g-4 mb-4 justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="card border-primary border-2">
                    <div class="card-body text-center py-5">
                        <p class="text-heading fs-4 fw-semibold mb-2">{{ __('app.total_time') }}</p>
                        <p class="text-muted fs-5 mb-3">{{ $selectedEvent->name }}</p>
                        <p class="display-4 fw-bold text-primary mb-4">{{ $formatTenure($totalTime) }}</p>
                        <span class="badge bg-label-primary fs-4 px-4 py-3">{{ __('app.attendees_count', ['count' => $totalTime['attendees']]) }}</span>

                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            @foreach ($serviceTypeCards as $card)
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center gap-2">
                            <h6 class="mb-0">{{ $card->service_type }}</h6>
                            <span class="badge bg-label-primary">{{ $card->attendees }}</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('app.city') }}</th>
                                            <th class="text-end">{{ __('app.attendees') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($card->cities as $cityRow)
                                            <tr>
                                                <td>{{ $cityRow->city }}</td>
                                                <td class="text-end">{{ $cityRow->attendees }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center text-muted py-3">{{ __('app.no_data_for_event') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('app.total_time_per_service_type') }}</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('app.service_type') }}</th>
                                        <th>{{ __('app.total_time') }}</th>
                                        <th class="text-end">{{ __('app.attendees') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($byServiceType as $row)
                                        <tr>
                                            <td>{{ $row->label }}</td>
                                            <td>{{ $formatTenure($toTenureArray($row)) }}</td>
                                            <td class="text-end">{{ $row->attendees }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">{{ __('app.no_data_for_event') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('app.total_time_per_city') }}</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('app.city') }}</th>
                                        <th>{{ __('app.total_time') }}</th>
                                        <th class="text-end">{{ __('app.attendees') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($byCity as $row)
                                        <tr>
                                            <td>{{ $row->label }}</td>
                                            <td>{{ $formatTenure($toTenureArray($row)) }}</td>
                                            <td class="text-end">{{ $row->attendees }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">{{ __('app.no_data_for_event') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
