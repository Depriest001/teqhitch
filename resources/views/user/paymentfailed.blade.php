@extends('userdashboardLayout')
@section('title','Payment Failed | Teqhitch ICT Academy LTD')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 text-center">

            {{-- Icon --}}
            <div class="mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="red" class="bi bi-x-circle" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 
                  .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 
                  0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </div>

            {{-- Message --}}
            <h3 class="fw-bold text-danger mb-3">Payment Failed!</h3>
            <p class="lead mb-4">
                Sorry, your payment could not be processed at this time.
                Please try again or contact support if the issue persists.
            </p>

            {{-- Optional error message --}}
            @if(session('error'))
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Action buttons --}}
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('user.dashboard') }}" class="btn btn-sm btn-outline-secondary btn-lg">
                    Dashboard
                </a>
                <a href="{{ route('user.courses.enroll') }}" class="btn btn-sm btn-danger btn-lg">
                    Browse Courses
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
