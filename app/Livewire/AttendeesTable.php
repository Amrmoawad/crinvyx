<?php

namespace App\Livewire;

use App\Livewire\PowerGrid\BasePowerGrid;
use App\Models\Attendee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class AttendeesTable extends BasePowerGrid
{
    public string $tableName = 'attendees-table';

    public function datasource(): Builder
    {
        return Attendee::query()
            ->forUserEvents(auth()->user())
            ->with(['event', 'creator'])
            ->orderByDesc('created_at');
    }

    public function relationSearch(): array
    {
        return [
            'event' => ['name'],
            'creator' => ['full_name', 'username'],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('event_name', fn (Attendee $attendee) => $attendee->event?->name ?? '—')
            ->add('name')
            ->add('city')
            ->add('home_group')
            ->add('service_type')
            ->add('year')
            ->add('month')
            ->add('day')
            ->add('created_by_name', fn (Attendee $attendee) => $attendee->creator?->full_name ?? '—')
            ->add('created_at_formatted', fn (Attendee $attendee) => optional($attendee->created_at)->format('Y-m-d H:i'))
            ->add('actions_html', fn (Attendee $attendee) => $this->renderActions($attendee));
    }

    public function columns(): array
    {
        return [
            Column::make(__('app.id'), 'id')->sortable(),
            Column::make(__('app.event'), 'event_name')->searchable(),
            Column::make(__('app.name'), 'name')->sortable()->searchable(),
            Column::make(__('app.city'), 'city')->sortable()->searchable(),
            Column::make(__('app.home_group'), 'home_group')->sortable()->searchable(),
            Column::make(__('app.service_type'), 'service_type')->sortable()->searchable(),
            Column::make(__('app.year'), 'year')->sortable(),
            Column::make(__('app.month'), 'month')->sortable(),
            Column::make(__('app.day'), 'day')->sortable(),
            Column::make(__('app.created_by'), 'created_by_name'),
            Column::make(__('app.created_at'), 'created_at_formatted', 'created_at')->sortable(),
            Column::make(__('app.actions'), 'actions_html'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')->placeholder(__('app.name')),
            Filter::inputText('city')->placeholder(__('app.city')),
            Filter::inputText('home_group')->placeholder(__('app.home_group')),
            Filter::inputText('service_type')->placeholder(__('app.service_type')),
            Filter::number('year', 'year'),
            Filter::number('month', 'month'),
            Filter::number('day', 'day'),
            Filter::datetimepicker('created_at_formatted', 'created_at'),
        ];
    }

    private function renderActions(Attendee $attendee): HtmlString
    {
        $html = '<div class="d-flex flex-wrap gap-1">'
            .'<a href="'.e(route('attendees.show', $attendee)).'" class="btn btn-sm btn-info">'.e(__('app.view')).'</a>'
            .'<a href="'.e(route('attendees.edit', $attendee)).'" class="btn btn-sm btn-primary">'.e(__('app.edit')).'</a>'
            .'<form method="POST" action="'.e(route('attendees.destroy', $attendee)).'" class="d-inline" onsubmit="return confirm('.e(json_encode(__('app.confirm_delete'))).')">'
            .'<input type="hidden" name="_token" value="'.e(csrf_token()).'">'
            .'<input type="hidden" name="_method" value="DELETE">'
            .'<button type="submit" class="btn btn-sm btn-danger">'.e(__('app.delete')).'</button>'
            .'</form>'
            .'</div>';

        return new HtmlString($html);
    }
}
