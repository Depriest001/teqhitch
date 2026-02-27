@extends('userdashboardLayout')
@section('title', 'Unlock More Topic Generations')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow-sm border-0">
                <div class="card-body p-5 text-center p-5">

                    <div class="mb-3">
                        <i class="bx bx-credit-card text-primary display-4"></i>
                    </div>

                    <h4 class="fw-bold mb-2">
                        {{ $paymentSetting->name }}
                    </h4>

                    <p class="text-muted mb-4">
                        Secure payment to activate this service.
                    </p>

                    <div class="bg-light rounded p-4 mb-4">
                        <h2 class="fw-bold text-dark mb-0">
                            ₦{{ number_format($paymentSetting->amount, 2) }}
                            <input type="hidden" id="user_topic_id" value="{{ $userTopicId }}">
                        </h2>
                        <small class="text-muted">
                            One-time payment
                        </small>
                    </div>

                    <button id="payNow"
                            class="btn btn-primary btn-lg w-100">
                        <i class="bx bx-lock me-1"></i>
                        Pay Securely
                    </button>

                    <div class="mt-3">
                        <a href="{{ url()->previous() }}"
                           class="text-muted small">
                            ← Back
                        </a>
                    </div>

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

<script>
    let paymentCompleted = false;
    document.getElementById('payNow').addEventListener('click', function () {

        fetch("{{ route('user.payment.initialize', $paymentSetting->slug) }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                user_topic_id: document.getElementById('user_topic_id')?.value || null
            })
        })
        .then(response => response.json())
        .then(data => {
            
            FlutterwaveCheckout({
                public_key: "{{ config('services.flutterwave.public_key') }}",
                tx_ref: data.tx_ref,
                amount: data.amount,
                currency: "NGN",
                payment_options: "card,banktransfer,ussd",

                customer: {
                    email: "{{ auth()->user()->email }}",
                    name: "{{ auth()->user()->name }}",
                    paymentTitle: "{{ $paymentSetting->slug }}",
                },

                customizations: {
                    title: "{{ $paymentSetting->name }}",
                    description: "Payment for {{ $paymentSetting->name }}",
                    logo: "{{ asset('storage/'.$globalSetting->site_logo) }}"
                },

                callback: function (response) {
                    paymentCompleted = true;
                    window.location.href = "{{ route('user.payment.processing') }}";
                },

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

    });
</script>
@endsection