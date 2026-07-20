<!-- Navbar Start -->
<div class="container-fluid sticky-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <!-- Brand Logo -->
            <a href="{{route('home')}}" class="navbar-brand d-flex align-items-center justify-content-center">
                @php
                    $logo = $globalSetting->site_logo ?? null;
                @endphp
                <img src="{{ $logo ? asset('uploads/'.$logo) : asset('assets/img/favicon.jpg') }}" alt="Logo" width="30px">
                <h1>Teq<span class="logoText">h</span>itch</h1>
            </a>

            <!-- Toggler Button -->
            <button type="button" class="navbar-toggler ms-auto me-0" 
                    data-bs-toggle="offcanvas" 
                    data-bs-target="#offcanvasNavbar" 
                    aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Offcanvas Container (Nested inside navbar for perfect desktop flex) -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <!-- Header (Visible on mobile only) -->
                <div class="offcanvas-header d-lg-none">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                        <span class="navbar-brand d-flex align-items-center">
                            <img src="{{ $logo ? asset('uploads/'.$logo) : asset('assets/img/favicon.jpg') }}" alt="Logo" width="36px" class="me-2">
                            <h1 style="font-size: 1.25rem !important;">Teq<span class="logoText">h</span>itch</h1>
                        </span>
                    </h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <!-- Offcanvas Body containing Nav Links -->
                <div class="offcanvas-body">
                    <div class="navbar-nav ms-auto">
                        <a href="{{route('home')}}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                        <a href="{{route('about')}}" class="nav-item nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                        <a href="{{route('services')}}" class="nav-item nav-link {{ request()->routeIs('services') ? 'active' : '' }}">Courses</a>
                        <a href="{{route('news')}}" class="nav-item nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}">News</a>
                        <a href="{{route('products')}}" class="nav-item nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">Products</a>
                        <a href="{{route('contact')}}" class="nav-item nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                        
                        <a href="{{ route('login') }}" class="nav-item nav-link {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                        <a href="{{ route('register') }}" class="nav-item nav-link {{ request()->routeIs('register') ? 'active' : '' }}">Sign Up</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->