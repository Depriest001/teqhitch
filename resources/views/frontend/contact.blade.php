@extends('frontLayout')
@section('title','Contact - Teqhitch ICT Academy LTD')
@section('content')
    
    <!-- Hero Start -->
    <div class="container-fluid pt-5 hero-header">
        <div class="container pt-5">
            <div class="row g-5 pt-5">
                <div class="col-lg-6 align-self-center text-center text-lg-start mb-lg-5">
                    <h2 class="text-white mb-4 animated slideInUp">Contact Us</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center justify-content-lg-start mb-0 animated slideInUp">
                            <li class="breadcrumb-item"><a class="text-white" href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Contact Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Contact Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s">
                    <div class="info-item d-flex">
                        <i class="bi bi-geo-alt flex-shrink-0 h6"></i>
                        <div>
                            <h6>Address</h6>
                            <p>{{ $systemInfo->address ?? 'Equity Lodge Ishieke Market, Ebonyi state, Nigeria.' }}</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="info-item d-flex">
                        <i class="bi bi-telephone flex-shrink-0 h6"></i>
                        <div>
                            <h6>Call Us</h6>
                            <p><a href="tel:{{ $systemInfo->support_phone ?? '+2348166582751' }}">{{ $systemInfo->support_phone ?? '+234 816 658 2751' }}</a></p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="info-item d-flex">
                        <i class="bi bi-envelope flex-shrink-0 h6 me-1"></i>
                        <div>
                            <h6>Email Us</h6>
                            <p><a href="mailto:{{ $systemInfo->support_email ?? 'support@teqhitch.com' }}">{{ $systemInfo->support_email ?? 'support@teqhitch.com' }}</a></p>
                        </div>
                    </div><!-- End Info Item -->

                    @php
                        $social = $systemInfo->social_links ?? [];
                    @endphp
                    @if(array_filter($social))
                        <div class="d-flex">
                            <span class="info-item">
                                <i class="bi bi-share flex-shrink-0 h6"></i>
                            </span>
                            <div class="w-100 mb-4">
                                <h6>Follow Us</h6>
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    @if(!empty($social['facebook']))
                                        <a class="btn btn-outline-primary btn-square" href="{{ $social['facebook'] }}" target="_blank" rel="noopener">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    @endif

                                    @if(!empty($social['twitter']))
                                        <a class="btn btn-outline-primary btn-square" href="{{ $social['twitter'] }}" target="_blank" rel="noopener">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    @endif

                                    @if(!empty($social['instagram']))
                                        <a class="btn btn-outline-primary btn-square" href="{{ $social['instagram'] }}" target="_blank" rel="noopener">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    @endif

                                    @if(!empty($social['linkedin']))
                                        <a class="btn btn-outline-primary btn-square" href="{{ $social['linkedin'] }}" target="_blank" rel="noopener">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    @endif

                                    @if(!empty($social['youtube']))
                                        <a class="btn btn-outline-primary btn-square" href="{{ $social['youtube'] }}" target="_blank" rel="noopener">
                                            <i class="fab fa-youtube"></i>
                                        </a>
                                    @endif

                                    @if(!empty($social['tiktok']))
                                        <a class="btn btn-outline-primary btn-square d-inline-flex align-items-center justify-content-center" href="{{ $social['tiktok'] }}" target="_blank" rel="noopener">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 448 512" style="margin-bottom: 2px;">
                                                <path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a72.59,72.59,0,1,0,50.23,69.63V0h90.08a101.58,101.58,0,0,0,10.6,43.43,103.54,103.54,0,0,0,76.54,58.46V209.91Z"/>
                                            </svg>
                                        </a>
                                    @endif

                                    @if(!empty($social['whatsapp']))
                                        <a class="btn btn-outline-primary btn-square" href="{{ $social['whatsapp'] }}" target="_blank" rel="noopener">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div><!-- End Info Item -->
                    @endif
                </div>
                <div class="col-lg-7">
                    <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px; visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                        <div class="btn btn-sm border rounded-pill text-primary px-3 mb-3">Contact Us</div>
                    </div>
                    <div class="wow fadeIn" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeIn;">
                        <form id="" action="" method="post">
                            <div class="row">
                                <div class="col-sm-6 mb-3 control-group">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" placeholder="Your Name" required="required">
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 control-group">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="Your Email" required="required">
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="col-12 mb-3 control-group">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subject" placeholder="Subject" required="required">
                                        <label for="subject">Subject</label>
                                    </div>
                                </div>
                                <div class="col-12 mb-3 control-group">
                                    <div class="form-floating">
                                        <textarea style="height: 200px" class="form-control" id="message" placeholder="Message" required="required"></textarea>
                                        <label for="message">Leave a message here</label>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <button class="btn btn-sm btn-primary py-2 w-100" type="submit" id="sendMessageButton">
                                        <span>Send Message</span>
                                        <div class="d-none spinner-border spinner-border-sm text-light ms-3" role="status"></div>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <!-- Google Maps -->
    <div class="container-fluid pb-5">
        <div class="container wow fadeIn" data-wow-delay="0.2s">
            <iframe
                style="border:0; width:100%; height:270px;"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.1114940237567!2d8.0394747!3d6.3796069!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x105b5952d7c0b553%3A0x4d3e9f04d7165fcc!2sTeqhitch%20ICT%20Academy%20Limited!5e0!3m2!1sen!2sng!4v1775660607039!5m2!1sen!2sng"
                frameborder="0"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
    <!-- End Google Maps -->
    
@endsection