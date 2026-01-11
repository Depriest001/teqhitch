<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand pt-6">
        <a class="app-brand-link">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="40px">
            <h3 class="pt-4">Teqhitch</h3>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <ul class="menu-inner py-1">
        <!-- DASHBOARD (everyone can see) -->
        <li class="menu-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <a href="{{ route('user.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate">Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('user.profile') ? 'active' : '' }}">
            <a href="{{ route('user.profile')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div class="text-truncate">Profile</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('user.courses.*') ? 'active' : '' }}">
            <a href="{{ route('user.courses.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book"></i>
                <div class="text-truncate">My Courses</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('user.assignment.*') ? 'active' : '' }}">
            <a href="{{ route('user.assignment.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-task"></i>
                <div class="text-truncate"> Assignment</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('user.certificate.*') ? 'active' : '' }}">
            <a href="{{ route('user.certificate.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-award"></i>
                <div class="text-truncate"> Certificates</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('user.activities') ? 'active' : '' }}">
            <a href="{{ route('user.activities') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                <div class="text-truncate"> Activities</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('user.announcement.index') ? 'active' : '' }}">
            <a href="{{ route('user.announcement.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bell"></i>
                <div class="text-truncate"> Announcements</div>
            </a>
        </li>

        <!-- LOGOUT -->
        <li class="menu-item">
            <form id="logout-form" action="{{ route('logout')}}" method="POST" class="d-none">
                @csrf
            </form>
            <a href="javascript:void(0);" class="menu-link"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-power-off text-danger"></i>
                <div class="text-truncate">Log Out</div>
            </a>
        </li>
    </ul>
</aside>