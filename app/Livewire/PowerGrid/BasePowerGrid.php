<?php

namespace App\Livewire\PowerGrid;

use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

abstract class BasePowerGrid extends PowerGridComponent
{
    public bool $deferLoading = true;

    public string $loadingComponent = 'components.powergrid-loading';

    public bool $showFilters = true;

    public function setUp(): array
    {
        return [
            PowerGrid::exportable(fileName: $this->tableName.'-export')
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            PowerGrid::header()
                ->showToggleColumns()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }
}
