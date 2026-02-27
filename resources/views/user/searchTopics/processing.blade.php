@extends('userdashboardLayout')
@section('title', 'Verifying Payment')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow-sm border-0">
                <div class="card-body text-center p-5">

                    {{-- Spinner Icon --}}
                    <div class="mb-4">
                        <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status"></div>
                    </div>

                    <h4 class="fw-bold mb-3">Verifying Your Payment...</h4>

                    <p class="text-muted mb-4">
                        Please wait while we confirm your transaction.
                        This usually takes just a few seconds.
                    </p>

                    <div class="alert alert-info small">
                        ⚡ Do not close this page.
                    </div>

                    <div id="statusMessage" class="mt-3 small text-muted"></div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
let attempts = 0;

function checkPaymentStatus() {
    fetch("{{ route('user.payment.check') }}")
        .then(response => response.json())
        .then(data => {

            if (data.status === 'success') {

                document.getElementById('statusMessage').innerHTML =
                    "<span class='text-success'>Payment confirmed! Redirecting...</span>";

                setTimeout(() => {
                    window.location.href = "{{ route('user.searchTopics.index') }}";
                }, 2500);

            } else if (data.status === 'failed') {

                document.getElementById('statusMessage').innerHTML =
                    "<span class='text-danger'>Payment failed. Redirecting...</span>";

                setTimeout(() => {
                    window.location.href = "{{ route('user.searchTopics.index') }}";
                }, 2500);

            } else {

                attempts++;

                if (attempts > 10) {
                    document.getElementById('statusMessage').innerHTML =
                        "<span class='text-warning'>Still verifying... please wait.</span>";
                }

                setTimeout(checkPaymentStatus, 3000);
            }

        })
        .catch(() => {
            setTimeout(checkPaymentStatus, 3000);
        });
}

// Start checking after 3 seconds
setTimeout(checkPaymentStatus, 3000);
</script>

@endsection