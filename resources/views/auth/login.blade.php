<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login | {{ $globalSetting->site_name ?? 'Teqhitch' }}</title>

    <!-- Favicon -->
    @php
      $favicon = $globalSetting->favicon ?? null;
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
        class="bs-toast toast fade show position-fixed bottom-0 end-0 m-3
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
          <!-- Register -->
          <div class="card px-sm-6 px-0">
            <div class="card-body">
              <h4 class="mb-1">Welcome👋</h4>
              <p class="mb-6">Please sign-in to your account and start the adventure</p>

              <form id="formAuthentication" class="mb-6" action="{{ route('login.submit')}}" method="post">
                @csrf
                <div class="mb-6">
                  <label for="email" class="form-label">Email Address</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Enter your email address"
                    autofocus required />
                </div>
                <div class="mb-6 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password" required />
                    <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-8">
                  <div class="d-flex justify-content-between">
                    <div class="form-check mb-0">
                      <input class="form-check-input" type="checkbox" id="remember-me" />
                      <label class="form-check-label" for="remember-me"> Remember Me </label>
                    </div>
                    <a href="{{ route('forgot.password') }}">
                      <span>Forgot Password?</span>
                    </a>
                  </div>
                </div>
                <div class="mb-6">
                  <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                </div>
                <p> I don't have an account? 
                  <a href="{{ route('register') }}">
                    <span>Register</span>
                  </a>
                </p>
              </form>
            </div>
          </div>
          <!-- /Register -->
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
