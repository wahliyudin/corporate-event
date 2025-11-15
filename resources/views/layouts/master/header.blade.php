<header class="app-header">
    <div class="main-header-container container-fluid">
        <div class="header-content-left">
            <div class="header-element">
                <div class="horizontal-logo">
                    <a href="" class="header-logo">
                        <img src="{{ asset('assets/images/brand-logos/tbu.png') }}" alt="logo" class="desktop-logo">
                        <img src="{{ asset('assets/images/brand-logos/tbu-crop.png') }}" alt="logo"
                            class="toggle-logo">
                        <img src="{{ asset('assets/images/brand-logos/tbu.png') }}" alt="logo" class="desktop-dark">
                        <img src="{{ asset('assets/images/brand-logos/tbu-crop.png') }}" alt="logo"
                            class="toggle-dark">
                        <img src="{{ asset('assets/images/brand-logos/tbu.png') }}" alt="logo"
                            class="desktop-white">
                        <img src="{{ asset('assets/images/brand-logos/tbu-crop.png') }}" alt="logo"
                            class="toggle-white">
                    </a>
                </div>
            </div>
            <div class="header-element">
                <a aria-label="Hide Sidebar"
                    class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                    data-bs-toggle="sidebar" href="javascript:void(0);">
                    <span></span>
                </a>
            </div>
            <div class="header-element">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="fw-semibold mb-1">Corporate Event Calendar</h5>
                    <span class="text-sm text-slate-500">Holding Group — Master Calendar</span>
                </div>
            </div>
        </div>
        <div class="header-content-right">
            <div class="header-element">
                <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="me-sm-2 me-0">
                            <img src="{{ Auth::user()?->photo ?? asset('assets/images/avatar.png') }}" alt="img"
                                width="32" height="32" class="rounded-circle">
                        </div>
                        <div class="d-sm-block d-none">
                            <p class="fw-semibold mb-0 lh-1">{{ Auth::user()?->name }}</p>
                            <span class="op-7 fw-normal d-block fs-11">{{ Auth::user()?->email }}</span>
                        </div>
                    </div>
                </a>
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                    aria-labelledby="mainHeaderProfile">
                    <li>
                        <a class="dropdown-item d-flex" href=""
                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="ti ti-logout fs-18 me-2 op-7"></i>Log Out
                        </a>
                        <form id="logout-form" action="" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            {{-- <!-- End::header-element -->
            @if (app()->environment('local'))
                <!-- Start::header-element -->
                <div class="header-element">
                    <!-- Start::header-link|switcher-icon -->
                    <a href="javascript:void(0);" class="header-link switcher-icon" data-bs-toggle="offcanvas"
                        data-bs-target="#switcher-canvas">
                        <i class="bx bx-cog header-link-icon"></i>
                    </a>
                    <!-- End::header-link|switcher-icon -->
                </div>
                <!-- End::header-element -->
            @endif --}}
        </div>
    </div>
</header>
