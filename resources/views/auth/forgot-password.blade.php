<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Forgot Password | {{ $globalSetting->site_name ?? 'Teqhitch' }}</title>

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
     
    @if (session('status') || session('success') || session('error') || $errors->any())
      <div id="appToast"
          class="bs-toast toast fade show position-fixed top-0 end-0 m-3
          {{ session('status') || session('success') ? 'bg-success' : (session('error') ? 'bg-danger' : 'bg-warning') }}"
          role="alert">

          <div class="toast-header text-white">
              <div class="me-auto fw-medium">
                  @if (session('status') || session('success'))
                      Success
                  @elseif (session('error'))
                      Error
                  @else
                      Validation
                  @endif
              </div>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
          </div>

          <div class="toast-body text-white">
              @if (session('status'))
                  {{ session('status') }}
              @elseif (session('success'))
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
              <!-- Logo -->
              <div class="app-brand justify-content-center mb-1">
                <img src="{{ $logo ? asset('storage/'.$logo) : asset('assets/img/logo.jpg') }}" alt="Logo" width="50px">
                <h3 class="pt-3">Teqhitch</h3>
              </div>
              <!-- /Logo -->
              <h4 class="mb-1">Forgot Password? 🔒</h4>
              <p class="mb-6">Enter your email and we'll send you instructions to reset your password</p>

              <form id="formAuthentication"
                    class="mb-6"
                    action="{{ route('password.email') }}"
                    method="POST">

                  @csrf

                  <div class="mb-6">
                      <label for="email" class="form-label">Email</label>
                      <input
                          type="email"
                          class="form-control @error('email') is-invalid @enderror"
                          id="email"
                          name="email"
                          value="{{ old('email') }}"
                          placeholder="Enter your email"
                          required
                          autofocus />

                      @error('email')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                      @enderror
                  </div>

                  <button class="btn btn-primary d-grid w-100">
                      Send Reset Link
                  </button>

              </form>
              <div class="text-center">
                <a href="{{ route('login') }}" class="d-flex justify-content-center">
                  <i class="icon-base bx bx-chevron-left me-1"></i>
                  Back to login
                </a>
              </div>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- Core JS -->

    <script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>

    <script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>

    <script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    <script src="{{asset('assets/vendor/js/menu.js')}}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->

    <script src="{{asset('assets/js/main.js')}}"></script>

  </body>
</html>
