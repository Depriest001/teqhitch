@extends('frontLayout')
@section('title','Services - Teqhitch ICT Academy LTD')

@section('content')
<style>
body{
    background: #fcfcfc;
}
.btn-outline-primary{color:#1363C6;border-color:#1363C6}
.btn-outline-primary:hover{color:#fff;background-color:#1363C6;border-color:#1363C6}
</style>

<div class="container-fluid pt-5 hero-header">
    <div class="container pt-5">
        <div class="col-md-8 offset-md-2 text-center mb-lg-5">
            <h1 class="display-4 text-white mb-4 animated slideInRight">
                Innovative Tech Training & Digital Solutions
            </h1>
            <p class="text-white pb-4">
                At Teqhitch ICT Academy, we provide industry-driven technology training
                & digital solutions designed to equip individuals and organizations
                with practical skills for the modern digital economy.
            </p>
        </div>
    </div>
</div>
<!-- Hero End -->


<!-- TECH TRAINING -->
<section class="py-5">
    <div class="container">
        <div class="mb-5">
            <h2 class="fw-bold">Tech Training</h2>
        </div>
        
        <div class="row g-4">

            @forelse($courses as $course)
                <div class="col-sm-6 col-lg-4">
                    <div class="card service-card border-0 shadow-sm h-100 p-4 d-flex flex-column">

                        <div class="d-flex mb-3">
                            {{-- Icon (fallback if empty) --}}
                            <i class="{{ $course->icon ?? 'fas fa-graduation-cap' }} fa-3x text-primary me-3"></i>

                            <h4 class="fw-bold">
                                {{ $course->title }}
                            </h4>
                        </div>

                        <p class="text-muted">
                            {{ Str::limit(strip_tags($course->description), 120) }}
                        </p>

                        <div class="mt-auto">
                            <a href="{{ route('service.show', $course->slug) }}"
                            class="btn btn-outline-primary"
                            style="border-radius: 5px;">
                                Learn More
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No courses available at the moment.</p>
                </div>
            @endforelse

        </div>
    </div>
</section>


<!-- DIGITAL SOLUTIONS -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="mb-5">
            <h2 class="fw-bold">Digital Solutions</h2>
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card service-card border-0 shadow h-100 p-4">
                    <div class="d-flex mb-3">
                        <i class="fas fa-laptop-code fa-3x text-primary me-3"></i>
                        <h4 class="fw-bold">Website Development</h4>
                    </div>
                    
                    <p class="text-muted">
                        Custom, responsive and SEO-friendly websites
                        tailored to your business needs.
                    </p>
                    <div class="mt-auto">
                        <a href="#" class="btn btn-outline-primary col-5" style="border-radius: 5px;">Learn More</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card service-card border-0 shadow h-100 p-4">
                    <div class="d-flex mb-3">
                        <i class="fas fa-cogs fa-3x text-primary me-3"></i>
                        <h4 class="fw-bold">Business Software Development</h4>
                    </div>
                    <p class="text-muted">
                        Create efficient, scalable and customized
                        software solutions for your operations.
                    </p>
                    <div class="mt-auto">
                        <a href="#" class="btn btn-outline-primary col-5" style="border-radius: 5px;">Learn More</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card service-card border-0 shadow h-100 p-4">
                    <div class="d-flex mb-3">
                        <i class="fas fa-shopping-cart fa-3x text-primary me-3"></i>
                        <h4 class="fw-bold">E-commerce Development</h4>
                    </div>
                    
                    <p class="text-muted">
                        Build secure, feature-rich online stores
                        to boost your digital sales.
                    </p>
                    <div class="mt-auto">
                        <a href="#" class="btn btn-outline-primary col-5" style="border-radius: 5px;">Learn More</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- WHY CHOOSE US -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-md-6">
                <h3 class="fw-bold mb-4">Why Choose Teqhitch</h3>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle me-2"
                            style="width: 20px; height: 20px; font-size: 12px;">
                            <i class="fa fa-check small"></i>
                        </div>
                        Industry based curriculum
                    </li>
                    <li class="mb-2">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle me-2"
                            style="width: 20px; height: 20px; font-size: 12px;">
                            <i class="fa fa-check small"></i>
                        </div>
                        Experienced instructors
                    </li>
                    <li class="mb-2">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle me-2"
                            style="width: 20px; height: 20px; font-size: 12px;">
                            <i class="fa fa-check small"></i>
                        </div>
                        Hands-on project training
                    </li>
                    <li class="mb-2">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle me-2"
                            style="width: 20px; height: 20px; font-size: 12px;">
                            <i class="fa fa-check small"></i>
                        </div>
                        Internship opportunities
                    </li>
                    <li>
                        <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-circle me-2"
                            style="width: 20px; height: 20px; font-size: 12px;">
                            <i class="fa fa-check small"></i>
                        </div>
                        Career mentorship
                    </li>
                </ul>
            </div>
            <!-- <div class="col-md-5 ps-lg-0 pt-5 pt-md-0 text-start wow fadeIn" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeIn;">
                    <img class="img-fluid" src="{{ asset('assets/img/newsletter.png')}}" alt="">
                </div> -->
            <div class="col-md-6 text-center">
                <img class="img-fluid" src="{{ asset('assets/img/newsletter.png')}}" alt="Why Choose Us" style="transform: scaleX(-1);">
            </div>

        </div>
    </div>
</section>


<!-- CTA -->
<section class="py-5 text-center text-white bg-primary" style="background: linear-gradient(to right, #14183E, #1b7c74, #14183E);">
    <div class="container">
        <h3 class="fw-bold text-white mb-3">Start Your Tech Journey Today</h3>
        <a href="{{ route('register') }}" class="btn btn-light px-4">Enroll Now</a>
    </div>
</section>

@endsection