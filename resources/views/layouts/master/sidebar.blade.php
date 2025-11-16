<aside class="app-sidebar sticky" id="sidebar">
    <div class="main-sidebar-header">
        <a href="" class="header-logo">
            <img src="{{ asset('assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
            <img src="{{ asset('assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
            <img src="{{ asset('assets/images/brand-logos/desktop-white.png') }}" alt="logo" class="desktop-white">
            <img src="{{ asset('assets/images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-white">
        </a>
    </div>
    <div class="main-sidebar" id="sidebar-scroll">
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <li class="slide">
                    <a href="{{ route('home') }}" class="side-menu__item">
                        <i class="bx bx-home side-menu__icon"></i>
                        <span class="side-menu__label">Home</span>
                    </a>
                </li>
                @permission('calendar_read')
                    <li class="slide">
                        <a href="{{ route('events.index') }}" class="side-menu__item">
                            <i class="bx bx-calendar side-menu__icon"></i>
                            <span class="side-menu__label">Calendar</span>
                        </a>
                    </li>
                @endpermission
                @permission('companies_read')
                    <li class="slide">
                        <a href="{{ route('companies.index') }}" class="side-menu__item">
                            <i class="bx bx-building side-menu__icon"></i>
                            <span class="side-menu__label">Companies</span>
                        </a>
                    </li>
                @endpermission
                @permission('event_approve|event_reject|settings_user_management_approve|settings_user_management_reject')
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bx-task side-menu__icon w-auto"></i>
                            <span class="side-menu__label">
                                Approvals
                                {{-- <span class="badge bg-warning-transparent ms-2">12</span> --}}
                            </span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1 force-left">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Approvals</a>
                            </li>
                            <li class="slide">
                                <a href="" class="side-menu__item">Event</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('approvals.user.index') }}" class="side-menu__item">User</a>
                            </li>
                        </ul>
                    </li>
                @endpermission
                @permission('settings_user_management_read')
                    <li class="slide has-sub">
                        <a href="javascript:void(0);" class="side-menu__item">
                            <i class="bx bx-cog side-menu__icon w-auto"></i>
                            <span class="side-menu__label">Settings</span>
                            <i class="fe fe-chevron-right side-menu__angle"></i>
                        </a>
                        <ul class="slide-menu child1 force-left">
                            <li class="slide side-menu__label1">
                                <a href="javascript:void(0)">Settings</a>
                            </li>
                            <li class="slide">
                                <a href="{{ route('setting.permission.index') }}" class="side-menu__item">User
                                    Management</a>
                            </li>
                        </ul>
                    </li>
                @endpermission
            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>
        </nav>
    </div>
</aside>
