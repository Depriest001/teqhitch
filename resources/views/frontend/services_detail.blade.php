@extends('frontLayout')
@section('title','Services Detail - Teqhitch ICT Academy LTD')
@section('content')
    
<!-- Hero Start -->
<div class="container-fluid pt-5 hero-header">
    <div class="container pt-5">
        <div class="row g-5 pt-5">
            <div class="col-lg-6 align-self-center text-center text-lg-start mb-lg-5">                
                <h2 class="fw-bold mb-3 text-white">
                    {{ $course->title }}
                </h2>

                <h5 class="mb-3 text-light">
                    {{ $course->subtitle }}
                </h5>

                <p class="mb-4 text-white">
                    {{ $course->description }}
                </p>
                <a href="{{ route('user.courses.enroll') }}" class="btn btn-success px-4 mb-3">
                    Enroll Now
                </a>
                <nav aria-label="breadcrumb align-self-center">
                    <ol class="breadcrumb justify-content-center justify-content-lg-start mb-0">
                        <li class="breadcrumb-item"><a class="text-white" href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-white" href="{{route('services')}}">Services</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">{{ $course->slug }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-6 align-self-center text-center">
                <img src="{{ $course->thumbnail 
                    ? asset('uploads/'.$course->thumbnail) 
                    : 'https://images.unsplash.com/photo-1555066931-4365d14bab8c' }}"
                    class="img-fluid"
                    alt="{{ $course->title }}">
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->

<!-- WHY SECTION -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h3 class="fw-bold">Why {{ $course->title }}?</h3>
        </div>

        <div class="row g-4">

            @foreach($course->features as $feature)

                <div class="col-12 col-md-6">
                    <div class="card border-0 shadow-sm p-4 h-100">

                        <i class="{{ $feature->icon ?? 'fas fa-check-circle' }} fa-2x text-primary mb-3"></i>

                        <h5 class="fw-bold">
                            {{ $feature->title }}
                        </h5>

                        <p class="text-muted">
                            {{ $feature->description }}
                        </p>

                    </div>
                </div>

            @endforeach

        </div>
    </div>
</section>

<!-- COURSE OVERVIEW -->
<section class="py-5">
    <div class="container">

        <h3 class="fw-bold mb-3">Course Overview</h3>
        {!! $course->overview !!}

        <div class="row align-items-center bg-light rounded p-4">

            <div class="col-lg-6">
                <h5 class="fw-bold mb-4">
                    What You Will Learn:
                </h5>

                <ul class="list-unstyled">
                    @foreach($course->outcomes as $outcome)
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            {{ $outcome->content }}
                        </li>
                    @endforeach
                </ul>

                <a href="{{ route('user.courses.enroll') }}"
                    class="btn btn-primary px-4">
                        Enroll Now
                </a>
            </div>

            <div class="col-lg-6 text-center mt-4 mt-lg-0 d-none d-md-block">
                <img src="{{ $course->thumbnail 
                    ? asset('uploads/'.$course->thumbnail) 
                    : 'https://images.unsplash.com/photo-1555066931-4365d14bab8c' }}"
                    class="img-fluid"
                    alt="{{ $course->title }}">
            </div>

        </div>

    </div>
</section>

@endsection
