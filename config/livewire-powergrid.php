<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    |
    | PowerGrid supports Tailwind and Bootstrap 5 themes.
    | Configure here the theme of your choice.
    */
    'theme' => \PowerComponents\LivewirePowerGrid\Themes\Bootstrap5::class,

    'cache_ttl' => null,

    'icon_resources' => [
        'paths' => [],
        'allowed' => [],
        'attributes' => ['class' => 'w-5 text-red-600'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins
    |--------------------------------------------------------------------------
    |
    | Plugins used: flatpickr.js to datepicker.
    |
    */
    'plugins' => [
        'flatpickr' => [
            'locales' => [],
        ],
        'select' => [
            'default' => 'tom',
            'tom' => [
                'plugins' => [
                    'clear_button' => [
                        'title' => 'Remove all selected options',
                    ],
                ],
            ],
            'slim' => [
                'settings' => [
                    'alwaysOpen' => false,
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    |
    | PowerGrid supports inline and outside filters.
    | 'inline': Filters data inside the table.
    | 'outside': Filters data outside the table.
    | 'null'
    |
    */
    'filter' => 'inline',

    /*
    |--------------------------------------------------------------------------
    | Filters Attributes
    |--------------------------------------------------------------------------
    |
    | You can add custom attributes to the filters.
    */
    'filter_attributes' => [
        'input_text' => \PowerComponents\LivewirePowerGrid\FilterAttributes\InputText::class,
        'boolean' => \PowerComponents\LivewirePowerGrid\FilterAttributes\Boolean::class,
        'number' => \PowerComponents\LivewirePowerGrid\FilterAttributes\Number::class,
        'select' => \PowerComponents\LivewirePowerGrid\FilterAttributes\Select::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Persisting
    |--------------------------------------------------------------------------
    */
    'persist_driver' => 'cookies',

    /*
    |--------------------------------------------------------------------------
    | Exportable class
    |--------------------------------------------------------------------------
    */
    'exportable' => [
        'default' => 'openspout_v4',
        'openspout_v4' => [
            'xlsx' => \PowerComponents\LivewirePowerGrid\Components\Exports\OpenSpout\v4\ExportToXLS::class,
            'csv' => \PowerComponents\LivewirePowerGrid\Components\Exports\OpenSpout\v4\ExportToCsv::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-Discover Models
    |--------------------------------------------------------------------------
    */
    'auto_discover_models_paths' => [
        app_path('Models'),
    ],
];
