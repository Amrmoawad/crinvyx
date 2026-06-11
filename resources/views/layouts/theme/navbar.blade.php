<nav
    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="ri-menu-fill ri-22px"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">


        @php
            $currentLocale = app()->getLocale();
            $supportedLocales = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales();
            $supportedLocales = array_intersect_key($supportedLocales, array_flip(['en', 'ar']));
        @endphp

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Language -->
            <li class="nav-item dropdown-language dropdown">
                <a
                    class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <i class="ri-translate-2 ri-22px"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    @foreach ($supportedLocales as $localeCode => $properties)
                        <li>
                            <a
                                class="dropdown-item {{ $localeCode === $currentLocale ? 'active fw-semibold' : '' }}"
                                href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                rel="alternate"
                                hreflang="{{ $localeCode }}"
                                data-language="{{ $localeCode }}"
                                data-text-direction="{{ $localeCode === 'ar' ? 'rtl' : 'ltr' }}"
                            >
                                <span class="align-middle">{{ $properties['native'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <!--/ Language -->






            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ asset('materialize/assets/img/avatars/1.png') }}" alt class="rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">



                    <li>
                        <div class="d-grid px-4 pt-2 pb-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger d-flex w-100">
                                    <small class="align-middle">{{ __('app.logout') }}</small>
                                    <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>

    <!-- Search Small Screens -->
    <div class="navbar-search-wrapper search-input-wrapper d-none">
        <input
            type="text"
            class="form-control search-input container-xxl border-0"
            placeholder="Search..."
            aria-label="Search..." />
        <i class="ri-close-fill search-toggler cursor-pointer"></i>
    </div>
</nav>

<!-- / Navbar -->
