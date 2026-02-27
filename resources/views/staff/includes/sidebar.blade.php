<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand pt-6">
        <a class="app-brand-link">            
            @php
                $logo = $globalSetting->site_logo ?? null;
            @endphp
            
            <img src="{{ $logo ? asset('storage/'.$logo) : asset('assets/img/logo.png') }}" alt="Logo" width="50px">
            <h3 class="pt-4">Teqhitch</h3>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <ul class="menu-inner py-1">
        <!-- DASHBOARD (everyone can see) -->
        <li class="menu-item {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
            <a href="{{ route('staff.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-alt"></i>
                <div class="text-truncate">Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('staff.profile') ? 'active' : '' }}">
            <a href="{{ route('staff.profile')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div class="text-truncate">Profile</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('staff.courses.*') ? 'active' : '' }}">
            <a href="{{ route('staff.courses.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-open"></i>
                <div class="text-truncate">My Courses</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('staff.student.*') ? 'active' : '' }}">
            <a href="{{ route('staff.student.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-voice"></i>
                <div class="text-truncate">My Students</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('staff.assignment.*') ? 'active' : '' }}">
            <a href="{{ route('staff.assignment.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-task"></i>
                <div class="text-truncate"> Assignment</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('staff.announcement.*') ? 'active' : '' }}">
            <a href="{{ route('staff.announcement.index') }}" class="menu-link">
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