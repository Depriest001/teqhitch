@extends('admindashboardLayout')
@section('title','View Product | Teqhitch ICT Academy LTD')

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
                @endif
            </div>
        </div>
    @endif

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Product Details</h4>
            <p class="text-muted mb-0">Viewing "{{ $product->title }}"</p>
        </div>
        <div>
            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-primary me-2">
                <i class="icon-base bx bx-edit me-1"></i> Edit
            </a>
            <a href="{{ route('admin.product.index') }}" class="btn btn-label-secondary">
                <i class="icon-base bx bx-arrow-back me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $product->thumbnail ? asset('uploads/'.$product->thumbnail) : asset('assets/img/placeholder.png') }}"
                        class="img-fluid rounded shadow mb-3" style="max-height:220px; object-fit:cover;">
                    <h5 class="mb-1">{{ $product->title }}</h5>
                    <span class="badge {{ $product->type === 'software' ? 'bg-label-info' : 'bg-label-warning' }} text-capitalize mb-2">
                        {{ $product->type }}
                    </span>
                    <div>
                        <span class="badge {{ $product->status ? 'bg-label-success' : 'bg-label-danger' }}">
                            {{ $product->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Description</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $product->description ?: 'No description provided.' }}</p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Additional Info</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th style="width:180px;">Link</th>
                            <td>
                                @if($product->link)
                                    <a href="{{ $product->link }}" target="_blank">{{ $product->link }}</a>
                                @else
                                    <span class="text-muted">Not provided (Private/Internal)</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Date Added</th>
                            <td>{{ $product->created_at->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td>{{ $product->updated_at->format('M d, Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection