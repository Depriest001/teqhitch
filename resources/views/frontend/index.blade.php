@extends('frontLayout')
@section('title','Home - Teqhitch ICT Academy LTD')
@section('content')
    <!-- Hero Start -->
    <div id="heroCarousel" class="carousel carousel-fade hero-carousel hero-header mb-5" data-bs-ride="carousel" data-bs-interval="9000">
        <div class="carousel-indicators custom-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">

            <!-- Slide 1 -->
            <div class="carousel-item active" style="background-image:url('{{ asset('assets/img/banner1.jpeg')}}');">
                <div class="overlay"></div>
                <div class="container h-100 d-flex align-items-center">
                    <div class="hero-content">
                        <p class="fadeInUp" data-wow-delay="0.5s">
                            We provides cutting-edge digital skills, IT training, and professional certifications — shaping the future of Nigeria’s tech workforce
                        </p>
                        <h1 class="fadeInUp" data-wow-delay="1.2s">
                            Start Your <span>Tech Journey</span> Today
                        </h1>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-register fadeInUp" data-wow-delay="1.9s">
                            Register Now
                            <span class="btn"><i class="fa fa-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item" style="background-image:url('{{ asset('assets/img/hero-img.png')}}');">
                <div class="overlay"></div>
                <div class="container h-100 d-flex align-items-center">
                    <div class="hero-content">
                    <p class="fadeInUp" data-wow-delay="0.5s">Learn practical and in-demand digital skills.</p>
                    <h1 class="fadeInUp" data-wow-delay="1.2s">Gain <span>TECH SKILLS</span><br>That Earn Real Income</h1>
                    <a href="#" class="btn btn-outline-primary btn-register fadeInUp" data-wow-delay="1.9s">
                        Explore Courses
                        <span class="btn"><i class="fa fa-arrow-right"></i></span>
                    </a>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item" style="background-image:url('{{ asset('assets/img/teqhitch.jpg')}}');">
                <div class="overlay"></div>
                <div class="container h-100 d-flex align-items-center">
                    <div class="hero-content">
                    <p class="fadeInUp" data-wow-delay="0.5s">Start your journey into technology today.</p>
                    <h1 class="fadeInUp" data-wow-delay="1.2s">From <span>BEGINNER</span><br>to Industry Ready</h1>
                    <a href="#" class="btn btn-outline-primary btn-register fadeInUp" data-wow-delay="1.9s">
                        Get Started
                        <span class="btn"><i class="fa fa-arrow-right"></i></span>
                    </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Hero End -->

    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 fadeIn" data-wow-delay="0.1s">
                    <div class="about-img">
                        <img class="img-fluid" src="{{asset('assets/img/banner1.jpeg')}}">
                    </div>
                </div>
                <div class="col-lg-6 fadeIn" data-wow-delay="0.5s">
                    <div class="btn btn-sm border rounded-pill text-primary px-3 mb-3">About Us</div>
                    <h1 class="mb-4">Building Digital Skills, Delivering Smart Technology Solutions</h1>

                    <p class="mb-4">
                        Teqhitch ICT Academy is a registered technology company in Nigeria focused on 
                        training the next generation of tech professionals while delivering innovative, 
                        real-world digital solutions for individuals and organizations.
                    </p>

                    <p class="mb-4">
                        We combine practical ICT training with hands-on project execution to ensure 
                        excellence, innovation, and industry relevance across all our services.
                    </p>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <h6 class="mb-3">
                                <i class="fa fa-check text-global me-2"></i>Practical & Industry-Relevant Training
                            </h6>
                            <h6 class="mb-0">
                                <i class="fa fa-check text-global me-2"></i>Experienced Tech Professionals
                            </h6>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="mb-3">
                                <i class="fa fa-check text-global me-2"></i>CAC Registered & Trusted
                            </h6>
                            <h6 class="mb-0">
                                <i class="fa fa-check text-global me-2"></i>Quality Service Delivery
                            </h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-4">
                        <a class="btn btn-primary rounded-pill px-4 me-3" href="{{ route('about') }}">Read More</a>
                        <a class="btn btn-outline-primary btn-square me-3" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-primary btn-square me-3" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-primary btn-square me-3" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-outline-primary btn-square" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

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

    <!-- Case Start -->
    <div class="container-fluid bg-light mt-5 py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 fadeIn" data-wow-delay="0.1s">
                    <div class="btn btn-sm border rounded-pill text-primary px-3 mb-3">Our Services</div>
                    <h1 class="mb-4">Professional ICT Training & Technology Solutions</h1>
                    <p class="mb-4">
                        Teqhitch ICT Academy LTD is a dynamic technology company focused on ICT training, project execution, and academic support. 
                        We provide hands-on learning experiences, deliver real-world digital projects, and develop well-structured seminar and project reports. 
                        Our goal is to equip students and organizations with practical skills and reliable technology solutions for today’s digital world.
                    </p>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="row g-4">
                                <div class="col-12 fadeIn" data-wow-delay="0.1s">
                                    <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                                        <div class="service-icon btn-square">
                                            <i class="fa fa-laptop-code fa-2x"></i>
                                        </div>
                                        <h5 class="mb-3">Practical ICT Training</h5>
                                        <p>
                                            Hands-on ICT training designed to equip students with real-world technical and professional skills.
                                        </p>
                                        <a class="btn px-3 mt-auto mx-auto" href="#">Get Started</a>
                                    </div>
                                </div>

                                <div class="col-12 fadeIn" data-wow-delay="0.5s">
                                    <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                                        <div class="service-icon btn-square">
                                            <i class="fa fa-code fa-2x"></i>
                                        </div>
                                        <h5 class="mb-3">Project Execution</h5>
                                        <p>
                                            Development and execution of ICT projects using modern tools and industry best practices.
                                        </p>
                                        <a class="btn px-3 mt-auto mx-auto" href="#">Get Started</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 pt-md-4">
                            <div class="row g-4">
                                <div class="col-12 fadeIn" data-wow-delay="0.3s">
                                    <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                                        <div class="service-icon btn-square">
                                            <i class="fa fa-file-alt fa-2x"></i>
                                        </div>
                                        <h5 class="mb-3">Seminar & Project Reports</h5>
                                        <p>
                                            Well-structured seminar papers and academic project reports that meet institutional standards.
                                        </p>
                                        <a class="btn px-3 mt-auto mx-auto" href="#">Get Started</a>
                                    </div>
                                </div>

                                <div class="col-12 fadeIn" data-wow-delay="0.7s">
                                    <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                                        <div class="service-icon btn-square">
                                            <i class="fa fa-chalkboard-teacher fa-2x"></i>
                                        </div>
                                        <h5 class="mb-3">Mentorship & Support</h5>
                                        <p>
                                            Continuous guidance and mentorship to support students throughout training and projects.
                                        </p>
                                        <a class="btn px-3 mt-auto mx-auto" href="#">Get Started</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Case End -->

    <!-- Feature Start -->
    <div class="container-fluid bg-primary feature pt-5">
        <div class="container pt-5">
            <div class="row g-5">
                <div class="col-lg-6 align-self-center mb-md-5 pb-md-5 wow fadeIn" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeIn;">
                    <div class="btn btn-sm border rounded-pill text-white px-3 mb-3">Why Choose Us</div>
                    <h1 class="text-white mb-4">We're Best in Tech Industry with many Years of Experience</h1>
                    <p class="text-light mb-4">At Teqhitch ICT Academy LTD, we distinguish ourselves through deep expertise in emerging technologies, 
                        a steadfast dedication to innovation, a strategic global-local outlook, and a results-driven focus on client success — all aimed at helping businesses excel in the digital era.</p>
                    <div class="d-flex align-items-center text-white mb-3">
                        <div class="btn-sm-square bg-white text-primary rounded-circle me-3">
                            <i class="fa fa-check"></i>
                        </div>
                        <span>Expertise in Diverse Technologies</span>
                    </div>
                    <div class="d-flex align-items-center text-white mb-3">
                        <div class="btn-sm-square bg-white text-primary rounded-circle me-3">
                            <i class="fa fa-check"></i>
                        </div>
                        <span>Innovation-Driven Approach</span>
                    </div>
                    <div class="d-flex align-items-center text-white mb-3">
                        <div class="btn-sm-square bg-white text-primary rounded-circle me-3">
                            <i class="fa fa-check"></i>
                        </div>
                        <span>Global Reach, Local Expertise</span>
                    </div>
                    <div class="d-flex align-items-center text-white mb-3">
                        <div class="btn-sm-square bg-white text-primary rounded-circle me-3">
                            <i class="fa fa-check"></i>
                        </div>
                        <span>Client-Centric Philosophy</span>
                    </div>
                    <div class="row g-4 pt-3">
                        <div class="col-sm-6">
                            <div class="d-flex rounded p-3" style="background: rgba(256, 256, 256, 0.1);">
                                <i class="fa fa-users fa-3x text-white"></i>
                                <div class="ms-3">
                                    <h2 class="text-white mb-0"><span data-toggle="counter-up">500</span>+</h2>
                                    <p class="text-white mb-0">Happy Clients</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex rounded p-3" style="background: rgba(256, 256, 256, 0.1);">
                                <i class="fa fa-check fa-3x text-white"></i>
                                <div class="ms-3">
                                    <h2 class="text-white mb-0"><span data-toggle="counter-up">999</span>+</h2>
                                    <p class="text-white mb-0">Completed Projects</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 align-self-center text-center text-md-end wow fadeIn" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeIn;">
                    <img class="img-fluid" src="{{ asset('assets/img/cac.jpg')}}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End -->

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

    <!-- Testimonial Start -->
    <div class="container-xxl py-5">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                    <div class="btn btn-sm border rounded-pill text-primary px-3 mb-3">Testimonial</div>
                    <h1 class="mb-4">What Say Our Clients!</h1>
                    <p class="mb-4">
                        Our clients and students consistently share positive feedback about our practical training approach, 
                        quality project delivery, and professional academic support. Their satisfaction reflects our commitment 
                        to excellence, innovation, and reliable technology solutions.
                    </p>
                </div>
                <div class="col-lg-7 wow fadeIn" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeIn;">
                    <div class="owl-carousel testimonial-carousel border-start border-global owl-loaded owl-drag">

                        <div class="testimonial-item ps-5">
                            <i class="fa fa-quote-left text-global mb-3"></i>
                            <p>Teqhitch ICT Academy gave me the foundation I needed to launch my career in web development. The hands-on training and support from the instructors were outstanding. I highly recommend them to anyone serious about tech.</p>
                            <div class="d-flex align-items-center">
                                <img class="img-fluid rounded-circle" src="{{ asset('assets/img/testimonial-1.jpg')}}" style="width:50px;height:50px;">
                                <div class="ps-3">
                                    <h5 class="mb-1">Alex Brandon</h5>
                                    <span>Web Dveloper</span>
                                </div>
                            </div>
                        </div>

                        <div class="testimonial-item ps-5">
                            <i class="fa fa-quote-left text-global mb-3"></i>
                            <p>Learning at Teqhitch ICT Academy was the best decision I made. The classes were interactive, the environment was supportive, and I left with the skills and confidence to work on real-world tech projects.</p>
                            <div class="d-flex align-items-center">
                                <img class="img-fluid rounded-circle" src="{{ asset('assets/img/testimonial-2.jpg')}}" style="width:50px;height:50px;">
                                <div class="ps-3">
                                    <h5 class="mb-1">Ada Lucy</h5>
                                    <span>Freelancer</span>
                                </div>
                            </div>
                        </div>

                        <div class="testimonial-item ps-5">
                            <i class="fa fa-quote-left text-global mb-3"></i>
                            <p>I enrolled in the Cybersecurity program with zero background, but the structured curriculum and expert guidance made everything easy to understand. Today, I'm working as a security analyst thanks to Teqhitch.</p>
                            <div class="d-flex align-items-center">
                                <img class="img-fluid rounded-circle" src="{{ asset('assets/img/testimonial-3.jpg')}}" style="width:50px;height:50px;">
                                <div class="ps-3">
                                    <h6 class="mb-1">Rexford</h6>
                                    <span>Security Analyst</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    <!-- FAQs Start -->
    <div class="container-fluid">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px; visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                <div class="btn btn-sm border rounded-pill text-primary px-3 mb-3">Popular FAQs</div>
                <h1 class="mb-4">Frequently Asked Questions</h1>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="accordion" id="accordionFAQ1">
                        <div class="accordion-item wow fadeIn" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    What is Teqhitch ICT Academy?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionFAQ1">
                                <div class="accordion-body">
                                    Teqhitch ICT Academy is a registered technology company in Nigeria dedicated to training the next generation of tech professionals while providing innovative, real-world digital solutions for individuals and organizations.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeIn" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeIn;">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Is Teqhitch ICT Academy officially registered in Nigeria?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionFAQ1">
                                <div class="accordion-body">
                                    Yes, Teqhitch ICT Academy is a legally registered technology company operating in Nigeria.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeIn" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeIn;">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    What courses or training programs does Teqhitch ICT Academy offer?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionFAQ1">
                                <div class="accordion-body">
                                    The academy offers practical ICT and technology-based training programs designed to equip learners with in-demand digital skills for today’s job market.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeIn" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeIn;">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                    Who can enroll in Teqhitch ICT Academy programs?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionFAQ1">
                                <div class="accordion-body">
                                    Our programs are open to students, graduates, working professionals, and individuals with little or no prior tech experience who are interested in building a career in technology.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="accordion" id="accordionFAQ2">
                        <div class="accordion-item wow fadeIn" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeIn;">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Does the academy offer solutions for businesses and organizations?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionFAQ2">
                                <div class="accordion-body">
                                    Yes, beyond training, Teqhitch ICT Academy delivers innovative digital solutions such as software development, ICT consulting, and technology support services.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeIn" data-wow-delay="0.6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeIn;">
                            <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    Does Teqhitch ICT Academy provide certifications after training?
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionFAQ2">
                                <div class="accordion-body">
                                    Yes, participants receive certificates upon successful completion of their training programs.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeIn" data-wow-delay="0.7s" style="visibility: visible; animation-delay: 0.7s; animation-name: fadeIn;">
                            <h2 class="accordion-header" id="headingSeven">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                    What makes Teqhitch ICT Academy different from other ICT training centers?
                                </button>
                            </h2>
                            <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionFAQ2">
                                <div class="accordion-body">
                                    Teqhitch ICT Academy emphasizes hands-on learning, real-world projects, industry-relevant skills, and mentorship to ensure students are job-ready.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item wow fadeIn" data-wow-delay="0.8s" style="visibility: visible; animation-delay: 0.8s; animation-name: fadeIn;">
                            <h2 class="accordion-header" id="headingEight">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                    How can I enroll or contact Teqhitch ICT Academy?
                                </button>
                            </h2>
                            <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#accordionFAQ2">
                                <div class="accordion-body">
                                    Interested individuals and organizations can enroll or make inquiries through our official website, social media platforms, or by contacting the academy directly.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQs End -->

    <script>
        const carousel = document.getElementById('heroCarousel');

        function animateSlide(slide) {
        const animatedEls = slide.querySelectorAll('.hero-content p, .hero-content h1, .hero-content a');
            animatedEls.forEach(el => {
                el.classList.remove('animated', 'fadeInUp');  // remove classes
                void el.offsetWidth;                           // trigger reflow
                el.classList.add('animated', 'fadeInUp');     // re-add classes to restart
            });
        }

        // Animate first slide on load
        animateSlide(document.querySelector('.carousel-item.active'));

        // Animate each slide when it becomes active
        carousel.addEventListener('slide.bs.carousel', (event) => {
            setTimeout(() => {
                animateSlide(event.relatedTarget);
            }, 50);
        });
    </script>
@endsection