@extends('admindashboardLayout')
@section('title','Transactions | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="mb-4">
        <div>
            <h4 class="fw-bold">Payments</h4>
            <span class="text-muted">Manage all student payments and transactions</span>
        </div>
    </div>

    <!-- Payment Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Total Payments</h6>
                <h3>{{ $totalPayments }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Successful</h6>
                <h3 class="text-success">{{ $successful }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Pending</h6>
                <h3 class="text-warning">{{ $pending }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Failed</h6>
                <h3 class="text-danger">{{ $failed }}</h3>
            </div>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Payment Transactions</h5>
        </div>

        <div class="table-responsive">
            <table class="table align-middle" id="exampleTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Payment Method</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $payment->student->name ?? 'N/A' }}</td>

                        <td>{{ $payment->course->title ?? 'N/A' }}</td>

                        <td>{{ $payment->currency ?? '$' }}{{ number_format($payment->amount, 2) }}</td>

                        <td>
                            @if($payment->status == 'success')
                                <span class="badge bg-success">Paid</span>
                            @elseif($payment->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-danger">Failed</span>
                            @endif
                        </td>

                        <td>{{ $payment->meta['payment_type'] ?? 'N/A' }}</td>

                        <td>{{ $payment->paid_at ? $payment->paid_at->format('M d, Y') : '---' }}</td>

                        <td class="text-nowrap">
                            <a href="{{ route('admin.transaction.show', $payment->id) }}" class="btn btn-sm btn-info">
                                <i class="bx bx-show"></i>
                            </a>

                            <form action="{{ route('admin.transaction.destroy', $payment->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete transaction?')" class="btn btn-sm btn-danger">
                                    <i class="bx bx-trash"></i>
                                </button>
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