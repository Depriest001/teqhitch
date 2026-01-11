@extends('admindashboardLayout')
@section('title','Payment API Settings | Teqhitch ICT Academy LTD')

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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Payment API Settings</h4>
            <span class="text-muted">Configure and manage payment gateway integration</span>
        </div>
    </div>

    <div class="row g-4">

        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm p-4">

                <h5 class="fw-bold mb-4">Update Payment API Details</h5>

                <form action="{{ route('admin.paymentAPI.update') }}" 
                    method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label">API Name</label>
                        <input type="text" name="name" class="form-control"
                            placeholder="E.g Paystack, Stripe"
                            value="{{ old('name', $paymentApi->name) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">API Key / Secret</label>
                        <input type="text" name="secret_key" class="form-control"
                            placeholder="Enter API key"
                            value="{{ old('secret_key', $paymentApi->secret_key) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Public Key / Token</label>
                        <input type="text" name="public_key" class="form-control"
                            placeholder="Enter public key"
                            value="{{ old('public_key', $paymentApi->public_key) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Webhook / Callback URL</label>
                        <input type="url" name="webhook_secret" class="form-control"
                            placeholder="Enter callback URL"
                            value="{{ old('webhook_secret', $paymentApi->webhook_secret) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Base URL (Optional)</label>
                        <input type="url" name="base_url" class="form-control"
                            placeholder="https://api.flutterwave.co"
                            value="{{ old('base_url', $paymentApi->base_url) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Environment</label>
                        <select name="mode" class="form-select">
                            <option value="test" {{ $paymentApi->mode=='test'?'selected':'' }}>Test</option>
                            <option value="live" {{ $paymentApi->mode=='live'?'selected':'' }}>Live</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ $paymentApi->status=='active'?'selected':'' }}>Active</option>
                            <option value="inactive" {{ $paymentApi->status=='inactive'?'selected':'' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Description (Optional)</label>
                        <textarea name="description" class="form-control" rows="2">
                            {{ old('description', $paymentApi->description) }}
                        </textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="reset" class="btn btn-secondary">
                            <i class="bx bx-reset"></i> Reset
                        </button>

                        <button class="btn btn-primary">
                            <i class="bx bx-save"></i> Update API
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

</div>
@endsection