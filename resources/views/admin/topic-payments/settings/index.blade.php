@extends('admindashboardLayout')
@section('title','Payment Settings | Teqhitch ICT Academy LTD')

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
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="fw-bold">Payment Settings</h4>
            <span class="text-muted">Manage topic payment configuration</span>
        </div>

        <div class="d-flex flex-column flex-md-row gap-2">
            <a href="{{ route('admin.topic-payments.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bx bx-arrow-back"></i> Back to Payments
            </a>

            <button class="btn btn-sm btn-primary" data-bs-toggle="offcanvas" data-bs-target="#addPaymentCanvas">
                <i class="bx bx-plus"></i> Add Payment Type
            </button>
        </div>
    </div>

    {{-- Settings Table --}}
    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Available Payment Types</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Amount (₦)</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($settings as $setting)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $setting->name }}</td>
                            <td><span class="badge bg-label-secondary">{{ $setting->slug }}</span></td>
                            <td>₦{{ number_format($setting->amount, 2) }}</td>
                            <td>
                                @if($setting->active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="d-flex gap-2">

                                {{-- Edit Button triggers Bootstrap Modal --}}
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPaymentModal{{ $setting->id }}">
                                    <i class="bx bx-edit"></i>
                                </button>

                                {{-- Delete Button --}}
                                <form action="{{ route('admin.topic-payment-settings.destroy', $setting) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this payment type?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>

                                {{-- Bootstrap Modal for Editing --}}
                                <div class="modal fade" id="editPaymentModal{{ $setting->id }}" tabindex="-1" aria-labelledby="editPaymentLabel{{ $setting->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.topic-payment-settings.update', $setting) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editPaymentLabel{{ $setting->id }}">Edit Payment Type</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Name</label>
                                                        <input type="text" class="form-control" name="name" value="{{ old('name', $setting->name) }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Amount (₦)</label>
                                                        <input type="number" class="form-control" name="amount" value="{{ old('amount', $setting->amount) }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select class="form-select" name="active" required>
                                                            <option value="1" {{ $setting->active ? 'selected' : '' }}>Active</option>
                                                            <option value="0" {{ !$setting->active ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No payment settings found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
{{-- Offcanvas Add Payment --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="addPaymentCanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Create Payment Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form action="{{ route('admin.topic-payment-settings.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Payment Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g Topic Approval Fee" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Amount (₦)</label>
                <input type="number" name="amount" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">
                <i class="bx bx-save"></i> Save Payment Type
            </button>
        </form>
    </div>
</div>
@endsection