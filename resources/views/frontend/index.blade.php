@extends('frontLayout')
@section('title','Home - Teqhitch ICT Academy LTD')
@section('content')

    <style>
        .gallery-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: none;
            background: var(--bs-primary, #0d6efd);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            z-index: 10;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .gallery-nav-btn:hover {
            background: #fff;
            color: var(--bs-primary, #0d6efd);
        }
        .gallery-prev {
            left: -22px;
        }
        .gallery-next {
            right: -22px;
        }
		.hero-content h1{
			font-size: 2.5em !important;
		}
        @media (max-width: 767px) {
            .gallery-prev { left: 0; }
            .gallery-next { right: 0; }
			
			.hero-content h1{
				font-size: 2em !important;
			}
        }

        .marquee-section {
            overflow: hidden;
        }
        .marquee-wrap {
            width: 100%;
            overflow: hidden;
            -webkit-mask-image: linear-gradient(to right, transparent 0%, #000 8%, #000 92%, transparent 100%);
            mask-image: linear-gradient(to right, transparent 0%, #000 8%, #000 92%, transparent 100%);
        }
        .marquee-track {
            display: flex;
            align-items: center;
            width: max-content;
            animation: marquee-scroll 30s linear infinite;
        }
        .marquee-wrap:hover .marquee-track {
            animation-play-state: paused;
        }
        .marquee-logo {
            flex: 0 0 auto;
            padding: 0 35px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .marquee-logo img {
            height: 38px;
            width: auto;
            max-width: 120px;
            object-fit: contain;
        }
        @keyframes marquee-scroll {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        @media (max-width: 767px) {
            .marquee-logo { padding: 0 20px; }
            .marquee-logo img { height: 28px; }
        }
    </style>

    <!-- Hero Start -->
    <div id="heroCarousel" class="carousel carousel-fade hero-carousel hero-header mb-3 mb-md-5" data-bs-ride="carousel" data-bs-interval="9000">
        <div class="carousel-indicators custom-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">

            <!-- Slide 1 -->
            <div class="carousel-item active" style="background-image:url('https://persecondnews.com/wp-content/uploads/2021/10/Tech-IT-professionals-in-Nigeria.jpg');">
                <div class="overlay"></div>
                <div class="container h-100 d-flex align-items-center">
                    <div class="hero-content text-center">
                        <p class="fadeInUp" data-wow-delay="0.5s">
                            We provides cutting-edge digital skills, IT training, and professional certifications — shaping the future of Nigeria's tech workforce
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
            <div class="carousel-item" style="background-image:url('https://plus.unsplash.com/premium_photo-1682141007707-1f09c5a1d814?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8cHJvZ3JhbW1pbmclMjBjb2RlJTIwY2xhc3N8ZW58MHx8MHx8fDA%3D');">
                <div class="overlay"></div>
                <div class="container h-100 d-flex align-items-center">
                    <div class="hero-content text-center">
                    <p class="fadeInUp" data-wow-delay="0.5s">Learn practical and in-demand digital skills.</p>
                    <h1 class="fadeInUp" data-wow-delay="1.2s">Gain <span>Tech Skills</span> That Earn Real Income</h1>
                    <a href="{{ route('services') }}" class="btn btn-outline-primary btn-register fadeInUp" data-wow-delay="1.9s">
                        Explore Courses
                        <span class="btn"><i class="fa fa-arrow-right"></i></span>
                    </a>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item" style="background-image:url('https://images.unsplash.com/photo-1710770563074-6d9cc0d3e338?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
                <div class="overlay"></div>
                <div class="container h-100 d-flex align-items-center">
                    <div class="hero-content text-center">
                    <p class="fadeInUp" data-wow-delay="0.5s">Start your journey into technology today.</p>
                    <h1 class="fadeInUp" data-wow-delay="1.2s">From <span>Beginner</span> to Industry Ready</h1>
                    <a href="{{ route('enroll') }}" class="btn btn-outline-primary btn-register fadeInUp" data-wow-delay="1.9s">
                        Get Started
                        <span class="btn"><i class="fa fa-arrow-right"></i></span>
                    </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Hero End -->

    <!-- Trusted By / Tech Marquee Start -->
    <div class="container-fluid marquee-section py-3">
        <div class="container text-center mb-3 wow fadeIn" data-wow-delay="0.1s">
            <span class="font-mono uppercase text-muted d-block">Trusted By Leading Organizations</span>
        </div>

        <div class="marquee-wrap">
            <div class="marquee-track">
                <!-- Set 1 -->
                <div class="marquee-logo"><img src="https://www.vectorlogo.zone/logos/google/google-icon.svg" alt="Google"></div>
                <div class="marquee-logo"><img src="https://uhf.microsoft.com/images/microsoft/RE1Mu3b.png" alt="Microsoft"></div>
                <div class="marquee-logo"><img src="https://www.adobe.com/cc-shared/assets/img/product-icons/svg/adobe-corp-logo-2024.svg" alt="Adobe"></div>
                <div class="marquee-logo"><img src="https://www.uicto.edu.ng/assets/images/logo-main.png" alt="UNICTO"></div>
                <div class="marquee-logo"><img src="https://shorturl.at/f6KTc" alt="EBSU"></div>
                <div class="marquee-logo"><img src="https://tinyurl.com/4w8xuvwx" alt="IBM"></div>
                <div class="marquee-logo"><img src="https://tinyurl.com/34waph86" alt="Oracle"></div>
                <div class="marquee-logo"><img src="https://www.vectorlogo.zone/logos/cisco/cisco-icon.svg" alt="Cisco"></div>
                <div class="marquee-logo"><img src="https://www.vectorlogo.zone/logos/dell/dell-icon.svg" alt="Dell"></div>
                <div class="marquee-logo"><img src="https://www.vectorlogo.zone/logos/hp/hp-icon.svg" alt="HP"></div>
                <div class="marquee-logo"><img src="https://tinyurl.com/mt6punee" alt="Amazon"></div>

                <!-- Set 2 (duplicate for seamless loop) -->
                <div class="marquee-logo"><img src="https://www.vectorlogo.zone/logos/google/google-icon.svg" alt="Google"></div>
                <div class="marquee-logo"><img src="https://uhf.microsoft.com/images/microsoft/RE1Mu3b.png" alt="Microsoft"></div>
                <div class="marquee-logo"><img src="https://www.adobe.com/cc-shared/assets/img/product-icons/svg/adobe-corp-logo-2024.svg" alt="Adobe"></div>
                <div class="marquee-logo"><img src="https://www.uicto.edu.ng/assets/images/logo-main.png" alt="UNICTO"></div>
                <div class="marquee-logo"><img src="https://shorturl.at/f6KTc" alt="EBSU"></div>
                <div class="marquee-logo"><img src="https://tinyurl.com/4w8xuvwx" alt="IBM"></div>
                <div class="marquee-logo"><img src="https://tinyurl.com/34waph86" alt="Oracle"></div>
                <div class="marquee-logo"><img src="https://www.vectorlogo.zone/logos/cisco/cisco-icon.svg" alt="Cisco"></div>
                <div class="marquee-logo"><img src="https://www.vectorlogo.zone/logos/dell/dell-icon.svg" alt="Dell"></div>
                <div class="marquee-logo"><img src="https://www.vectorlogo.zone/logos/hp/hp-icon.svg" alt="HP"></div>
                <div class="marquee-logo"><img src="https://tinyurl.com/mt6punee" alt="Amazon"></div>    
            </div>
        </div>
    </div>
    <!-- Trusted By / Tech Marquee End -->

    <!-- About Start -->
    <div class="container-fluid py-3">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="about-img wow slideInLeft" data-wow-delay="0.1s">
                        <img class="img-fluid" src="{{asset('assets/img/banner1.jpeg')}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="news-header-eyebrow wow fadeInUp" data-wow-delay="0.1s">
                        <span class="font-mono">[01]</span>
                        <div class="tech-line w-12"></div>
                        <span class="font-mono uppercase">About Us</span>
                    </div>
                    <h3 class="mb-4 wow fadeInUp" data-wow-delay="0.1s">Building Digital Skills, Delivering Smart Technology Solutions</h3>

                    <p class="mb-4 wow fadeInUp" data-wow-delay="0.2s">
                        Teqhitch ICT Academy is a registered technology company in Nigeria focused on 
                        training the next generation of tech professionals while delivering innovative, 
                        real-world digital solutions for individuals and organizations.
                    </p>

                    <p class="mb-4 wow fadeInUp" data-wow-delay="0.2s">
                        We combine practical ICT training with hands-on project execution to ensure 
                        excellence, innovation, and industry relevance across all our services.
                    </p>

                    <div class="row g-3 wow fadeInUp" data-wow-delay="0.3s">
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
                    @php
                        $social = $systemInfo->social_links ?? [];
                    @endphp
                    <div class="d-flex flex-wrap align-items-center gap-3 mt-4 wow fadeInUp" data-wow-delay="0.3s">
                        <a class="btn btn-primary rounded-pill px-4 about-link w-60 w-sm-auto order-last order-sm-first" href="{{ route('about') }}">Read More</a>

                        @if(!empty($social['facebook']))
                            <a class="btn btn-outline-primary btn-square order-1" href="{{ $social['facebook'] }}" target="_blank" rel="noopener">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif

                        @if(!empty($social['twitter']))
                            <a class="btn btn-outline-primary btn-square order-2" href="{{ $social['twitter'] }}" target="_blank" rel="noopener">
                                <i class="fab fa-twitter"></i>
                            </a>
                        @endif

                        @if(!empty($social['instagram']))
                            <a class="btn btn-outline-primary btn-square order-3" href="{{ $social['instagram'] }}" target="_blank" rel="noopener">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif

                        @if(!empty($social['tiktok']))
                            <a class="btn btn-outline-primary btn-square d-inline-flex align-items-center justify-content-center order-4" href="{{ $social['tiktok'] }}" target="_blank" rel="noopener">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 448 512" style="margin-bottom: 2px;">
                                    <path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a72.59,72.59,0,1,0,50.23,69.63V0h90.08a101.58,101.58,0,0,0,10.6,43.43,103.54,103.54,0,0,0,76.54,58.46V209.91Z"/>
                                </svg>
                            </a>
                        @endif

                        @if(!empty($social['linkedin']))
                            <a class="btn btn-outline-primary btn-square order-5" href="{{ $social['linkedin'] }}" target="_blank" rel="noopener">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        @endif

                        @if(!empty($social['youtube']))
                            <a class="btn btn-outline-primary btn-square order-6" href="{{ $social['youtube'] }}" target="_blank" rel="noopener">
                                <i class="fab fa-youtube"></i>
                            </a>
                        @endif

                        @if(!empty($social['whatsapp']))
                            <a class="btn btn-outline-primary btn-square order-7" href="{{ $social['whatsapp'] }}" target="_blank" rel="noopener">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
  
    <!-- Programs Start -->
    <section class="curriculum-section py-3 wow flipInX" data-wow-delay="0.2s">
        <div class="container py-4">
            <div class="news-header-eyebrow">
                <span class="font-mono">[02]</span>
                <div class="tech-line w-12"></div>
                <span class="font-mono uppercase">Our Programs</span>
            </div>
            <div class="curriculum-header">
                <h3 class="fw-bold">Programs Engineered<br class="d-none d-md-block"> for the Industry</h3>
                <a href="{{ route('services') }}" class="view-all-link">
                    View all programs
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="tech-line tech-line-full"></div>

            <div class="curriculum-list">
                @forelse($courses as $course)
                    @php
                        $level = $course->level ?? 'Intermediate';
                        $levelClass = match(strtolower($level)) {
                            'beginner' => 'level-beginner',
                            'advanced' => 'level-advanced',
                            default => 'level-intermediate',
                        };
                        $skills = is_array($course->skills ?? null)
                            ? $course->skills
                            : array_filter(array_map('trim', explode(',', $course->skills ?? '')));
                    @endphp
                    <div class="curriculum-item">
                        <button type="button" class="curriculum-row" data-target="panel-{{ $course->id }}">
                            <span class="curriculum-num font-mono">{{ sprintf('%02d', $loop->iteration) }}</span>
                            <i class="curriculum-icon {{ $course->icon ?? 'fas fa-graduation-cap' }}"></i>

                            <span class="curriculum-title">{{ $course->title }}</span>

                            @isset($course->category)
                                <span class="curriculum-tag font-mono">{{ Str::upper($course->category) }}</span>
                            @endisset

                            @isset($course->duration)
                                <span class="curriculum-duration">
                                    <i class="far fa-clock"></i>
                                    <span class="font-mono">{{ $course->duration }}</span>
                                </span>
                            @endisset

                            <span class="curriculum-level {{ $levelClass }} font-mono">{{ $level }}</span>

                            <i class="fas fa-arrow-right curriculum-arrow"></i>
                        </button>

                        <div class="curriculum-panel" id="panel-{{ $course->id }}">
                            <div class="curriculum-panel-inner">
                                @if($course->thumbnail)
                                    <div class="curriculum-panel-img">
                                        <img src="{{ $course->thumbnail ? asset('uploads/'.$course->thumbnail) : '' }}" alt="{{ $course->title }}">
                                    </div>
                                @endif

                                <div class="curriculum-panel-body">
                                    @isset($course->description)
                                        <p class="curriculum-panel-desc">{{ $course->description }}</p>
                                    @endisset

                                    @if(!empty($course->outcomes))
                                        <div class="curriculum-panel-tags">
                                            @foreach($course->outcomes as $skill)
                                                <span class="tech-tag font-mono">{{ $skill->content }}</span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <a href="{{ route('enroll') }}" class="btn btn-primary rounded-sm curriculum-enroll-btn">
                                        Enroll in this Program
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <p class="text-muted mb-0">No courses available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- Programs End -->

    <!-- Our Services Start -->
    <div class="container-fluid bg-light py-3">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-5">
                    <div class="news-header-eyebrow wow slideInLeft" data-wow-delay="0.1s">
                        <span class="font-mono">[03]</span>
                        <div class="tech-line w-12"></div>
                        <span class="font-mono uppercase">Our Services</span>
                    </div>
                    <h3 class="mb-4 wow slideInLeft" data-wow-delay="0.1s">Professional ICT Training & Technology Solutions</h3>
                    <p class="mb-4 wow slideInLeft" data-wow-delay="0.1s">
                        Teqhitch ICT Academy LTD is a dynamic technology company focused on ICT training, project execution, and academic support. 
                        We provide hands-on learning experiences, deliver real-world digital projects, and develop well-structured seminar and project reports. 
                        Our goal is to equip students and organizations with practical skills and reliable technology solutions for today's digital world.
                    </p>
                    <img src="{{ asset( asset('assets/img/services-image.png')) }}" alt="services-image" width="100%" class="wow slideInLeft" data-wow-delay="0.1s">
                    
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="row g-4">
                                <div class="col-12 wow fadeIn" data-wow-delay="0.2s">
                                    <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                                        <div class="service-icon btn-square">
                                            <i class="fa fa-laptop-code fa-2x"></i>
                                        </div>
                                        <h5 class="mb-3">Practical ICT Training</h5>
                                        <p>
                                            Hands-on ICT training designed to equip students with real-world technical and professional skills.
                                        </p>
                                        <a class="btn px-3 mt-auto mx-auto" href="{{ route('services') }}">Get Started</a>
                                    </div>
                                </div>

                                <div class="col-12 wow fadeIn" data-wow-delay="0.4s">
                                    <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                                        <div class="service-icon btn-square">
                                            <i class="fa fa-code fa-2x"></i>
                                        </div>
                                        <h5 class="mb-3">Project Execution</h5>
                                        <p>
                                            Development and execution of ICT projects using modern tools and industry best practices.
                                        </p>
                                        <a class="btn px-3 mt-auto mx-auto" href="{{ route('products') }}">Get Started</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 pt-md-4">
                            <div class="row g-4">
                                <div class="col-12 wow fadeIn" data-wow-delay="0.3s">
                                    <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                                        <div class="service-icon btn-square">
                                            <i class="fa fa-file-alt fa-2x"></i>
                                        </div>
                                        <h5 class="mb-3">Seminar & Project Reports</h5>
                                        <p>
                                            Well-structured seminar papers and academic project reports that meet institutional standards.
                                        </p>
                                        <a class="btn px-3 mt-auto mx-auto" href="{{ route('contact') }}">Get Started</a>
                                    </div>
                                </div>

                                <div class="col-12 wow fadeIn" data-wow-delay="0.5s">
                                    <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                                        <div class="service-icon btn-square">
                                            <i class="fa fa-chalkboard-teacher fa-2x"></i>
                                        </div>
                                        <h5 class="mb-3">Mentorship & Support</h5>
                                        <p>
                                            Continuous guidance and mentorship to support students throughout training and projects.
                                        </p>
                                        <a class="btn px-3 mt-auto mx-auto" href="{{ route('contact') }}">Get Started</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Our Services End -->
    
    <!-- Products Start -->
    <div class="container-fluid py-3">
        <div class="container py-3">
            <div class="news-header-eyebrow wow slideInUp" data-wow-delay="0.1s">
                <span class="font-mono">[04]</span>
                <div class="tech-line w-12"></div>
                <span class="font-mono uppercase">Our Works</span>
            </div>
            <div class="curriculum-header">
                <h3 class="fw-bold">Software We've Built &amp; Sites We've Delivered</h3>
                <a href="{{ route('services') }}" class="view-all-link">
                    View all programs
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="row g-4 wow slideInUp" data-wow-delay="0.1s">
                @forelse($products as $product)
                    <div class="col-sm-6 col-lg-4">
                        <div class="news-card h-100">
                            <div class="news-card-top">
                                <div class="news-card-icon">
                                    <i class="{{ $product->type === 'software' ? 'fas fa-laptop-code' : 'fas fa-globe-america' }}"></i>
                                </div>
                                <span class="news-tag font-mono">
                                    {{ strtoupper($product->type) }}
                                </span>
                            </div>
                            <div class="news-card-body">
                                @if($product->thumbnail)
                                    <img src="{{ asset('uploads/'.$product->thumbnail) }}"
                                        class="img-fluid rounded mb-3" alt="{{ $product->title }}">
                                @endif
                                <h4 class="news-card-title">{{ $product->title }}</h4>
                                <p class="news-card-excerpt">{{ Str::limit($product->description, 110) }}</p>
                            </div>
                            <div class="news-card-footer">
                                @if($product->link)
                                    <a href="{{ $product->link }}" target="_blank" class="news-card-link font-mono">
                                        View Project <i class="fas fa-arrow-right"></i>
                                    </a>
                                @else
                                    <span class="text-muted font-mono small">Private / Internal</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-3">
                        <p class="text-muted mb-0">No products to showcase yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Products End -->

    <!-- Why Choose Us Start -->
    <div class="container-fluid feature py-3">
        <div class="container py-5">
            <div class="row justify-content-center text-center mb-5 wow fadeIn" data-wow-delay="0.1s">
                <div class="col-lg-8">
                    <div class="news-header-eyebrow justify-content-center">
                        <span class="font-mono">[05]</span>
                        <div class="tech-line w-12"></div>
                        <span class="font-mono uppercase">Why Choose Us</span>
                    </div>
                    <h3 class="text-white mb-4">We're Best in Tech Industry with many Years of Experience</h3>
                    <p class="text-light mb-0">At Teqhitch ICT Academy LTD, we distinguish ourselves through deep expertise in emerging technologies,
                        a steadfast dedication to innovation, a strategic global-local outlook, and a results-driven focus on client success — all aimed at helping businesses excel in the digital era.</p>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-sm-6 col-lg-3 wow fadeIn" data-wow-delay="0.1s">
                    <div class="feature-chip">
                        <div class="feature-chip-icon"><i class="fa fa-globe"></i></div>
                        <span class="text-center">Expertise in Diverse Technologies</span>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 wow fadeIn" data-wow-delay="0.1s">
                    <div class="feature-chip">
                        <div class="feature-chip-icon"><i class="fa fa-lightbulb"></i></div>
                        <span>Innovation-Driven Approach</span>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 wow fadeIn" data-wow-delay="0.2s">
                    <div class="feature-chip">
                        <div class="feature-chip-icon"><i class="fa fa-globe-africa"></i></div>
                        <span>Global Reach, Local Expertise</span>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 wow fadeIn" data-wow-delay="0.3s">
                    <div class="feature-chip">
                        <div class="feature-chip-icon"><i class="fa fa-handshake"></i></div>
                        <span>Client-Centric Philosophy</span>
                    </div>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-sm-6 col-lg-4 wow fadeIn" data-wow-delay="0.2s">
                    <div class="feature-stat">
                        <i class="fa fa-users"></i>
                        <div>
                            <h2><span data-toggle="counter-up">500</span>+</h2>
                            <p>Happy Clients</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 wow fadeIn" data-wow-delay="0.2s">
                    <div class="feature-stat">
                        <i class="fa fa-sitemap"></i>
                        <div>
                            <h2><span data-toggle="counter-up">999</span>+</h2>
                            <p>Completed Projects</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5 wow fadeIn" data-wow-delay="0.3s">
                <a class="btn btn-primary rounded-pill px-4" href="{{ route('services') }}">Get Started</a>
            </div>

        </div>
    </div>
    <!-- Why Choose Us End -->

    <!-- Team Start -->
    <div class="container-fluid bg-light py-3">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-5 order-md-2 wow fadeIn" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                    <div class="news-header-eyebrow">
                        <span class="font-mono">[06]</span>
                        <div class="tech-line w-12"></div>
                        <span class="font-mono uppercase">Our Team</span>
                    </div>
                    <h3 class="mb-4">Meet Our Experienced Team Members</h3>
                    <p class="mb-4">
                        Our team consists of skilled ICT professionals, instructors, and project experts with strong industry and academic experience. 
                        They are committed to delivering quality training, executing reliable technology projects, and providing expert guidance to students and organizations.
                    </p>
                </div>
                <div class="col-lg-7 order-md-1">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="row g-4">
                                @forelse($team->take(2) as $index => $member)
                                <div class="col-12 wow fadeIn" data-wow-delay="{{ ($index + 1) * 0.1 }}s">
                                    <div class="team-item bg-white text-center rounded p-4 pt-0">
                                        <img class="img-fluid rounded-circle p-4" 
                                            src="{{ $member->image ? asset('uploads/'.$member->image) : asset('assets/img/user/icon-male.png') }}" 
                                            alt="" width="130px">
                                        <h6 class="mb-0">{{ $member->fullname }}</h6>
                                        <small>{{ $member->position }}</small>

                                        @if($member->bio)
                                            <p class="text-muted small mt-2 mb-0">{{ Str::limit($member->bio, 100) }}</p>
                                        @endif

                                        <div class="d-flex justify-content-center mt-3">
                                            <a class="btn btn-square btn-primary m-1" href="{{ $member->facebook ?? '#' }}"><i class="fab fa-facebook-f"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href="{{ $member->twitter ?? '#' }}"><i class="fab fa-twitter"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href="{{ $member->instagram ?? '#' }}"><i class="fab fa-instagram"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href="{{ $member->linkedin ?? '#' }}"><i class="fab fa-linkedin-in"></i></a>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12 text-center">
                                    <p class="text-muted mb-0">No team members to display at the moment.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="col-md-6 pt-md-4">
                            <div class="row g-4">
                                @foreach($team->skip(2)->take(2) as $index => $member)
                                <div class="col-12 wow fadeIn" data-wow-delay="{{ ($index + 3) * 0.1 }}s">
                                    <div class="team-item bg-white text-center rounded p-4 pt-0">
                                        <img class="img-fluid rounded-circle p-4" 
                                            src="{{ $member->image ? asset('uploads/'.$member->image) : asset('assets/img/user/icon-male.png') }}" 
                                            alt=""  width="130px">
                                        <h6 class="mb-0">{{ $member->fullname }}</h6>
                                        <small>{{ $member->position }}</small>

                                        @if($member->bio)
                                            <p class="text-muted small mt-2 mb-0">{{ Str::limit($member->bio, 100) }}</p>
                                        @endif

                                        <div class="d-flex justify-content-center mt-3">
                                            <a class="btn btn-square btn-primary m-1" href="{{ $member->facebook ?? '#' }}"><i class="fab fa-facebook-f"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href="{{ $member->twitter ?? '#' }}"><i class="fab fa-twitter"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href="{{ $member->instagram ?? '#' }}"><i class="fab fa-instagram"></i></a>
                                            <a class="btn btn-square btn-primary m-1" href="{{ $member->linkedin ?? '#' }}"><i class="fab fa-linkedin-in"></i></a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->
    
    <!-- Gallery Start -->
    <div class="container-fluid feature py-3">
        <div class="container py-5">
            <div class="mx-auto text-center wow slideInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <div class="news-header-eyebrow justify-content-center">
                    <span class="font-mono">[07]</span>
                    <div class="tech-line w-12"></div>
                    <span class="font-mono uppercase">Gallery</span>
                </div>
                <h3 class="text-white mb-4">Moments From Our Trainings &amp; Projects</h3>
            </div>

            <div class="position-relative wow slideInUp" data-wow-delay="0.2s">

                <div class="owl-carousel gallery-carousel">

                    @forelse($gallerys as $item)                        
                        <div class="gallery-slide">
                            <a href="{{ asset('uploads/'.$item->image) }}" target="_blank" class="gallery-item d-block rounded overflow-hidden">
                                <img src="{{ asset('uploads/'.$item->image) }}"
                                    class="img-fluid w-100" style="aspect-ratio: 4/3; object-fit: cover;"
                                    alt="{{ $item->title ?? 'Gallery image' }}">
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted mb-0">No gallery images uploaded yet.</p>
                        </div>
                    @endforelse

                </div>

                <!-- Custom Nav Buttons -->
                <button type="button" class="gallery-nav-btn gallery-prev">
                    <i class="fa fa-chevron-left"></i>
                </button>
                <button type="button" class="gallery-nav-btn gallery-next">
                    <i class="fa fa-chevron-right"></i>
                </button>

            </div>
        </div>
    </div>
    <!-- Gallery End -->

    <!-- Testimonial Start -->
    <div class="container-xxl py-3">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                    <div class="news-header-eyebrow">
                        <span class="font-mono">[08]</span>
                        <div class="tech-line w-12"></div>
                        <span class="font-mono uppercase">Testimonial</span>
                    </div>
                    <h3 class="mb-4">What Say Our Clients!</h3>
                    <p class="mb-4">
                        Our clients and students consistently share positive feedback about our practical training approach, 
                        quality project delivery, and professional academic support. Their satisfaction reflects our commitment 
                        to excellence, innovation, and reliable technology solutions.
                    </p>
                </div>
                <div class="col-lg-7 wow fadeIn" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeIn;">
                    <div class="owl-carousel testimonial-carousel border-start border-global owl-loaded owl-drag">
                        
                        @forelse($testimonies as $testimony)
                        <div class="testimonial-item ps-5">
                            <i class="fa fa-quote-left text-global mb-3"></i>
                            <p>{{ $testimony->message }}</p>
                            <div class="d-flex align-items-center">
                                <img class="img-fluid rounded-circle"
                                    src="{{ $testimony->image ? asset('uploads/' . $testimony->image) : asset('assets/img/user/icon-male.png') }}"
                                    style="width:50px;height:50px;">
                                <div class="ps-3">
                                    <h5 class="mb-1">{{ $testimony->name }}</h5>
                                    <span>{{ $testimony->occupation ?? 'Guest' }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="testimonial-item ps-5 py-0">
                            <p class="text-muted mb-0">No testimonials yet.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    <!-- News Start -->
    <section class="news-section py-3">
        <div class="container py-4">
            <div class="news-header-eyebrow wow slideInUp" data-wow-delay="0.1s">
                <span class="font-mono">[09]</span>
                <div class="tech-line w-12"></div>
                <span class="font-mono uppercase">Latest Updates</span>
            </div>

            <div class="curriculum-header wow slideInUp" data-wow-delay="0.1s">
                <h3 class="fw-bold">Latest News &amp; Insights</h3>
                <a href="{{ route('news') }}" class="view-all-link">
                    View all news
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="row g-4 wow slideInUp" data-wow-delay="0.1s">

                @forelse($news as $item)
                    <div class="col-sm-6 col-lg-4">
                        <a href="{{ route('news.detail', $item->slug) }}" class="news-card">
                            <div class="news-card-top">
                                <div class="news-card-icon">
                                    <i class="{{ $item->icon ?? 'fas fa-newspaper' }}"></i>
                                </div>
                                @isset($item->category)
                                    <span class="news-tag font-mono {{ $item->tag_class }}">{{ Str::upper($item->category) }}</span>
                                @endisset
                            </div>
                            <div class="news-card-body">
                                <h4 class="news-card-title">{{ $item->title }}</h4>
                                <p class="news-card-excerpt">{{ Str::limit($item->excerpt, 110) }}</p>
                            </div>
                            <div class="news-card-footer">
                                <span class="font-mono news-card-date">{{ $item->published_at->format('M d, Y') }}</span>
                                <span class="news-card-link font-mono">
                                    Read more <i class="fas fa-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-3">
                        <p class="text-muted mb-0">No news posted yet.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </section>
    <!-- News End -->
    
    <!-- FAQs Start -->
    <div class="container-fluid">
        <div class="container py-3">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px; visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                <div class="news-header-eyebrow justify-content-center">
                    <span class="font-mono">[10]</span>
                    <div class="tech-line w-12"></div>
                    <span class="font-mono uppercase">Popular FAQs</span>
                </div>
                <h3 class="mb-4">Frequently Asked Questions</h3>
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

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.curriculum-row').forEach(function (row) {
                row.addEventListener('click', function () {
                    const panel = document.getElementById(row.dataset.target);
                    const isOpen = row.classList.contains('is-open');

                    // close any other open row (accordion behavior, remove this loop for multi-open)
                    document.querySelectorAll('.curriculum-row.is-open').forEach(function (openRow) {
                        if (openRow !== row) {
                            openRow.classList.remove('is-open');
                            const openPanel = document.getElementById(openRow.dataset.target);
                            openPanel.style.height = '0px';
                        }
                    });

                    if (isOpen) {
                        row.classList.remove('is-open');
                        panel.style.height = '0px';
                    } else {
                        row.classList.add('is-open');
                        panel.style.height = panel.scrollHeight + 'px';
                    }
                });
            });
            
            var $galleryCarousel = $('.gallery-carousel').owlCarousel({
                loop: true,
                margin: 20,
                nav: false,
                dots: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                responsive: {
                    0: { items: 1 },
                    576: { items: 2 },
                    992: { items: 3 },
                    1200: { items: 4 }
                }
            });

            $('.gallery-prev').on('click', function () {
                $galleryCarousel.trigger('prev.owl.carousel');
            });

            $('.gallery-next').on('click', function () {
                $galleryCarousel.trigger('next.owl.carousel');
            });
        });
    </script>
@endsection