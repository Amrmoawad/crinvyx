





@php($isRtl = app()->getLocale() === 'ar')
@php($materializeAssetsPath = rtrim(asset('materialize/assets'), '/').'/')
@php($materializeCore = asset('materialize/assets/vendor/css/rtl/core.css'))
@php($materializeTheme = asset('materialize/assets/vendor/css/rtl/theme-default.css'))
<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ $isRtl ? 'rtl' : 'ltr' }}"
    class="light-style layout-wide {{ $isRtl ? 'rtl' : 'ltr' }}"
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
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/css/pages/page-auth.css') }}">
        <link rel="stylesheet" href="{{ asset('materialize/assets/vendor/libs/sweetalert2/sweetalert2.css') }}">

        @vite(['resources/css/app.css'])
        <script src="{{ asset('materialize/assets/vendor/js/helpers.js') }}"></script>
        <script src="{{ asset('materialize/assets/vendor/js/template-customizer.js') }}"></script>
        <script src="{{ asset('materialize/js/config.js') }}"></script>
    </head>
    <body class="text-start">
        <div class="authentication-wrapper authentication-basic px-4">
            <div class="authentication-inner py-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <a href="/" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <x-application-logo class="h-8 w-8" />
                                </span>
                                <span class="app-brand-text demo text-body fw-semibold">{{ config('app.name', 'Crinvy') }}</span>
                            </a>

                        </div>

                        <h4 class="mb-2">{{ __('app.login') }}</h4>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <x-input-label for="username" :value="__('app.username')" />
            <x-text-input id="username" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
        </div>

        <div class="mb-3">
            <x-input-label for="password" :value="__('app.password')" />

            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
        </div>



        <div class="d-flex justify-content-between align-items-center mt-4">


            <x-primary-button>
                {{ __('app.login') }}
            </x-primary-button>
        </div>
    </form>
                    </div>
                </div>
            </div>
        </div>

        @vite(['resources/js/auth.js'])
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
        <script src="{{ asset('materialize/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    if (typeof Swal === 'undefined') {
                        return;
                    }

                    const isRtl = document.documentElement.getAttribute('dir') === 'rtl';
                    const messages = @json($errors->all());

                    Swal.fire({
                        icon: 'error',
                        title: @json(__('app.error')),
                        html: messages.map((msg) => `<div>${msg}</div>`).join(''),
                        confirmButtonText: @json(__('app.ok')),
                        customClass: { confirmButton: 'btn btn-primary' },
                        buttonsStyling: false,
                        didOpen: () => {
                            if (isRtl) {
                                Swal.getPopup().setAttribute('dir', 'rtl');
                            }
                        },
                    });
                });
            </script>
        @endif
    </body>
</html>
