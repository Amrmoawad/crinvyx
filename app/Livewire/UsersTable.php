<?php

namespace App\Livewire;

use App\Livewire\PowerGrid\BasePowerGrid;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

class UsersTable extends BasePowerGrid
{
    public string $tableName = 'users-table';

    public function datasource(): Builder
    {
        return User::query()->orderByDesc('created_at');
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('username')
            ->add('full_name')
            ->add('permissions_summary', function (User $user) {
                $permissions = collect([
                    $user->access_create_users ? __('app.access_create_users') : null,
                    $user->access_manage_events ? __('app.access_manage_events') : null,
                    $user->access_record_attendees ? __('app.access_record_attendees') : null,
                ])->filter()->implode(', ');

                return $permissions ?: '—';
            })
            ->add('created_at_formatted', fn (User $user) => optional($user->created_at)->format('Y-m-d H:i'))
            ->add('actions_html', fn (User $user) => $this->renderActions($user));
    }

    public function columns(): array
    {
        return [
            Column::make(__('app.id'), 'id')->sortable()->hidden(),
            Column::make(__('app.username'), 'username')->sortable()->searchable(),
            Column::make(__('app.full_name'), 'full_name')->sortable()->searchable(),
            Column::make(__('app.permissions'), 'permissions_summary'),
            Column::make(__('app.created_at'), 'created_at_formatted', 'created_at')->sortable(),
            Column::make(__('app.actions'), 'actions_html'),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('username')->placeholder(__('app.username')),
            Filter::inputText('full_name')->placeholder(__('app.full_name')),
            Filter::datetimepicker('created_at_formatted', 'created_at'),
        ];
    }

    private function renderActions(User $user): HtmlString
    {
        $buttons = '<div class="d-flex flex-wrap gap-1">'
            .'<a href="'.e(route('users.show', $user)).'" class="btn btn-sm btn-info">'.e(__('app.view')).'</a>'
            .'<a href="'.e(route('users.edit', $user)).'" class="btn btn-sm btn-primary">'.e(__('app.edit')).'</a>';

        if ($user->id !== auth()->id()) {
            $buttons .= '<form method="POST" action="'.e(route('users.destroy', $user)).'" class="d-inline" onsubmit="return confirm('.e(json_encode(__('app.confirm_delete'))).')">'
                .'<input type="hidden" name="_token" value="'.e(csrf_token()).'">'
                .'<input type="hidden" name="_method" value="DELETE">'
                .'<button type="submit" class="btn btn-sm btn-danger">'.e(__('app.delete')).'</button>'
                .'</form>';
        }

        $buttons .= '</div>';

        return new HtmlString($buttons);
    }
}
