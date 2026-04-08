@extends('admindashboardLayout')

@section('title', 'Team Details | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Team Member Details</h4>
            <span class="text-muted">Full profile information</span>
        </div>

        <a href="{{ route('admin.teams.index') }}" class="btn btn-sm btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <!-- PROFILE CARD -->
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm border-0">

                <div class="card-body text-center p-4">

                    <!-- Image -->
                    <img src="https://via.placeholder.com/120"
                         class="rounded-circle mb-3 shadow"
                         width="100" height="100">

                    <!-- Name -->
                    <h4 class="mb-1">John Doe</h4>

                    <!-- Role -->
                    <small class="text-muted">Frontend Developer</small>

                    <!-- Status -->
                    <div class="mt-2">
                        <span class="badge bg-danger">Deactivated</span>
                    </div>

                    <hr>

                    <!-- SOCIAL MEDIA LINKS -->
                    <div class="text-start px-3">

                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bxl-facebook-circle text-primary fs-4 me-2"></i>
                            <a href="#" class="text-decoration-none">https://facebook.com/johndoe</a>
                        </div>

                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bxl-twitter text-info fs-4 me-2"></i>
                            <a href="#" class="text-decoration-none">https://twitter.com/johndoe</a>
                        </div>

                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bxl-instagram text-danger fs-4 me-2"></i>
                            <a href="#" class="text-decoration-none">https://instagram.com/johndoe</a>
                        </div>

                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bxl-linkedin-square text-primary fs-4 me-2"></i>
                            <a href="#" class="text-decoration-none">https://linkedin.com/in/johndoe</a>
                        </div>

                    </div>

                    <hr>

                    <!-- ACTION BUTTONS -->
                    <div class="d-flex justify-content-center gap-2">

                        <button class="btn btn-success btn-sm">
                            Activate
                        </button>

                        <!-- EDIT BUTTON -->
                        <button class="btn btn-primary btn-sm"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#editTeam">
                            Edit
                        </button>

                        <button class="btn btn-danger btn-sm">
                            Delete
                        </button>

                    </div>

                </div>

            </div>

        </div>
    </div>

</div>


<!-- ================= EDIT OFFCANVAS ================= -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="editTeam">

    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Edit Team Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <form>

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" value="John Doe">
            </div>

            <!-- Position -->
            <div class="mb-3">
                <label class="form-label">Position</label>
                <input type="text" class="form-control" value="Frontend Developer">
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

            <!-- UPDATE BUTTON -->
            <button type="button" class="btn btn-primary w-100">
                Update Team Member
            </button>

        </form>

    </div>

</div>

@endsection