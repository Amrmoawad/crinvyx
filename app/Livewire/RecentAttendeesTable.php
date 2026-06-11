<?php

namespace App\Livewire;

use App\Livewire\PowerGrid\BasePowerGrid;
use App\Models\Attendee;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class RecentAttendeesTable extends BasePowerGrid
{
    public string $tableName = 'recent-attendees-table';

    /** @var array<int> */
    public array $eventIds = [];

    public function setUp(): array
    {
        return [
            \PowerComponents\LivewirePowerGrid\Facades\PowerGrid::header()
                ->showSearchInput(),
            \PowerComponents\LivewirePowerGrid\Facades\PowerGrid::footer()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        $query = Attendee::query()
            ->forUserEvents(auth()->user())
            ->with(['event', 'creator'])
            ->orderByDesc('created_at')
            ->limit(10);

        if (! empty($this->eventIds)) {
            $query->whereIn('event_id', $this->eventIds);
        }

        return $query;
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('event_name', fn (Attendee $attendee) => $attendee->event?->name ?? '—')
            ->add('name')
            ->add('city')
            ->add('year')
            ->add('month')
            ->add('day')
            ->add('created_by_name', fn (Attendee $attendee) => $attendee->creator?->full_name ?? '—')
            ->add('created_at_formatted', fn (Attendee $attendee) => optional($attendee->created_at)->format('Y-m-d H:i'));
    }

    public function columns(): array
    {
        return [
            Column::make(__('app.id'), 'id')->sortable()->hidden(),
            Column::make(__('app.event'), 'event_name'),
            Column::make(__('app.name'), 'name')->searchable(),
            Column::make(__('app.city'), 'city'),
            Column::make(__('app.year'), 'year'),
            Column::make(__('app.month'), 'month'),
            Column::make(__('app.day'), 'day'),
            Column::make(__('app.created_by'), 'created_by_name'),
            Column::make(__('app.created_at'), 'created_at_formatted', 'created_at'),
        ];
    }
}
