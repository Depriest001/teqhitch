<!-- Newsletter Start -->
    <div class="container-fluid newsletter py-3" id="newsletter">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-md-5 ps-lg-0 pt-5 pt-md-0 text-start d-md-block d-none wow fadeIn" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeIn;">
                    <img class="img-fluid" src="{{ asset('assets/img/newsletter.png')}}" alt="">
                </div>
                <div class="col-md-7 py-5 newsletter-text wow fadeIn" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeIn;">
                    <div class="btn btn-sm border rounded-pill text-white px-3 mb-3">Newsletter</div>
                    <h3 class="text-white mb-4">Let's subscribe the newsletter</h3>
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success p-2">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="alert alert-danger p-2">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('subscriber.store') }}" method="post" class="position-relative w-100 mt-3 mb-2">
                        @csrf
                        <input name="email" class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="email" placeholder="Enter Your Email" style="height: 48px;" autocomplete required>
                        <button type="submit" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i class="fa fa-paper-plane text-global fs-4"></i></button>
                    </form>
                    <small class="text-white"> Get updates on our training programs, projects, and tech insights.</small>
                </div>
            </div>
        </div>
    </div>
    <!-- Newsletter End -->

    <!-- Footer Start -->
    <div class="container-fluid text-white-50 footer pt-5">
        <div class="container py-3">
            <div class="row g-5">
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.1s">
                    <a href="{{route('home')}}" class="d-inline-block mb-3">
                        <h3 class="text-white">Teq<span class="text-global">h</span>itch</h3>
                    </a>
                    <p class="mb-0 small">{{ $globalSetting->site_name }} is committed to delivering top-tier digital training, helping individuals and businesses thrive through hands-on learning, expert guidance, and real-world tech solutions.</p>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.3s">
                    <h5 class="text-white mb-4">Get In Touch</h5>
                    <p class="small"><i class="fa fa-map-marker-alt me-3"></i>
                        {{ $globalSetting->address }}
                    </p>
                    
                    <p class="small"><i class="fa fa-phone-alt me-3"></i>{{ $globalSetting->support_phone }}</p>
                    <p class="small"><i class="fa fa-envelope me-3"></i>{{ $globalSetting->support_email }}</p>

                    @php
                        $social = $globalSetting->social_links ?? [];
                    @endphp
                    <div class="d-flex flex-wrap pt-2">
                        @if(!empty($social['twitter']))
                            <a class="btn btn-outline-light btn-social" href="{{ $social['twitter'] }}" target="_blank" rel="noopener">
                                <i class="fab fa-twitter"></i>
                            </a>
                        @endif

                        @if(!empty($social['facebook']))
                            <a class="btn btn-outline-light btn-social" href="{{ $social['facebook'] }}" target="_blank" rel="noopener">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif

                        @if(!empty($social['youtube']))
                            <a class="btn btn-outline-light btn-social" href="{{ $social['youtube'] }}" target="_blank" rel="noopener">
                                <i class="fab fa-youtube"></i>
                            </a>
                        @endif

                        @if(!empty($social['instagram']))
                            <a class="btn btn-outline-light btn-social" href="{{ $social['instagram'] }}" target="_blank" rel="noopener">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif

                        @if(!empty($social['linkedin']))
                            <a class="btn btn-outline-light btn-social" href="{{ $social['linkedin'] }}" target="_blank" rel="noopener">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        @endif

                        @if(!empty($social['tiktok']))
                            <a class="btn btn-outline-light btn-social d-inline-flex align-items-center justify-content-center" href="{{ $social['tiktok'] }}" target="_blank" rel="noopener">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 448 512">
                                    <path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a72.59,72.59,0,1,0,50.23,69.63V0h90.08a101.58,101.58,0,0,0,10.6,43.43,103.54,103.54,0,0,0,76.54,58.46V209.91Z"/>
                                </svg>
                            </a>
                        @endif

                        @if(!empty($social['whatsapp']))
                            <a class="btn btn-outline-light btn-social" href="{{ $social['whatsapp'] }}" target="_blank" rel="noopener">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.5s">
                    <h5 class="text-white mb-4">Popular Link</h5>
                    <a class="btn btn-link small" href="{{route('about')}}">About Us</a>
                    <a class="btn btn-link small" href="{{route('contact')}}">Contact Us</a>
                    <a class="btn btn-link small" href="{{route('services')}}">Courses</a>
                    <a class="btn btn-link small" href="{{route('news')}}">News</a>
                    <a class="btn btn-link small" href="{{route('products')}}">Products</a>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.7s">
                    <h5 class="text-white mb-4">Our Programs</h5>
                    @forelse($globalcourses as $course)
                        <a class="btn btn-link small" href="{{route('services')}}">{{ $course->title ?? ''}}</a>
                    @empty
                        <a class="btn btn-link small" href="{{route('services')}}">No programs yet</a>
                    @endforelse
                    
                </div>
            </div>
        </div>
        <div class="container wow fadeIn" data-wow-delay="0.1s">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; Teqhitch, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="{{route('home')}}">Home</a>
                            <a href="{{route('contact')}}">Contact</a>
                            <a href="{{route('about')}}">About</a>
                            <a href="{{route('services')}}">Programs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->