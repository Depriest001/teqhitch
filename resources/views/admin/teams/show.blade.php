@extends('admindashboardLayout')

@section('title', 'Team Details | '. $globalSetting->site_name)

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
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Team Member Details</h4>
            <span class="text-muted">Full profile information</span>
        </div>

        <a href="{{ route('admin.team.index') }}" class="btn btn-sm btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <!-- PROFILE CARD -->
    
    <!-- PROFILE CARD -->
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm border-0">

                <div class="card-body text-center p-4">

                    <!-- Image -->
                    <img src="{{ $teamMember->image ? asset('uploads/'.$teamMember->image) : asset('assets/img/user/icon-male.png') }}"
                        class="rounded-circle mb-3 shadow"
                        width="100" height="100">

                    <!-- Name -->
                    <h4 class="mb-1">{{ $teamMember->fullname }}</h4>

                    <!-- Role -->
                    <small class="text-muted">{{ $teamMember->position }}</small>

                    <!-- Status -->
                    <div class="mt-2">
                        <span class="badge {{ $teamMember->status ? 'bg-success' : 'bg-danger' }}">
                            {{ $teamMember->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <hr>

                    <!-- SOCIAL MEDIA LINKS -->
                    <div class="text-start px-3">

                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bxl-facebook-circle text-primary fs-4 me-2"></i>
                            <a href="{{ $teamMember->facebook ?? '#' }}" target="_blank" class="text-decoration-none">
                                {{ $teamMember->facebook }}
                            </a>
                        </div>

                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bxl-twitter text-info fs-4 me-2"></i>
                            <a href="{{ $teamMember->twitter ?? '#' }}" target="_blank" class="text-decoration-none">
                                {{ $teamMember->twitter }}
                            </a>
                        </div>

                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bxl-instagram text-danger fs-4 me-2"></i>
                            <a href="{{ $teamMember->instagram ?? '#' }}" target="_blank" class="text-decoration-none">
                                {{ $teamMember->instagram }}
                            </a>
                        </div>

                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bxl-linkedin-square text-primary fs-4 me-2"></i>
                            <a href="{{ $teamMember->linkedin ?? '#' }}" target="_blank" class="text-decoration-none">
                                {{ $teamMember->linkedin }}
                            </a>
                        </div>

                    </div>

                    <hr>

                    <!-- ACTION BUTTONS -->
                    <div class="d-flex justify-content-center gap-2">

                        <!-- TOGGLE STATUS -->
                        <form action="{{ route('admin.team.toggle-status', $teamMember->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <button 
                                type="submit"
                                onclick="return confirm('Are you sure you want to change the status?')"
                                class="btn btn-sm {{ $teamMember->status ? 'btn-warning' : 'btn-success' }}"
                            >
                                {{ $teamMember->status ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        <!-- EDIT BUTTON -->
                        <button class="btn btn-primary btn-sm"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#editTeam">
                            Edit
                        </button>

                        <form action="{{ route('admin.team.destroy', $teamMember->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to permanently delete this?')">
                                <i class="bx bx-trash"></i> Delete
                            </button>
                        </form>

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

        <form action="{{ route('admin.team.update', $teamMember->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <!-- Name -->
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="fullname" class="form-control" value="{{ $teamMember->fullname }}">
            </div>

            <!-- Position -->
            <div class="mb-3">
                <label class="form-label">Position</label>
                <input type="text" name="position" class="form-control" value="{{ $teamMember->position }}">
            </div>

            <!-- IMAGE UPLOAD -->
            <div class="mb-3">
                <label class="form-label">Change Image</label>
                <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
            </div>

            <!-- IMAGE PREVIEW -->
            <div class="text-center mb-3">
                <img id="imagePreview"
                    src="{{ $teamMember->image ? asset('uploads/'.$teamMember->image) : asset('assets/img/user/icon-male.png') }}"
                    class="rounded-circle shadow"
                    width="90" height="90">
                <p class="text-muted mt-2 mb-0">Image Preview</p>
            </div>

            <!-- Facebook -->
            <div class="mb-3">
                <label class="form-label">Facebook</label>
                <input type="text" name="facebook" class="form-control" value="{{ $teamMember->facebook }}">
            </div>

            <!-- Twitter -->
            <div class="mb-3">
                <label class="form-label">Twitter</label>
                <input type="text" name="twitter" class="form-control" value="{{ $teamMember->twitter }}">
            </div>

            <!-- Instagram -->
            <div class="mb-3">
                <label class="form-label">Instagram</label>
                <input type="text" name="instagram" class="form-control" value="{{ $teamMember->instagram }}">
            </div>

            <!-- LinkedIn -->
            <div class="mb-3">
                <label class="form-label">LinkedIn</label>
                <input type="text" name="linkedin" class="form-control" value="{{ $teamMember->linkedin }}">
            </div>

            <!-- UPDATE BUTTON -->
            <button class="btn btn-primary w-100">
                Update Team Member
            </button>

        </form>

    </div>

</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
        }

        reader.readAsDataURL(file);
    }
});
</script>
@endsection