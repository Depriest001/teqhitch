@extends('admindashboardLayout')
@section('title','Payment Details | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Payment Details</h4>
            <span class="text-muted">View complete payment information</span>
        </div>

        <a href="{{ route('admin.topic-payments.index') }}" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="row g-4">

        {{-- Payment Info --}}
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h6 class="text-muted mb-3">Transaction Information</h6>

                <p><strong>Reference:</strong> {{ $payment->reference }}</p>
                <p><strong>Payment Type:</strong> {{ ucfirst($payment->payment_type) }}</p>
                <p><strong>Amount:</strong> ₦{{ number_format($payment->amount, 2) }}</p>

                <p>
                    <strong>Status:</strong>
                    @if($payment->status == 'success')
                        <span class="badge bg-success">Successful</span>
                    @elseif($payment->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @else
                        <span class="badge bg-danger">Failed</span>
                    @endif
                </p>

                <p><strong>Date:</strong> {{ $payment->created_at->format('M d, Y h:i A') }}</p>
            </div>
        </div>

        {{-- User Info --}}
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h6 class="text-muted mb-3">User Information</h6>

                <p><strong>Name:</strong> {{ $payment->user->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $payment->user->email ?? 'N/A' }}</p>
                <p><strong>User ID:</strong> {{ $payment->user->id ?? '-' }}</p>
            </div>
        </div>

        {{-- Status Update --}}
        <div class="col-12">
            <div class="card shadow-sm p-4">
                <h6 class="text-muted mb-3">Update Payment Status</h6>

                <form action="{{ route('admin.topic-payments.updateStatus', $payment->id) }}" method="POST">
                    @csrf

                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <select name="status" class="form-select" required>
                                <option value="success" {{ $payment->status == 'success' ? 'selected' : '' }}>Successful</option>
                                <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary">
                                <i class="bx bx-refresh"></i> Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection