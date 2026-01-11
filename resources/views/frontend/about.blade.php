@extends('frontLayout')
@section('title','About - Teqhitch ICT Academy LTD')
@section('content')
    
    <!-- Hero Start -->
    <div class="container-fluid pt-5 hero-header">
        <div class="container pt-5">
            <div class="row g-5 pt-5">
                <div class="col-lg-6 align-self-center text-center text-lg-start mb-lg-5">
                    <h1 class="display-4 text-white mb-4 animated slideInRight">About Us</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center justify-content-lg-start mb-0">
                            <li class="breadcrumb-item"><a class="text-white" href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">About Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->


    <!-- About Start -->
    <div class="container-fluid">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="about-img">
                        <img class="img-fluid" src="{{asset('assets/img/banner1.jpeg')}}">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="btn btn-sm border rounded-pill text-primary px-3 mb-3">About Us</div>
                    <h1 class="mb-4">Brief History Teqhitch ICT Academy LTD</h1>
                    {!! $systemInfo->about !!}
                    
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- CAC Start -->
    <div class="container-fluid py-lg-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 order-2 order-md-1 wow fadeIn" data-wow-delay="0.5s">
                    <div class="py-4 border-bottom">
                        <h1 class="mb-3">Our Mission</h1>
                        <p>
                            To empower individuals and organizations through innovative, industry-relevant ICT education that builds practical skills, nurtures creativity, and drives digital transformation across Africa and beyond.
                        </p>
                    </div>
                    <div class="py-4">
                        <h1 class="mb-3">Our Vision</h1>
                        <p>
                            To become a leading ICT training institution recognized for excellence in digital skills development, fostering a generation of tech-driven problem solvers, innovators, and entrepreneurs.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-md-2 wow fadeIn" data-wow-delay="0.1s">
                    <div class="">
                        <img class="img-fluid" src="{{asset('assets/img/cac.jpg')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CAC End -->

    <!-- Team Start -->
    <div class="container-fluid bg-light py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                    <div class="btn btn-sm border rounded-pill text-primary px-3 mb-3">Our Team</div>
                    <h1 class="mb-4">Meet Our Experienced Team Members</h1>
                    <p class="mb-4">
                        Our team consists of skilled ICT professionals, instructors, and project experts with strong industry and academic experience. 
                        They are committed to delivering quality training, executing reliable technology projects, and providing expert guidance to students and organizations.
                    </p>
                    <a class="btn btn-primary rounded-pill px-4" href="">Read more</a>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="row g-4">
                                <div class="col-12 wow fadeIn" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                                    <div class="team-item bg-white text-center rounded p-4 pt-0">
                                        <img class="img-fluid rounded-circle p-4" src="{{ asset('assets/img/user/icon-male.png')}}" alt="">
                                        <h5 class="mb-0">Mbam Smart Ozichukwu</h5>
                                        <small>Founder &amp; CEO</small>
                                        <div class="d-flex justify-content-center mt-3">
                                            <a class="btn btn-square btn-primary m-1" href=""><i class="fab fa-facebook-f"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href=""><i class="fab fa-twitter"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href=""><i class="fab fa-instagram"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href=""><i class="fab fa-linkedin-in"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 wow fadeIn" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeIn;">
                                    <div class="team-item bg-white text-center rounded p-4 pt-0">
                                        <img class="img-fluid rounded-circle p-4" src="{{ asset('assets/img/user/icon-female.png')}}" alt="">
                                        <h5 class="mb-0">Mbam Faith Smart</h5>
                                        <small>Executive Manager</small>
                                        <div class="d-flex justify-content-center mt-3">
                                            <a class="btn btn-square btn-primary m-1" href=""><i class="fab fa-facebook-f"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href=""><i class="fab fa-twitter"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href=""><i class="fab fa-instagram"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href=""><i class="fab fa-linkedin-in"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 pt-md-4">
                            <div class="row g-4">
                                <div class="col-12 wow fadeIn" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeIn;">
                                    <div class="team-item bg-white text-center rounded p-4 pt-0">
                                        <img class="img-fluid rounded-circle p-4" src="{{ asset('assets/img/user/icon-male.png')}}" alt="">
                                        <h5 class="mb-0">Mbam Tobias Chiedozie</h5>
                                        <small>Co Founder</small>
                                        <div class="d-flex justify-content-center mt-3">
                                            <a class="btn btn-square btn-primary m-1" href=""><i class="fab fa-facebook-f"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href=""><i class="fab fa-twitter"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href=""><i class="fab fa-instagram"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href=""><i class="fab fa-linkedin-in"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 wow fadeIn" data-wow-delay="0.7s" style="visibility: visible; animation-delay: 0.7s; animation-name: fadeIn;">
                                    <div class="team-item bg-white text-center rounded p-4 pt-0">
                                        <img class="img-fluid rounded-circle p-4" src="{{ asset('assets/img/user/icon-male.png')}}" alt="">
                                        <h5 class="mb-0">Linus Mario</h5>
                                        <small>Project Manager</small>
                                        <div class="d-flex justify-content-center mt-3">
                                            <a class="btn btn-square btn-primary m-1" href=""><i class="fab fa-facebook-f"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href=""><i class="fab fa-twitter"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href=""><i class="fab fa-instagram"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href=""><i class="fab fa-linkedin-in"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->
    
@endsection