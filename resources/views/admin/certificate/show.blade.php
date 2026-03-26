@extends('admindashboardLayout') 
@section('title','Certificate Details | Teqhitch ICT Academy LTD')

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
            <h4 class="fw-bold mb-1">Certificate Details</h4>
            <p class="text-muted mb-0">Manage certificate for this student</p>
        </div>
        <a href="{{ route('admin.certificates.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bx bx-arrow-back me-1"></i> Back to List
        </a>
    </div>

    <!-- Certificate Card -->
    <div class="card mb-4">
        <div class="card-body row g-4">

            <!-- Left: Certificate Thumbnail -->
            <div class="col-md-5 text-center">
                @if($certificate->thumbnail)
                    <img 
                        src="{{ $certificate?->thumbnail ? asset('uploads/'.$certificate->thumbnail) : 'https://dummyimage.com/600x400/e0e0e0/000&text=Certificate+Preview' }}" 
                        class="img-fluid rounded shadow-sm"
                        alt="Certificate Thumbnail">
                @else
                    <div class="border rounded p-5 text-muted">
                        <i class="bx bx-file font-large mb-2"></i>
                        <p>No Thumbnail</p>
                    </div>
                @endif
            </div>

            <!-- Right: Certificate Info -->
            <div class="col-md-7">
                <h5 class="mb-3">{{ $certificate->enrollment->course->title ?? 'Unknown Course' }}</h5>

                <ul class="list-unstyled mb-3">
                    <li class="mb-2"><strong>Student:</strong> {{ $certificate->enrollment->student->name ?? 'Unknown Student' }}</li>
                    <li class="mb-2"><strong>Enrollment ID:</strong> #{{ $certificate->enrollment->id }}</li>
                    <li class="mb-2"><strong>Certificate Code:</strong> {{ $certificate->certificate_code }}</li>
                    <li class="mb-2"><strong>Status:</strong> 
                        @if($certificate->file_path)
                            <span class="badge bg-success">Issued</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </li>
                    <li><strong>Issued At:</strong> 
                        {{ $certificate->issued_at ? $certificate->issued_at->format('d M Y') : '-' }}
                    </li>
                </ul>

                <!-- Actions -->
                <div class="d-flex flex-wrap gap-2">
                    @if($certificate->file_path)
                        <a href="{{ asset('uploads/'.$certificate->file_path) }}" target="_blank" class="btn btn-primary">
                            <i class="bx bx-show btn-sm me-1"></i> View PDF
                        </a>
                    @else
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="btn btn-warning mb-0">
                                <i class="bx bx-upload me-1"></i> Upload PDF
                                <input type="file" name="file_path" hidden onchange="this.form.submit()">
                            </label>
                        </form>
                    @endif

                    <button class="btn btn-sm btn-warning"  
                            data-bs-toggle="offcanvas" 
                            data-bs-target="#editCertificate">
                        <i class="bx bx-pen me-1"></i> Edit
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Optional: Related Info / Stats -->
    <div class="row">
        <div class="col-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h6>Total Modules Completed</h6>
                    <span class="display-6 fw-bold">{{ $certificate->enrollment->completed_modules ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h6>Total Assignments Completed</h6>
                    <span class="display-6 fw-bold">{{ $certificate->enrollment->completed_assignments ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
    <!-- ================= Add Certificate Offcanvas ================== -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="editCertificate">
        <div class="offcanvas-header">
            <h5>Upload Certificate</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body">
            <form action="{{ route('admin.certificates.update', $certificate->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="thumbnail" class="form-label">Upload Certificate Image</label>
                    <input type="file" class="form-control" name="thumbnail" id="thumbnail" accept="image/*">
                </div>

                <div class="mb-3">
                    <img 
                        src="{{ $certificate?->thumbnail ? asset('uploads/'.$certificate->thumbnail) : 'https://dummyimage.com/600x400/e0e0e0/000&text=Certificate+Preview' }}" 
                        class="img-fluid rounded"
                        id="preview"
                        alt="Certificate Thumbnail">
                </div>

                <div class="mb-3">
                    <label for="file_path" class="form-label">Upload PDF Certificate</label>
                    <input type="file" class="form-control" name="file_path" id="file_path" accept="application/pdf">
                </div>

                <button type="submit" class="btn btn-primary">Upload Certificate</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Dismiss</button>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {

        const input = document.getElementById("thumbnail");
        const preview = document.getElementById("preview");
        const dismissBtn = document.getElementById("dismiss");file_path

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
            preview.src = "{{ $certificate?->thumbnail ? asset('uploads/'.$certificate->thumbnail) : 'https://dummyimage.com/600x400/e0e0e0/000&text=Certificate+Preview' }}";
            input.value = "";
            document.getElementById("file_path").value = "";

            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
                objectUrl = null;
            }
        });

    });
</script>
@endsection