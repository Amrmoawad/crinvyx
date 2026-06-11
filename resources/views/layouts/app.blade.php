@php($isRtl = app()->getLocale() === 'ar')
@php($materializeAssetsPath = rtrim(asset('materialize/assets'), '/').'/')
@php($materializeCore = asset('materialize/assets/vendor/css/rtl/core.css'))
@php($materializeTheme = asset('materialize/assets/vendor/css/rtl/theme-default.css'))
<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ $isRtl ? 'rtl' : 'ltr' }}"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact {{ $isRtl ? 'rtl' : 'ltr' }}"
    data-theme="theme-default"
    data-assets-path="{{ $materializeAssetsPath }}"
    data-template="vertical-menu-template"
    data-style="light"
    data-materialize-core="{{ $materializeCore }}"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @include('layouts.partials.fonts')

        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/fonts/remixicon/remixicon.css') }}">
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/node-waves/node-waves.css') }}">
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/typeahead-js/typeahead.css') }}">
        <link rel="stylesheet" href="{{ $materializeCore }}" class="template-customizer-core-css">
        <link rel="stylesheet" href="{{ $materializeTheme }}" class="template-customizer-theme-css">
        <link rel="stylesheet" href="{{ asset('materialize/assets/css/demo.css') }}">

        @livewireStyles
        @stack('vendor-css')
        @stack('page-css')

        @vite(['resources/css/app.css'])
        <script src="{{ asset('materialize/assets/vendor/js/helpers.js') }}"></script>
        <script src="{{ asset('materialize/assets/vendor/js/template-customizer.js') }}"></script>
        <script src="{{ asset('materialize/js/config.js') }}"></script>
    </head>
    <body class="text-start">
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                @include('layouts.theme.sidebar')

                <div class="layout-page">
                    @include('layouts.theme.navbar')

                    <div class="content-wrapper">
                        <div class="container-xxl flex-grow-1 container-p-y">
                            @isset($header)
                                <div class="mb-4">
                                    {{ $header }}
                                </div>
                            @endisset

                            {{ $slot }}
                        </div>

                        @include('layouts.theme.footer')
                        <div class="content-backdrop fade"></div>
                    </div>
                </div>
            </div>

            <div class="layout-overlay layout-menu-toggle"></div>
        </div>

        @vite(['resources/js/app.js'])
        @livewireScripts
        <script src="{{ asset('materialize/assets/vendor/libs/jquery/jquery.js') }}"></script>
        <script src="{{ asset('materialize/assets/vendor/libs/popper/popper.js') }}"></script>
        <script src="{{ asset('materialize/assets/vendor/js/bootstrap.js') }}"></script>
        <script src="{{ asset('materialize/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
        <script src="{{ asset('materialize/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('materialize/assets/vendor/libs/hammer/hammer.js') }}"></script>
        <script src="{{ asset('materialize/assets/vendor/libs/i18n/i18n.js') }}"></script>
        <script src="{{ asset('materialize/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
        <script src="{{ asset('materialize/assets/vendor/js/menu.js') }}"></script>
        <script src="{{ asset('materialize/assets/js/main.js') }}"></script>
        @stack('vendor-js')
        @stack('page-js')
    </body>
</html>
