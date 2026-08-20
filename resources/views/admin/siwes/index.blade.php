@extends('admindashboardLayout')
@section('title','Manage SIWES Applications')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success') || session('error') || $errors->any())
        <div id="appToast"
            class="bs-toast toast fade show position-fixed top-0 end-0 m-3
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

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h4 class="mb-0">SIWES / IT Placement Applications</h4>
            <p class="text-muted mb-0">{{ $applications->total() }} total application{{ $applications->total() === 1 ? '' : 's' }}</p>
        </div>
        <a href="{{ route('admin.siwes.tracks.index') }}" class="btn btn-outline-primary">
            <i class="icon-base bx bx-money me-1"></i> Set Tracks &amp; Prices
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.siwes.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" class="form-control" placeholder="Name, reference, email, institution">
                </div>
                <div class="col-md-3 col-6">
                    <label class="form-label">Payment Status</label>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        <option value="pending" @selected(($filters['status'] ?? '') === 'pending')>Pending</option>
                        <option value="paid" @selected(($filters['status'] ?? '') === 'paid')>Paid</option>
                        <option value="failed" @selected(($filters['status'] ?? '') === 'failed')>Failed</option>
                    </select>
                </div>
                <div class="col-md-3 col-6">
                    <label class="form-label">Track</label>
                    <select name="track" class="form-select">
                        <option value="">All</option>
                        @foreach($tracks as $key => $label)
                            <option value="{{ $key }}" @selected(($filters['track'] ?? '') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100"><i class="icon-base bx bx-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Applicant</th>
                        <th>Institution</th>
                        <th>Track</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Applied</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($applications as $application)
                        <tr>
                            <td><span class="font-monospace small">{{ $application->reference }}</span></td>
                            <td>
                                <div class="fw-medium">{{ $application->full_name }}</div>
                                <div class="text-muted small">{{ $application->email }}</div>
                            </td>
                            <td>{{ $application->institution }}</td>
                            <td>{{ $application->trackLabel() }}</td>
                            <td>₦{{ number_format($application->amount, 2) }}</td>
                            <td>
                                @php
                                    $badge = match($application->payment_status) {
                                        'paid' => 'bg-success',
                                        'failed' => 'bg-danger',
                                        default => 'bg-warning',
                                    };
                                @endphp
                                <span class="badge {{ $badge }}">{{ ucfirst($application->payment_status) }}</span>
                            </td>
                            <td>{{ $application->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.siwes.show', $application->reference) }}" class="btn btn-sm btn-icon">
                                    <i class="icon-base bx bx-show"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">No applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($applications->hasPages())
            <div class="card-footer">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection