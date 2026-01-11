@extends('frontLayout')
@section('title','Services - Teqhitch ICT Academy LTD')
@section('content')
    
   
    <!-- Hero Start -->
    <div class="container-fluid pt-5 hero-header">
        <div class="container pt-5">
            <div class="row g-5 pt-5">
                <div class="col-lg-6 align-self-center text-center text-lg-start mb-lg-5">
                    <h1 class="display-4 text-white mb-4 animated slideInRight">Our Services</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center justify-content-lg-start mb-0">
                            <li class="breadcrumb-item"><a class="text-white" href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Our Services</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Service Start -->
    <div class="container-fluid pt-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
                <div class="btn btn-sm border rounded-pill text-primary px-3 mb-3">Our Services</div>
                <h1 class="mb-4">Innovative Tech Training & Digital Solutions</h1>
            </div>
            <div class="slider-wrapper">
                <div class="nav-btn nav-prev">&#10094;</div>
                <div class="nav-btn nav-next">&#10095;</div>

                <div class="owl-carousel my-slider">
                    @foreach($courses as $course)
                        <div class="item">
                            <div class="case-item position-relative overflow-hidden rounded mb-2">
                                <img class="img-fluid"
                                    src="{{ asset('storage/'.$course->thumbnail ?? 'assets/img/project-1.jpg') }}"
                                    alt="{{ $course->title }}">

                                <a class="case-overlay text-decoration-none"
                                href="{{ route('service.show', $course->slug) }}">

                                    <small>{{ $course->title }}</small>

                                    <h5 class="lh-base text-white mb-3">
                                        {!! Str::limit(strip_tags($course->description), 50) !!}
                                    </h5>

                                    <span class="btn btn-square btn-primary">
                                        <i class="fa fa-arrow-right"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>
    </div>
    <!-- Service End -->
    
@endsection