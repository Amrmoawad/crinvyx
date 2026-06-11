<x-app-layout>
    @push('page-css')
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/pages/cards-analytics.css') }}">
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/pages/cards-statistics.css') }}">
    @endpush

    <x-slot name="header">
        <h4 class="mb-0">Welcome Page</h4>
    </x-slot>


    </div>
</x-app-layout>
