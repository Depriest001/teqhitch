    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand pt-6">
            <a class="app-brand-link">
                @php
                    $logo = $globalSetting->site_logo ?? null;
                    $role = Auth::guard('admin')->user()->name;
                @endphp

                <img src="{{ $logo ? asset('uploads/'.$logo) : asset('assets/img/favicon.jpg') }}" alt="Logo" width="50px">
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

            @if($role === 'superadmin')
            <li class="menu-item {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                <a href="{{ route('admin.admins.index')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user-detail"></i>
                    <div class="text-truncate">Admins</div>
                </a>
            </li>
            @endif

            <li class="menu-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                <a href="{{ route('admin.courses.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book-open"></i>
                    <div class="text-truncate">Courses</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.student.*') ? 'active' : '' }}">
                <a href="{{ route('admin.student.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div class="text-truncate">Students</div>
                </a>
            </li>

            @if(in_array($role, ['superadmin','admin']))
            <li class="menu-item {{ request()->routeIs('admin.instructor.*') ? 'active' : '' }}">
                <a href="{{ route('admin.instructor.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-voice"></i>
                    <div class="text-truncate">Instructors</div>
                </a>
            </li>
            @endif

            <li class="menu-item {{ request()->routeIs('admin.enrollments.*') || request()->routeIs('enrollments.*') ? 'active' : '' }}">
                <a href="{{ route('admin.enrollments.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                    <div class="text-truncate">Enrollment Applicants</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.siwes.*') ? 'active' : '' }}">
                <a href="{{ route('admin.siwes.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
                    <div class="text-truncate"> Manage SIWES Application</div>
                </a>
            </li>

            @if(in_array($role, ['superadmin','admin']))
            <li class="menu-item {{ request()->routeIs('admin.certificates.*') ? 'active' : '' }}">
                <a href="{{ route('admin.certificates.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-award"></i>
                    <div class="text-truncate">Certificates</div>
                </a>
            </li>
            @endif

            <li class="menu-item {{ request()->routeIs('admin.topics.*') ? 'active' : '' }}">
                <a href="{{ route('admin.topics.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-book"></i>
                    <div class="text-truncate">Manage Topic</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.transaction.*') ? 'active' : '' }}">
                <a href="{{ route('admin.transaction.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-wallet"></i>
                    <div class="text-truncate"> Transaction History</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                <a href="{{ route('admin.news.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-news"></i>
                    <div class="text-truncate"> News</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.announcement.*') ? 'active' : '' }}">
                <a href="{{ route('admin.announcement.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-bell"></i>
                    <div class="text-truncate"> Announcement</div>
                </a>
            </li>

            @if(in_array($role, ['superadmin','admin']))
            <li class="menu-item {{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
                <a href="{{ route('admin.team.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user-circle"></i>
                    <div class="text-truncate"> Team</div>
                </a>
            </li>
            @endif

            <li class="menu-item {{ request()->routeIs('admin.testimony.*') ? 'active' : '' }}">
                <a href="{{ route('admin.testimony.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-comment"></i>
                    <div class="text-truncate"> Testimonies</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.product.*') ? 'active' : '' }}">
                <a href="{{ route('admin.product.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-package"></i>
                    <div class="text-truncate"> Products</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                <a href="{{ route('admin.gallery.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-images"></i>
                    <div class="text-truncate"> Gallery</div>
                </a>
            </li>

            <li class="menu-item {{ request()->routeIs('admin.newsletter.*') ? 'active' : '' }}">
                <a href="{{ route('admin.newsletter.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-envelope"></i>
                    <div class="text-truncate"> Newsletters</div>
                </a>
            </li>

            @if(in_array($role, ['superadmin','admin']))
            <li class="menu-item {{ request()->routeIs('admin.system.settings') ? 'active' : '' }}">
                <a href="{{ route('admin.system.settings.edit') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div class="text-truncate"> System Settings</div>
                </a>
            </li>
            @endif

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