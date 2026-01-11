@extends('frontLayout')
@section('title','Contact - Teqhitch ICT Academy LTD')
@section('content')
    
    <!-- Hero Start -->
    <div class="container-fluid pt-5 hero-header">
        <div class="container pt-5">
            <div class="row g-5 pt-5">
                <div class="col-lg-6 align-self-center text-center text-lg-start mb-lg-5">
                    <h1 class="display-4 text-white mb-4 animated slideInRight">Contact Us</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center justify-content-lg-start mb-0">
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
                        <i class="bi bi-geo-alt flex-shrink-0 h4"></i>
                        <div>
                            <h4>Address</h4>
                            <p>Equity Lodge Ishieke Market, Ebonyi state, Nigeria.</p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="info-item d-flex">
                        <i class="bi bi-telephone flex-shrink-0 h4"></i>
                        <div>
                            <h4>Call Us</h4>
                            <p><a href="tel:+234 816 658 2751">+234 816 658 2751</a></p>
                        </div>
                    </div><!-- End Info Item -->

                    <div class="info-item d-flex">
                        <i class="bi bi-envelope flex-shrink-0 h4 me-1"></i>
                        <div>
                            <h4>Email Us</h4>
                            <p><a href="mailto:support@teqhitch.com">support@teqhitch.com</a></p>
                        </div>
                    </div><!-- End Info Item -->
                </div>
                <div class="col-lg-7">
                    <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px; visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                        <div class="btn btn-sm border rounded-pill text-primary px-3 mb-3">Contact Us</div>
                    </div>
                    <div class="wow fadeIn" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeIn;">
                        <form id="" action="" method="post">
                            <div class="row">
                                <div class="col-sm-6 mb-2 control-group">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" placeholder="Your Name" required="required">
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-2 control-group">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="Your Email" required="required">
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="col-12 mb-2 control-group">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subject" placeholder="Subject" required="required">
                                        <label for="subject">Subject</label>
                                    </div>
                                </div>
                                <div class="col-12 mb-2 control-group">
                                    <div class="form-floating">
                                        <textarea style="height: 200px" class="form-control" id="message" placeholder="Message" required="required"></textarea>
                                        <label for="message">Leave a message here</label>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <button class="btn btn-sm btn-primary py-3 w-100" type="submit" id="sendMessageButton">
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
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12721.2345!2d8.027427!3d6.385025!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1040f8d27d1a4537%3A0x0!2sIzzi%20High%20School%2C%20Ishieke!5e0!3m2!1sen!2sng!4v1697800000000!5m2!1sen!2sng"
            frameborder="0"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
    </div>
    <!-- End Google Maps -->
    
@endsection