@extends('admindashboardLayout')

@section('title', 'Team | ' . $globalSetting->site_name)

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

        @forelse($members as $member)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">

                    <div class="card-body text-center">

                        <img src="{{ $member->image ? asset('storage/' . $member->image) : asset('assets/img/user/icon-male.png') }}"
                            class="rounded-circle mb-3"
                            width="80" height="80">

                        <h5 class="mb-1">{{ $member->fullname }}</h5>
                        <small class="text-muted">{{ $member->position }}</small>

                        <div class="mt-2">
                            <span class="badge {{ $member->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $member->status ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                    </div>

                    <!-- SOCIAL MEDIA ICONS -->
                    <div class="d-flex justify-content-center gap-3">

                        <a href="{{ $member->facebook ?? '#' }}" target="_blank" class="text-primary fs-4">
                            <i class="bx bxl-facebook-circle"></i>
                        </a>

                        <a href="{{ $member->twitter ?? '#' }}" target="_blank" class="text-info fs-4">
                            <i class="bx bxl-twitter"></i>
                        </a>

                         <a href="{{ $member->instagram ?? '#' }}" target="_blank" class="text-danger fs-4">
                            <i class="bx bxl-instagram"></i>
                        </a>

                        <a href="{{ $member->linkedin ?? '#' }}" target="_blank" class="text-primary fs-4">
                            <i class="bx bxl-linkedin-square"></i>
                        </a>

                    </div>

                    <div class="card-footer bg-white border-0 d-flex justify-content-center gap-2">

                        <a href="{{ route('admin.team.show', $member->id) }}" class="btn btn-sm btn-info">
                            <i class="bx bx-show"></i> View
                        </a>

                        <form action="{{ route('admin.team.toggle-status', $member->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <button 
                                type="submit"
                                onclick="return confirm('Are you sure you want to change the status?')"
                                class="btn btn-sm {{ $member->status ? 'btn-warning' : 'btn-success' }}"
                            >
                                {{ $member->status ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>                       

                        <form action="{{ route('admin.team.destroy', $member->id) }}" method="POST">
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

        @empty
            <div class="col-12 text-center">
                <p class="text-muted">No team members yet.</p>
            </div>
        @endforelse

    </div>

</div>

<!-- ================= OFFCANVAS (CREATE TEAM) ================= -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="createTeam">

    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Add New Team Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <form action="{{ route('admin.team.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" name="fullname" placeholder="Enter full name" required>
            </div>

            <!-- Position -->
            <div class="mb-3">
                <label class="form-label">Position</label>
                <input type="text" class="form-control" name="position" placeholder="e.g Frontend Developer" required>
            </div>

            <!-- IMAGE UPLOAD -->
            <div class="mb-3">
                <label class="form-label">Change Image</label>
                <input type="file" class="form-control" name="image" id="profileInput" accept="image/*">
            </div>

            <!-- IMAGE PREVIEW -->
            <div class="text-center mb-3">
                <img src="https://dummyimage.com/90x90/f0f0f0/000&text=Team+profile"
                     class="rounded-circle shadow"
                     width="90" height="90" id="profilePic">
                <p class="text-muted mt-2 mb-0">Image Preview</p>
            </div>

            <!-- Facebook -->
            <div class="mb-3">
                <label class="form-label">Facebook</label>
                <input type="text" class="form-control" name="facebook" placeholder="https://facebook.com/johndoe">
            </div>

            <!-- Twitter -->
            <div class="mb-3">
                <label class="form-label">Twitter</label>
                <input type="text" class="form-control" name="twitter" placeholder="https://twitter.com/johndoe">
            </div>

            <!-- Instagram -->
            <div class="mb-3">
                <label class="form-label">Instagram</label>
                <input type="text" class="form-control" name="instagram" placeholder="https://instagram.com/johndoe">
            </div>

            <!-- LinkedIn -->
            <div class="mb-3">
                <label class="form-label">LinkedIn</label>
                <input type="text" class="form-control" name="linkedin" placeholder="https://linkedin.com/in/johndoe">
            </div>

            <!-- Save Button -->
            <button class="btn btn-primary w-100">
                Save Team Member
            </button>

        </form>

    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const input = document.getElementById("profileInput");
        const preview = document.getElementById("profilePic");
        // const dismissBtn = document.getElementById("dismiss");

        let objectUrl = null;

        if (!input || !preview) return;

        input.addEventListener("change", (e) => {
            const file = e.target.files[0];
            if (!file) return;

            // Validate file type
            if (!file.type.startsWith("image/")) {
                alert("Please select a valid image.");
                input.value = "";
                return;
            }

            // Validate file size (2MB example)
            const maxSize = 2 * 1024 * 1024;
            if (file.size > maxSize) {
                alert("Image must be less than 2MB.");
                input.value = "";
                return;
            }

            // Clean previous preview
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
            }

            objectUrl = URL.createObjectURL(file);

            preview.src = objectUrl;
        });
        dismissBtn?.addEventListener("click", () => {
            preview.src = "https://dummyimage.com/90x90/f0f0f0/000&text=Team+profile";
            input.value = "";

            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
                objectUrl = null;
            }
        });

    });
</script>
@endsection