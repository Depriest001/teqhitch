@extends('frontLayout')
@section('title', $service->title . ' - Teqhitch ICT Academy LTD')
@section('content')

<!-- Hero Start -->
<div class="container-fluid pt-5 hero-header">
    <div class="container pt-5">
        <div class="row g-5 pt-5">
            <div class="col-lg-6 align-self-center text-center text-lg-start mb-lg-5">
                <h1 class="display-4 text-white mb-4 animated slideInRight">{{ $service->title }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center justify-content-lg-start mb-0">
                        <li class="breadcrumb-item"><a class="text-white" href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-white" href="{{ route('services') }}">Service</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">{{ $service->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->

<!-- Detail Start -->
<div class="container-fluid py-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-8">
                <img class="img-fluid rounded w-100 mb-4" src="{{ asset('storage/' . $service->thumbnail) }}" alt="{{ $service->title }}">
                
                <h1 class="mb-3">{{ $service->title }}</h1>
                
                <p class="mb-5">{!! $service->description !!}</p>
            </div>

            <div class="col-lg-4">
                <h3 class="mb-3">Course Details</h3>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0">
                        <strong>Price:</strong> ₦{{ number_format($service->price, 2) }}
                    </li>
                    <li class="list-group-item px-0">
                        <strong>Duration:</strong> {{ $service->duration }}
                    </li>
                </ul>

                <h3 class="mb-3">Other Course</h3>
                <div class="bg-light rounded py-3 px-4 mb-5">
                    <ul class="list-group list-group-flush">
                        @foreach($allServices as $s)
                        <li class="list-group-item bg-light px-0">
                            <a href="{{ route('service.show', $s->slug) }}" class="h6 fw-normal">
                                <i class="fa fa-arrow-circle-right text-primary me-2"></i>{{ $s->title }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <!-- Get in Touch & CTA remain the same -->
            </div>
        </div>
    </div>
</div>
<!-- Detail End -->

@endsection
