@extends('admindashboardLayout')

@section('title', 'View Testimony | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Testimony Details</h4>
            <span class="text-muted">Full information about the selected testimony</span>
        </div>

        <a href="{{ route('admin.testimonies.index') }}" class="btn btn-sm btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <!-- Content Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="row align-items-center">

                <!-- Image -->
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    <img src="https://via.placeholder.com/150"
                         class="rounded-circle shadow-sm"
                         width="120" height="120" style="object-fit: cover;">
                </div>

                <!-- Details -->
                <div class="col-md-9">

                    <h4 class="fw-bold mb-2">John Doe</h4>

                    <p class="text-muted mb-3">
                        <i class="bx bx-quote-alt-left"></i>
                        Teqhitch ICT Academy transformed my tech skills. The teaching was clear and practical, and I gained real confidence in building projects.
                    </p>

                    <hr>

                    <div class="row">

                        <div class="col-md-6 mb-2">
                            <strong>Status:</strong>
                            <span class="badge bg-success">Active</span>
                        </div>

                        <div class="col-md-6 mb-2">
                            <strong>Date Added:</strong>
                            <span class="text-muted">12 March 2026</span>
                        </div>

                        <div class="col-md-6 mb-2">
                            <strong>Occuption:</strong>
                            <span class="text-muted">Web Developer</span>
                        </div>

                    </div>

                    <hr>

                    <!-- Actions -->
                    <div class="mt-3">
                        <a href="#" class="btn btn-warning btn-sm me-2">
                            <i class="bx bx-edit"></i> Edit
                        </a>

                        <button class="btn btn-danger btn-sm">
                            <i class="bx bx-trash"></i> Delete
                        </button>
                    </div>

                </div>

            </div>

        </div>
    </div>

</div>
@endsection