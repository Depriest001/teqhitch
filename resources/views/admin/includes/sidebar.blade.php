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
        <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-alt"></i>
                <div class="text-truncate">Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
            <a href="{{ route('admin.profile')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-user-badge"></i>
                <div class="text-truncate">Profile</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
            <a href="{{ route('admin.admins.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-user-detail"></i>
                <div class="text-truncate">Admins</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
            <a href="{{ route('admin.courses.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-open"></i>
                <div class="text-truncate">Courses</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.student.*') ? 'active' : '' }}">
            <a href="{{ route('admin.student.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div class="text-truncate">Students</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.instructor.*') ? 'active' : '' }}">
            <a href="{{ route('admin.instructor.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-voice"></i>
                <div class="text-truncate">Instructors</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.transaction.*') ? 'active' : '' }}">
            <a href="{{ route('admin.transaction.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-receipt"></i>
                <div class="text-truncate"> Transaction History</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.announcement.*') ? 'active' : '' }}">
            <a href="{{ route('admin.announcement.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bell"></i>
                <div class="text-truncate"> Announcement</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.system.setting') ? 'active' : '' }}">
            <a href="{{ route('admin.system.setting') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div class="text-truncate"> System Settings</div>
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