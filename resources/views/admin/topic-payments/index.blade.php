@extends('admindashboardLayout')
@section('title','Manage Topic Payments | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Toast Notification --}}
    @if (session('success') || session('error') || $errors->any())
        <div id="appToast"
            class="bs-toast toast fade show position-fixed bottom-0 end-0 m-3
            {{ session('success') ? 'bg-success' : (session('error') ? 'bg-danger' : 'bg-warning') }}"
            role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header text-white">
                <i class="bx bx-bell me-2"></i>
                <div class="me-auto fw-medium">
                    {{ session('success') ? 'Success' : (session('error') ? 'Error' : 'Validation') }}
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
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

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Topic Payments</h4>
            <span class="text-muted">Monitor and manage all topic-related payments</span>
        </div>

        <a href="{{ route('admin.topic-payment-settings.index') }}" class="btn btn-sm btn-outline-primary">
            <i class="bx bx-cog me-2"></i> Payment Settings
        </a>
    </div>

    {{-- Statistics --}}
    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Total Payments</h6>
                <h4>{{ $totalPayments }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Successful</h6>
                <h4 class="text-success">{{ $successfulPayments }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Pending</h6>
                <h4 class="text-warning">{{ $pendingPayments }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Total Revenue</h6>
                <h4 class="text-primary">₦{{ number_format($totalRevenue, 2) }}</h4>
            </div>
        </div>

    </div>

    {{-- Payments Table --}}
    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Payment Records</h5>
        </div>

        <div class="table-responsive">
            <table id="exampleTable" class="table table-sm table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Payment Type</th>
                        <th>Amount</th>
                        <th>Reference</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <div class="fw-medium">
                                    {{ $payment->user->name ?? 'N/A' }}
                                </div>
                                <small class="text-muted">
                                    {{ $payment->user->email ?? '' }}
                                </small>
                            </td>

                            <td>{{ ucfirst($payment->payment_type) }}</td>

                            <td>₦{{ number_format($payment->amount, 2) }}</td>

                            <td>
                                <span class="badge bg-label-secondary">
                                    {{ $payment->reference }}
                                </span>
                            </td>

                            <td>
                                @if($payment->status == 'success')
                                    <span class="badge bg-success">Successful</span>
                                @elseif($payment->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($payment->status == 'failed')
                                    <span class="badge bg-danger">Failed</span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                @endif
                            </td>

                            <td>{{ $payment->created_at->format('M d, Y h:i A') }}</td>
                            <td class="text-nowrap">
                                <form action="{{ route('admin.topic-payment.destroy', $payment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Are you sure you want to delete this Transaction?')" @disabled($payment->status == 'success')><i class="bx bx-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection