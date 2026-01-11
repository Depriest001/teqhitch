@extends('admindashboardLayout')
@section('title','Transaction Details | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Transaction Details</h4>
            <span class="text-muted">Detailed overview of this payment record</span>
        </div>

        <a href="{{ route('admin.transaction.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bx bx-arrow-back"></i> Back to Transactions
        </a>
    </div>


    <div class="row g-4">

        <!-- PAYMENT SUMMARY -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">

                    <!-- Transaction ID -->
                    <h6 class="text-muted mb-1">Transaction ID</h6>
                    <h4 class="fw-bold">{{ $transaction->meta['id'] ?? 'N/A' }}</h4>

                    <!-- Reference -->
                    <span class="badge bg-label-primary mb-2">
                        Ref: {{ $transaction->reference ?? 'N/A' }}
                    </span>

                    <h4 class="fw-bold mb-1">
                        {{ $transaction->currency ?? '$' }}{{ number_format($transaction->amount,2) }}
                    </h4>

                    <span class="text-muted">
                        {{ $transaction->paid_at ? $transaction->paid_at->format('M d, Y - h:i A') : 'Not Paid' }}
                    </span>

                    <hr>

                    @if($transaction->status == 'success')
                        <span class="badge bg-success px-3 py-2">Success</span>
                    @elseif($transaction->status == 'pending')
                        <span class="badge bg-warning px-3 py-2">Pending</span>
                    @else
                        <span class="badge bg-danger px-3 py-2">Failed</span>
                    @endif

                    <hr>

                    <div class="d-flex justify-content-center gap-2">

                        <!-- Refund / Fail -->
                        <form action="{{ route('admin.transactions.refund', $transaction->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-outline-danger"
                                {{ $transaction->status == 'failed' ? 'disabled' : '' }}>
                                <i class="bx bx-undo"></i> Refund / Fail
                            </button>
                        </form>

                        <!-- Mark Paid -->
                        <form action="{{ route('admin.transactions.markPaid', $transaction->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-outline-success"
                                {{ $transaction->status == 'success' ? 'disabled' : '' }}>
                                <i class="bx bx-check"></i> Mark as Paid
                            </button>
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <!-- STUDENT INFO -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">

                    <div class="mb-3">
                        <img src="{{ $transaction->student->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($transaction->student->name ?? 'Student') }}"
                             class="rounded-circle" width="90">
                    </div>

                    <h5 class="fw-bold mb-0">{{ $transaction->student->name ?? 'N/A' }}</h5>
                    <span class="text-muted">Student</span>

                    <hr>

                    <p class="mb-1">
                        <i class="bx bx-envelope me-1"></i>
                        {{ $transaction->student->email ?? 'N/A' }}
                    </p>

                    <p class="mb-1">
                        <i class="bx bx-phone me-1"></i>
                        {{ $transaction->student->phone ?? 'N/A' }}
                    </p>

                    <p class="mb-0">
                        <i class="bx bx-calendar me-1"></i>
                        Joined:
                        {{ $transaction->student->created_at ? $transaction->student->created_at->format('M d, Y') : '---' }}
                    </p>

                </div>
            </div>
        </div>


        <!-- COURSE INFO -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">

                    <h5 class="fw-bold mb-1 text-center">
                        {{ $transaction->course->title ?? 'Course Not Found' }}
                    </h5>

                    <p class="text-muted text-center mb-3">
                        Instructor: {{ $transaction->course->instructor->name ?? 'N/A' }}
                    </p>

                    <hr>

                    <p class="mb-2">
                        <i class="bx bx-wallet me-1"></i>
                        Payment Method:
                        <strong>{{ $transaction->meta['payment_type'] ?? 'N/A' }}</strong>
                    </p>

                    <p class="mb-2">
                        <i class="bx bx-time me-1"></i>
                        Transaction Time:
                        <strong>{{ $transaction->paid_at ? $transaction->paid_at->format('h:i A') : '---' }}</strong>
                    </p>

                    <p class="mb-0">
                        <i class="bx bx-calendar me-1"></i>
                        Course Starts:
                        <strong>{{ $transaction->course->start_date ?? '---' }}</strong>
                    </p>

                </div>
            </div>
        </div>

    </div>

</div>
@endsection
