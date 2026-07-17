@extends('admindashboardLayout')

@section('title', 'Testimonies | '. $globalSetting->site_name)

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
            <h4 class="fw-bold">Testimonies</h4>
            <span class="text-muted">What our students and clients are saying</span>
        </div>

        <!-- Trigger Offcanvas -->
        <button class="btn btn-sm btn-primary" data-bs-toggle="offcanvas" data-bs-target="#createTestimony">
            <i class="bx bx-plus"></i> New Testimony
        </button>
    </div>

    <!-- Table Design -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-sm table-striped align-middle" id="exampleTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Occupation</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($testimonies as $index => $testimony)

                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <!-- Image -->
                                <td>
                                    <img src="{{ $testimony->image ? asset('uploads/' . $testimony->image) : 'https://dummyimage.com/90x90/f0f0f0/000&text=User' }}"
                                        class="rounded-circle"
                                        width="30"
                                        height="30">
                                </td>

                                <!-- Name -->
                                <td>{{ $testimony->name }}</td>

                                <!-- Occupation -->
                                <td>{{ $testimony->occupation ?? 'N/A' }}</td>

                                <!-- Message -->
                                <td>{{ Str::limit($testimony->message, 50) }}</td>

                                <!-- Status -->
                                <td>
                                    @if($testimony->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="text-center">

                                    <!-- Toggle Status -->
                                    <a href="{{ route('admin.testimony.show', $testimony->id) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="bx bx-show"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.testimony.destroy', $testimony->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to permenently delete this?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger">
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

</div>

<!-- ================= OFFCANVAS ================= -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="createTestimony">

    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Create New Testimony</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <form action="{{ route('admin.testimony.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <!-- Name -->
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Occupation</label>
                <input type="text" name="occupation" class="form-control" placeholder="Enter Occupation" required>
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" id="profileInput" class="form-control">
            </div>

            <!-- IMAGE PREVIEW -->
            <div class="text-center mb-3">
                <img src="https://dummyimage.com/90x90/f0f0f0/000&text=User+profile"
                     class="rounded-circle shadow"
                     width="90" height="90" id="profilePic">
                <p class="text-muted mt-2 mb-0">Image Preview</p>
            </div>

            <!-- Message -->
            <div class="mb-3">
                <label class="form-label">Testimony</label>
                <textarea class="form-control" name="message" rows="4" placeholder="Enter testimony" required></textarea>
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