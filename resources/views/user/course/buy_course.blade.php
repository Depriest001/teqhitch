@extends('userdashboardLayout')
@section('title','Course Payment | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    
    @if (session('success') || session('error') || $errors->any())
        <div id="appToast"
            class="bs-toast toast fade show position-fixed bottom-0 end-0 m-3
            {{ session('success') ? 'bg-success' : (session('error') ? 'bg-danger' : 'bg-warning') }}"
            role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header text-white">
                <i class="icon-base bx bx-bell me-2"></i>
                <div class="me-auto fw-medium">
                @if (session('success'))
                    Success
                @elseif (session('error'))
                    Error
                @else
                    Validation
                @endif
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>

            <div class="toast-body text-white">
                @if (session('success'))
                {{ session('success') }}
                @elseif (session('error'))
                {{ session('error') }}
                @elseif ($errors->any())
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    @endif
    <div class="row justify-content-center">

        {{-- LEFT: Course Details --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ asset('storage/'.$course->thumbnail) }}"
                             class="img-fluid rounded-start h-100 object-fit-cover"
                             alt="{{ $course->title }}">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">Course</span>
                            <h4 class="card-title">{{ $course->title }}</h4>

                            <p class="text-muted mb-2">
                                <i class="bx bx-time"></i> Duration: {{ $course->duration }}
                            </p>

                            <p class="card-text">
                                {!! Str::limit(strip_tags($course->description), 300) !!}
                            </p>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Instructor</small>
                                    <p class="mb-0 fw-semibold">
                                        {{ $course->instructor->name ?? 'Teqhitch ICT Academy' }}
                                    </p>
                                </div>

                                <div class="text-end">
                                    <small class="text-muted">Course Price</small>
                                    <h4 class="text-success mb-0">
                                        ₦{{ number_format($course->price, 2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Payment Summary --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="mb-3">Payment Summary</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Course</span>
                        <span>{{ $course->title }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Amount</span>
                        <span>₦{{ number_format($course->price, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Payment Method</span>
                        <span>Flutterwave</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total</strong>
                        <strong class="text-success">
                            ₦{{ number_format($course->price, 2) }}
                        </strong>
                    </div>

                    <button class="btn btn-success w-100 py-2" id="buy-now">
                        <i class="bx bx-credit-card me-2"></i> Pay Now
                    </button>

                    <small class="text-muted d-block mt-3 text-center">
                        Secure payment powered by Flutterwave
                        
                    </small>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="appToast"
     class="toast position-fixed bottom-0 end-0 m-3 bg-danger d-none"
     role="alert"
     aria-live="assertive"
     aria-atomic="true"
     data-bs-delay="4000">

    <div class="toast-header text-white">
        <strong class="me-auto">
            <i class="bx bx-bell me-2"></i>
            <span id="toastTitle">Notification</span>
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
    </div>

    <div class="toast-body text-white" id="toastBody">
        Message here
    </div>
</div>
{{-- Flutterwave --}}
<script src="https://checkout.flutterwave.com/v3.js"></script>
@php
    $coursePrice = (float) $course->price;

    $flutterwaveFee = ($coursePrice * 0.014) + 50;
    $totalAmount = round($coursePrice + $flutterwaveFee, 2);
@endphp

<script>
    let paymentCompleted = false;
    document.getElementById('buy-now').addEventListener('click', function () {
        FlutterwaveCheckout({
            public_key: "{{ config('services.flutterwave.public_key') }}",
            tx_ref: "{{ $tx_ref }}",
            amount: {{ $totalAmount }},
            currency: "NGN",
            payment_options: "card,banktransfer,ussd",

            customer: {
                email: "{{ auth()->user()->email }}",
                name: "{{ auth()->user()->name }}"
            },

            meta: {
                course_id: "{{ $course->id }}",
                student_id: "{{ auth()->id() }}"
            },

            customizations: {
                title: "{{ $course->title }}",
                description: "Course Enrollment Payment",
                logo: "{{ asset('storage/'.$globalSetting->site_logo) }}"
            },

            // callback: function (response) {
            //     paymentCompleted = true;
            //     window.location.href = 
            //         "/user/course/{{ $course->id }}/callback?tx_ref=" + response.tx_ref +
            //         "&transaction_id=" + response.transaction_id;
            // },
            redirect_url: "{{ route('user.course.callback', $course->id) }}",

            onclose: function () {
                // console.log("Payment closed");
                if (!paymentCompleted) {
                    const toastElement = document.getElementById('appToast');
                    const toastTitle = document.getElementById('toastTitle');
                    const toastBody = document.getElementById('toastBody');

                    toastElement.classList.remove('d-none');
                    toastElement.classList.add('d-block');

                    toastTitle.innerText = "Payment Canceled";
                    toastBody.innerText = "You closed the payment without completing it.";

                    const toast = new bootstrap.Toast(toastElement);
                    toast.show();
                };
            }
        });
    });
</script>

@endsection
