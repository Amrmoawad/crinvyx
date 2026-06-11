<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-semibold ms-2">{{ config('app.name', 'Crinvyx') }}</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ri-menu-line ri-24px"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-home-smile-line"></i>
                <div>{{ __('app.dashboard') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('analysis') ? 'active' : '' }}">
            <a href="{{ route('analysis') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-bar-chart-2-line"></i>
                <div>{{ __('app.analysis') }}</div>
            </a>
        </li>


        @if (auth()->user()?->canManageUsers())
        <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-group-line"></i>
                <div>{{ __('app.users_management') }}</div>
            </a>
        </li>
        @endif

        @if (auth()->user()?->canManageEvents())
        <li class="menu-item {{ request()->routeIs('events.*') ? 'active' : '' }}">
            <a href="{{ route('events.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-calendar-event-line"></i>
                <div>{{ __('app.events_management') }}</div>
            </a>
        </li>
        @endif

        @if (auth()->user()?->canRecordAttendees())
        <li class="menu-item {{ request()->routeIs('attendees.*') ? 'active' : '' }}">
            <a href="{{ route('attendees.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-user-follow-line"></i>
                <div>{{ __('app.attendees_management') }}</div>
            </a>
        </li>
        @endif
    </ul>
</aside>
