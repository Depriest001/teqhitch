<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Email Verification | {{ $globalSetting->site_name ?? 'Teqhitch' }}</title>

    <!-- Favicon -->
    @php
      $favicon = $globalSetting->favicon ?? null;
      $logo = $globalSetting->site_logo ?? null;
    @endphp

    <link rel="icon"
      href="{{ $favicon ? asset('storage/'.$favicon) : asset('assets/img/favicon.jpg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('dashboardassets/vendor/fonts/iconify-icons.css')}}" />

    <link rel="stylesheet" href="{{asset('dashboardassets/vendor/css/core.css')}}" />
    <link rel="stylesheet" href="{{asset('dashboardassets/css/demo.css')}}" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{asset('dashboardassets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <!-- endbuild -->

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('dashboardassets/vendor/css/pages/page-auth.css')}}" />

    <!-- Helpers -->
    <script src="{{asset('dashboardassets/vendor/js/helpers.js')}}"></script>
    <script src="{{asset('dashboardassets/js/config.js')}}"></script>
  </head>

  <body>
    <!-- Content -->
    
    @if (session('success') || session('error') || $errors->any())
    <div id="appToast"
        class="bs-toast toast fade show position-fixed top-0 end-0 m-3
        {{ session('success') ? 'bg-success' : (session('error') ? 'bg-danger' : 'bg-warning') }}"
        role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
        <div class="toast-header text-white">
            <i class="icon-base bx bx-bell me-2"></i>
            <div class="me-auto fw-medium">
            @if (session('success'))
                Success
            @elseif (session('error'))
                Error
            @else
                Validation
            @endif
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>

        <div class="toast-body text-white">
            @if (session('success'))
            {{ session('success') }}
            @elseif (session('error'))
            {{ session('error') }}
            @elseif ($errors->any())
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
    @endif

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">

                <div class="card px-sm-6 px-0">
                    <div class="card-body">

                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-2">
                            <a href="{{ route('home') }}" class="app-brand-link gap-2">
                                <img src="{{ $logo ? asset('storage/'.$logo) : asset('assets/img/logo.jpg') }}" alt="Logo" width="50px">
                                <span class="app-brand-text demo text-heading fw-bold">
                                {{ $globalSetting->site_name ?? 'Teqhitch' }}
                                </span>
                            </a>
                        </div>

                        <h4 class="mb-1 text-center">Reset Your Password 🔐</h4>
                        <p class="mb-2 text-center">
                            Please enter your new password below.
                        </p>

                        <div class="text-center mb-3">
                            <small class="text-danger">
                                This link will expire in <span id="countdown">15:00</span>
                            </small>
                        </div>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <!-- Token -->
                            <input type="hidden" name="token" value="{{ $token }}">

                            <!-- Email -->
                            <div class="mb-4">
                                <label class="form-label">Email</label>
                                <input type="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $email ?? '') }}"
                                    required
                                    readonly>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="mb-4">
                                <label class="form-label">New Password</label>
                                <input type="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    min="6"
                                    required
                                    autofocus>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label class="form-label">Confirm Password</label>
                                <input type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    required>
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn btn-primary d-grid w-100">
                                Reset Password
                            </button>

                        </form>

                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}" class="d-flex justify-content-center">
                                <i class="bx bx-chevron-left scaleX-n1-rtl me-1"></i>
                                Back to Login
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Core JS -->

    <script src="{{asset('dashboardassets/vendor/libs/jquery/jquery.js')}}"></script>

    <script src="{{asset('dashboardassets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('dashboardassets/vendor/js/bootstrap.js')}}"></script>

    <script src="{{asset('dashboardassets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    <script src="{{asset('dashboardassets/vendor/js/menu.js')}}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->

    <script src="{{asset('dashboardassets/js/main.js')}}"></script>
    <script>
        let timeLeft = {{ $remainingSeconds ?? 0 }};
        const countdownEl = document.getElementById('countdown');
        alert(timeLeft);
        if (timeLeft <= 0) {
            countdownEl.textContent = "Expired";
        } else {
            const timer = setInterval(() => {

                let minutes = Math.floor(timeLeft / 60);
                let seconds = timeLeft % 60;

                seconds = seconds < 10 ? '0' + seconds : seconds;

                countdownEl.textContent = minutes + ':' + seconds;

                timeLeft--;

                if (timeLeft < 0) {
                    clearInterval(timer);
                    countdownEl.textContent = "Expired";
                }

            }, 1000);
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const appToast = document.getElementById('appToast');
            if (appToast) {
            const toast = new bootstrap.Toast(appToast);
            toast.show();
            }
        });
    </script>
  </body>
</html>