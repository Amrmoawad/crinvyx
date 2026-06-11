<?php

namespace App\Livewire;

use App\Livewire\PowerGrid\BasePowerGrid;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class EventsTable extends BasePowerGrid
{
    public string $tableName = 'events-table';

    public function datasource(): Builder
    {
        return Event::query()
            ->with('creator')
            ->orderByDesc('created_at');
    }

    public function relationSearch(): array
    {
        return [
            'creator' => ['full_name', 'username'],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('active_badge', function (Event $event) {
                $label = $event->active ? __('app.active') : __('app.inactive');
                $class = $event->active ? 'bg-label-success' : 'bg-label-secondary';

                return new HtmlString('<span class="badge '.$class.'">'.e($label).'</span>');
            })
            ->add('created_by_name', fn (Event $event) => $event->creator?->full_name ?? '—')
            ->add('created_at_formatted', fn (Event $event) => optional($event->created_at)->format('Y-m-d H:i'))
            ->add('actions_html', fn (Event $event) => $this->renderActions($event));
    }

    public function columns(): array
    {
        return [
            Column::make(__('app.id'), 'id')->sortable(),
            Column::make(__('app.event_name'), 'name')->sortable()->searchable(),
            Column::add()->title(__('app.active'))->field('active_badge', 'active')->sortable(),
            Column::make(__('app.created_by'), 'created_by_name'),
            Column::make(__('app.created_at'), 'created_at_formatted', 'created_at')->sortable(),
            Column::make(__('app.actions'), 'actions_html'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')->placeholder(__('app.event_name')),
            Filter::boolean('active')->label(__('app.active'), __('app.inactive')),
            Filter::datetimepicker('created_at_formatted', 'created_at'),
        ];
    }

    private function renderActions(Event $event): HtmlString
    {
        $html = '<div class="d-flex flex-wrap gap-1">'
            .'<a href="'.e(route('events.show', $event)).'" class="btn btn-sm btn-info">'.e(__('app.view')).'</a>'
            .'<a href="'.e(route('events.edit', $event)).'" class="btn btn-sm btn-primary">'.e(__('app.edit')).'</a>'
            .'<form method="POST" action="'.e(route('events.destroy', $event)).'" class="d-inline" onsubmit="return confirm('.e(json_encode(__('app.confirm_delete'))).')">'
            .'<input type="hidden" name="_token" value="'.e(csrf_token()).'">'
            .'<input type="hidden" name="_method" value="DELETE">'
            .'<button type="submit" class="btn btn-sm btn-danger">'.e(__('app.delete')).'</button>'
            .'</form>'
            .'</div>';

        return new HtmlString($html);
    }
}
