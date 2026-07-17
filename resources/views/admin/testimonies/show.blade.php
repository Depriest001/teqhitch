@extends('admindashboardLayout')

@section('title', 'View Testimony | ' . $globalSetting->site_name)

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
            <h4 class="fw-bold">Testimony Details</h4>
            <span class="text-muted">Full information about the selected testimony</span>
        </div>

        <a href="{{ route('admin.testimony.index') }}" class="btn btn-sm btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <!-- Content Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="row align-items-center">

                <!-- Image -->
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    <img src="{{ $testimony->image ? asset('uploads/' . $testimony->image) : 'https://dummyimage.com/90x90/f0f0f0/000&text=User' }}"
                        class="rounded-circle shadow-sm"
                        width="120" height="120" style="object-fit: cover;">
                </div>

                <!-- Details -->
                <div class="col-md-9">

                    <h4 class="fw-bold mb-2">{{ $testimony->name }}</h4>

                    <p class="text-muted mb-3">
                        <i class="bx bx-bxs-quote-alt-left"></i>
                        {{ $testimony->message }}
                        <i class="bx bx-bxs-quote-alt-right"></i>
                    </p>

                    <hr>

                    <div class="row">

                        <div class="col-md-6 mb-2">
                            <strong>Status:</strong>
                            @if($testimony->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-2">
                            <strong>Date Added:</strong>
                            <span class="text-muted">{{ $testimony->created_at->format('M d, Y h:i A') }}</span>
                        </div>

                        <div class="col-md-6 mb-2">
                            <strong>Occuption:</strong>
                            <span class="text-muted">{{ $testimony->occupation ?? 'N/A' }}</span>
                        </div>

                    </div>

                    <hr>

                    <!-- Actions -->
                    <div class="mt-3">
                        <button class="btn btn-warning btn-sm me-2"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#editTestimony">
                            <i class="bx bx-edit"></i> Edit
                        </button>

                        <!-- TOGGLE STATUS -->
                        <form action="{{ route('admin.testimonies.toggle', $testimony->id) }}"                        
                            class="d-inline me-2"
                            method="POST">
                            @csrf
                            @method('PATCH')

                            <button 
                                type="submit"
                                onclick="return confirm('Are you sure you want to change the status?')"
                                class="btn btn-sm {{ $testimony->status ? 'btn-secondary' : 'btn-success' }}"
                            >
                                {{ $testimony->status ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        <!-- Delete -->
                        <form action="{{ route('admin.testimony.destroy', $testimony->id) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Are you sure you want to permenently delete this?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger">
                                <i class="bx bx-trash"></i> Delete
                            </button>
                        </form>
                    </div>

                </div>

            </div>

        </div>
    </div>

</div>

<!-- ================= OFFCANVAS ================= -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="editTestimony">

    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Edit New Testimony</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <form action="{{ route('admin.testimony.update', $testimony->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <!-- Name -->
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ $testimony->name }}" placeholder="Enter name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Occupation</label>
                <input type="text" name="occupation" class="form-control" value="{{ $testimony->occupation }}" placeholder="Enter Occupation" required>
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" id="profileInput" class="form-control">
            </div>

            <!-- IMAGE PREVIEW -->
            <div class="text-center mb-3">
                <img src="{{ $testimony->image ? asset('uploads/' . $testimony->image) : 'https://dummyimage.com/90x90/f0f0f0/000&text=User' }}"
                    class="rounded-circle shadow"
                    width="90" height="90" id="profilePic">
                <p class="text-muted mt-2 mb-0">Image Preview</p>
            </div>

            <!-- Message -->
            <div class="mb-3">
                <label class="form-label">Testimony</label>
                <textarea class="form-control" name="message" rows="4" placeholder="Enter testimony" required>{{ $testimony->message }}</textarea>
            </div>

            <button class="btn btn-primary w-100">
                Save Testimony
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