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
            <div class="carousel-item active" style="background-image:url('https://persecondnews.com/wp-content/uploads/2021/10/Tech-IT-professionals-in-Nigeria.jpg');">
                <div class="overlay"></div>
                <div class="container h-100 d-flex align-items-center">
                    <div class="hero-content text-center">
                        <p class="fadeInUp" data-wow-delay="0.5s">
                            We provides cutting-edge digital skills, IT training, and professional certifications — shaping the future of Nigeria's tech workforce
                        </p>
                        <h1 class="fadeInUp" style="font-size: 2.5em !important;" data-wow-delay="1.2s">
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
            <div class="carousel-item" style="background-image:url('https://media.istockphoto.com/id/2215674535/photo/young-asian-software-development-manager-leads-a-late-night-office-discussion-with-his.jpg?s=1024x1024&w=is&k=20&c=-TFYnQd_lOxTqguzADyQOOkwBP8sCFusr5njZ79kGds=');">
                <div class="overlay"></div>
                <div class="container h-100 d-flex align-items-center">
                    <div class="hero-content text-center">
                    <p class="fadeInUp" data-wow-delay="0.5s">Learn practical and in-demand digital skills.</p>
                    <h1 class="fadeInUp" style="font-size: 2.5em !important;" data-wow-delay="1.2s">Gain <span>TECH SKILLS</span>That Earn Real Income</h1>
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
                    <h1 class="fadeInUp" style="font-size: 2.5em !important;" data-wow-delay="1.2s">From <span>BEGINNER</span> to Industry Ready</h1>
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
                    <div class="d-flex align-items-center mt-4 wow fadeInUp" data-wow-delay="0.3s">
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
    <!-- Service End -->

    <!-- Our Services Start -->
    <div class="container-fluid bg-light py-3">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 wow slideInLeft" data-wow-delay="0.1s">
                    <div class="news-header-eyebrow">
                        <span class="font-mono">[03]</span>
                        <div class="tech-line w-12"></div>
                        <span class="font-mono uppercase">Our Services</span>
                    </div>
                    <h3 class="mb-4">Professional ICT Training & Technology Solutions</h3>
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
                                <div class="col-12 wow fadeIn" data-wow-delay="0.2s">
                                    <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                                        <div class="service-icon btn-square">
                                            <i class="fa fa-laptop-code fa-2x"></i>
                                        </div>
                                        <h5 class="mb-3">Practical ICT Training</h5>
                                        <p>
                                            Hands-on ICT training designed to equip students with real-world technical and professional skills.
                                        </p>
                                        <a class="btn px-3 mt-auto mx-auto" href="{{ route('contact') }}">Get Started</a>
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
                                        <a class="btn px-3 mt-auto mx-auto" href="{{ route('contact') }}">Get Started</a>
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

    <!-- Why Choose Us Start -->
    <div class="container-fluid feature py-3">
        <div class="container py-5">
            <div class="row justify-content-center text-center mb-5 wow fadeIn" data-wow-delay="0.1s">
                <div class="col-lg-8">
                    <div class="news-header-eyebrow justify-content-center">
                        <span class="font-mono">[04]</span>
                        <div class="tech-line w-12"></div>
                        <span class="font-mono uppercase">Why Choose Us</span>
                    </div>
                    <h3 class="text-white mb-4">We're Best in Tech Industry with many Years of Experience</h3>
                    <p class="text-light mb-0">At Teqhitch ICT Academy LTD, we distinguish ourselves through deep expertise in emerging technologies,
                        a steadfast dedication to innovation, a strategic global-local outlook, and a results-driven focus on client success — all aimed at helping businesses excel in the digital era.</p>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-sm-6 col-lg-3 wow fadeIn" data-wow-delay="0.2s">
                    <div class="feature-chip">
                        <div class="feature-chip-icon"><i class="fa fa-globe"></i></div>
                        <span class="text-center">Expertise in Diverse Technologies</span>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 wow fadeIn" data-wow-delay="0.3s">
                    <div class="feature-chip">
                        <div class="feature-chip-icon"><i class="fa fa-lightbulb"></i></div>
                        <span>Innovation-Driven Approach</span>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 wow fadeIn" data-wow-delay="0.4s">
                    <div class="feature-chip">
                        <div class="feature-chip-icon"><i class="fa fa-globe-africa"></i></div>
                        <span>Global Reach, Local Expertise</span>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3 wow fadeIn" data-wow-delay="0.5s">
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
                <div class="col-sm-6 col-lg-4 wow fadeIn" data-wow-delay="0.3s">
                    <div class="feature-stat">
                        <i class="fa fa-sitemap"></i>
                        <div>
                            <h2><span data-toggle="counter-up">999</span>+</h2>
                            <p>Completed Projects</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5 wow fadeIn" data-wow-delay="0.4s">
                <a class="btn btn-primary rounded-pill px-4" href="{{ route('services') }}">Get Started</a>
            </div>

        </div>
    </div>
    <!-- Why Choose Us End -->

    <!-- Team Start -->
    <div class="container-fluid bg-light py-3">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 order-md-2 wow fadeIn" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                    <div class="news-header-eyebrow">
                        <span class="font-mono">[05]</span>
                        <div class="tech-line w-12"></div>
                        <span class="font-mono uppercase">Our Team</span>
                    </div>
                    <h3 class="mb-4">Meet Our Experienced Team Members</h3>
                    <p class="mb-4">
                        Our team consists of skilled ICT professionals, instructors, and project experts with strong industry and academic experience. 
                        They are committed to delivering quality training, executing reliable technology projects, and providing expert guidance to students and organizations.
                    </p>
                    <a class="btn btn-primary rounded-pill px-4" href="{{ route('about') }}">Read more</a>
                </div>
                <div class="col-lg-7 order-md-1">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="row g-4">
                                @foreach($team->take(2) as $index => $member)
                                <div class="col-12 wow fadeIn" data-wow-delay="{{ ($index + 1) * 0.1 }}s">
                                    <div class="team-item bg-white text-center rounded p-4 pt-0">
                                        <img class="img-fluid rounded-circle p-4" 
                                            src="{{ $member->image ? asset('uploads/'.$member->image) : asset('assets/img/user/icon-male.png') }}" 
                                            alt="">
                                        <h5 class="mb-0">{{ $member->fullname }}</h5>
                                        <small>{{ $member->position }}</small>

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

                        <div class="col-md-6 pt-md-4">
                            <div class="row g-4">
                                @foreach($team->skip(2)->take(2) as $index => $member)
                                <div class="col-12 wow fadeIn" data-wow-delay="{{ ($index + 3) * 0.1 }}s">
                                    <div class="team-item bg-white text-center rounded p-4 pt-0">
                                        <img class="img-fluid rounded-circle p-4" 
                                            src="{{ $member->image ? asset('uploads/'.$member->image) : asset('assets/img/user/icon-male.png') }}" 
                                            alt="">
                                        <h5 class="mb-0">{{ $member->fullname }}</h5>
                                        <small>{{ $member->position }}</small>

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

    <!-- Testimonial Start -->
    <div class="container-xxl py-3">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                    <div class="news-header-eyebrow">
                        <span class="font-mono">[06]</span>
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
                        
                        @foreach($testimonies as $testimony)
                        <div class="testimonial-item ps-5">
                            <i class="fa fa-quote-left text-global mb-3"></i>
                            <p>{{ $testimony->message }}</p>
                            <div class="d-flex align-items-center">
                                <img class="img-fluid rounded-circle"
                                    src="{{ $testimony->image ? asset('uploads/' . $testimony->image) : 'https://dummyimage.com/90x90/f0f0f0/000&text=User' }}"
                                    style="width:50px;height:50px;">
                                <div class="ps-3">
                                    <h5 class="mb-1">{{ $testimony->name }}</h5>
                                    <span>{{ $testimony->occupation ?? 'Guest' }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    <!-- News Start -->
    <section class="news-section py-3">
        <div class="container py-4">
            <div class="news-header-eyebrow wow fadeIn" data-wow-delay="0.1s">
                <span class="font-mono">[07]</span>
                <div class="tech-line w-12"></div>
                <span class="font-mono uppercase">Latest Updates</span>
            </div>

            <div class="curriculum-header wow fadeIn" data-wow-delay="0.1s">
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
                    <div class="col-12 text-center py-5">
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
                    <span class="font-mono">[08]</span>
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
        });
    </script>
@endsection