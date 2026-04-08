@extends('admindashboardLayout')

@section('title', 'Teams | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Teams</h4>
            <span class="text-muted">Manage your team members</span>
        </div>

        <!-- Trigger Offcanvas -->
        <button class="btn btn-sm btn-primary" data-bs-toggle="offcanvas" data-bs-target="#createTeam">
            <i class="bx bx-plus"></i> New Team Member
        </button>
    </div>

    <!-- TEAM CARDS -->
    <div class="row g-3">

        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">

                <div class="card-body text-center">

                    <img src="https://via.placeholder.com/100"
                         class="rounded-circle mb-3"
                         width="80" height="80">

                    <h5 class="mb-1">John Doe</h5>
                    <small class="text-muted">Frontend Developer</small>

                    <div class="mt-2">
                        <span class="badge bg-danger">Deactivated</span>
                    </div>

                </div>

                <!-- SOCIAL MEDIA ICONS -->
                <div class="d-flex justify-content-center gap-3 mb-3">

                    <a href="#" class="text-primary fs-4">
                        <i class="bx bxl-facebook-circle"></i>
                    </a>

                    <a href="#" class="text-info fs-4">
                        <i class="bx bxl-twitter"></i>
                    </a>

                    <a href="#" class="text-danger fs-4">
                        <i class="bx bxl-instagram"></i>
                    </a>

                    <a href="#" class="text-primary fs-4">
                        <i class="bx bxl-linkedin-square"></i>
                    </a>

                </div>

                <div class="card-footer bg-white border-0 d-flex justify-content-center gap-2">

                   <a href="{{ route('admin.teams.show1') }}" class="btn btn-sm btn-info me-1">
                        <i class="bx bx-show"></i> View
                    </a>

                    <button class="btn btn-sm btn-success">
                        activate
                    </button>

                    <button class="btn btn-sm btn-danger">
                        <i class="bx bx-trash me-1"></i> Delete
                    </button>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">

                <div class="card-body text-center">

                    <img src="https://via.placeholder.com/100"
                         class="rounded-circle mb-3"
                         width="80" height="80">

                    <h5 class="mb-1">Mary Johnson</h5>
                    <small class="text-muted">Backend Developer</small>

                    <div class="mt-2">
                        <span class="badge bg-danger">Deactivated</span>
                    </div>

                </div>

                <div class="card-footer bg-white border-0 d-flex justify-content-center gap-2">

                    <a href="{{ route('admin.teams.show1') }}" class="btn btn-sm btn-info me-1">
                        <i class="bx bx-show"></i> View
                    </a>

                    <button class="btn btn-sm btn-success">
                        activate
                    </button>

                    <button class="btn btn-sm btn-danger">
                        <i class="bx bx-trash me-1"></i> Delete
                    </button>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">

                <div class="card-body text-center">

                    <img src="https://via.placeholder.com/100"
                         class="rounded-circle mb-3"
                         width="80" height="80">

                    <h5 class="mb-1">Samuel Lee</h5>
                    <small class="text-muted">UI/UX Designer</small>

                    <div class="mt-2">
                        <span class="badge bg-danger">Deactivated</span>
                    </div>

                </div>

                <div class="card-footer bg-white border-0 d-flex justify-content-center gap-2">

                    <a href="{{ route('admin.teams.show1') }}" class="btn btn-sm btn-info me-1">
                        <i class="bx bx-show"></i> View
                    </a>

                    <button class="btn btn-sm btn-success">
                        activate
                    </button>

                    <button class="btn btn-sm btn-danger">
                        <i class="bx bx-trash me-1"></i> Delete
                    </button>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- ================= OFFCANVAS (CREATE TEAM) ================= -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="createTeam">

    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Add New Team Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <form>

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" placeholder="Enter full name">
            </div>

            <!-- Position -->
            <div class="mb-3">
                <label class="form-label">Position</label>
                <input type="text" class="form-control" placeholder="e.g Frontend Developer">
            </div>


            <!-- IMAGE UPLOAD -->
            <div class="mb-3">
                <label class="form-label">Change Image</label>
                <input type="file" class="form-control">
            </div>

            <!-- IMAGE PREVIEW -->
            <div class="text-center mb-3">
                <img src="https://via.placeholder.com/120"
                     class="rounded-circle shadow"
                     width="90" height="90">
                <p class="text-muted mt-2 mb-0">Image Preview</p>
            </div>

            <!-- Facebook -->
            <div class="mb-3">
                <label class="form-label">Facebook</label>
                <input type="text" class="form-control" value="https://facebook.com/johndoe">
            </div>

            <!-- Twitter -->
            <div class="mb-3">
                <label class="form-label">Twitter</label>
                <input type="text" class="form-control" value="https://twitter.com/johndoe">
            </div>

            <!-- Instagram -->
            <div class="mb-3">
                <label class="form-label">Instagram</label>
                <input type="text" class="form-control" value="https://instagram.com/johndoe">
            </div>

            <!-- LinkedIn -->
            <div class="mb-3">
                <label class="form-label">LinkedIn</label>
                <input type="text" class="form-control" value="https://linkedin.com/in/johndoe">
            </div>

            <!-- Save Button -->
            <button type="button" class="btn btn-primary w-100">
                Save Team Member
            </button>

        </form>

    </div>

</div>

@endsection