    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-global" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <div class="container-fluid sticky-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark p-0">
                <a href="{{route('home')}}" class="navbar-brand d-flex">
                  <img src="{{ asset('assets/img/logo.png')}}" alt="" width="50px">
                  <h1 class="text-white">Teq<span class="logoText" style="color: #14183E;">h</span>itch</h1>
                </a>
                <button type="button" class="navbar-toggler ms-auto me-0" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto" style="bg-success">
                        <a href="{{route('home')}}" class="nav-item nav-link active">Home</a>
                        <a href="{{route('about')}}" class="nav-item nav-link">About</a>
                        <a href="{{route('services')}}" class="nav-item nav-link">Courses</a>
                        <a href="{{route('contact')}}" class="nav-item nav-link">Contact</a>
                        <div class="nav-item d-block d-lg-none  mb-3">
                          <a href="{{ route('login') }}" class="btn btn-primary rounded-pill me-2 px-3">Login</a>
                          <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-3">Sign Up</a>
                        </div>
                    </div>
                    <a href="{{ route('login') }}" class="btn auth-btn btn-outline-primary rounded-pill px-3 d-none d-lg-block me-3">Login</a>
                    <a href="{{ route('register') }}" class="btn auth-btn btn-outline-primary rounded-pill px-3 d-none d-lg-block">Sign Up</a>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->