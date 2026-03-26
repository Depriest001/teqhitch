@extends('admindashboardLayout') 
@section('title','Certificates | Teqhitch ICT Academy LTD')

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
            <h4 class="fw-bold mb-1">Certificates</h4>
            <p class="text-muted mb-0">Manage student certificates</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == null ? 'active' : '' }}" href="{{ route('admin.certificates.index') }}">All</a></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'issued' ? 'active' : '' }}" 
                        href="{{ route('admin.certificates.index', ['status' => 'issued']) }}">
                        Issued
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" 
                        href="{{ route('admin.certificates.index', ['status' => 'pending']) }}">
                        Not Uploaded
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Certificates Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Certificate List</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-sm" id="exampleTable">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Status</th>
                        <th>Uploaded</th>
                        <th>Date Issued</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody class="table-border-bottom-0">
                    @foreach($enrollments as $enrollment)
                        <tr>
                            <!-- Student -->
                            <td>
                                <strong>{{ $enrollment->student->name }}</strong>
                            </td>

                            <!-- Course -->
                            <td>{{ $enrollment->course->title }}</td>

                            <!-- Status -->
                            <td>
                                @if($enrollment->certificate)
                                    <span class="badge bg-success">Issued</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>

                            <!-- Uploaded -->
                            <td>
                                @if($enrollment->certificate && $enrollment->certificate->file_path)
                                    <span class="badge bg-label-success">Yes</span>
                                @else
                                    <span class="badge bg-label-danger">No</span>
                                @endif
                            </td>

                            <!-- Date Issued -->
                            <td>
                                {{ $enrollment->certificate?->issued_at?->format('d M Y') ?? '-' }}
                            </td>

                            <!-- Actions -->
                            <td>
                                @if($enrollment->certificate)
                                    <!-- View -->
                                    <a href="{{ route('admin.certificates.show', $enrollment->certificate->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bx bx-show"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.certificates.destroy', $enrollment->certificate->id) }}" 
                                        class="d-inline-block" 
                                        method="POST" 
                                        onsubmit="return confirm('Are you sure you want to delete this certificate?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <!-- Upload -->
                                    <button class="btn btn-sm btn-success"  
                                        data-bs-toggle="offcanvas" 
                                        data-bs-target="#addCertificate"
                                        data-enrollment="{{ $enrollment->id }}">
                                    <i class="bx bx-upload"></i> Upload
                                </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ================= Add Certificate Offcanvas ================== -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="addCertificate">
    <div class="offcanvas-header">
        <h5>Upload Certificate</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="enrollment_id" id="enrollment_id" value="">

            <div class="mb-3">
                <label for="certificate_code" class="form-label">Certificate Code</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="certificate_code" name="certificate_code" readonly required>
                    <button type="button" class="btn btn-outline-secondary" id="generateCode">Generate</button>
                    <button type="button" class="btn btn-outline-secondary" id="copyCode">Copy</button>
                </div>
            </div>

            <div class="mb-3">
                <label for="thumbnail" class="form-label">Upload Certificate Image</label>
                <input type="file" class="form-control" name="thumbnail" id="thumbnail"  accept="image/*" required>
            </div>

            <div class="mb-3">
                <label for="file_path" class="form-label">Upload PDF Certificate</label>
                <input type="file" class="form-control" name="file_path" id="file_path" accept="application/pdf" required>
            </div>

            <button type="submit" class="btn btn-primary">Upload Certificate</button>
        </form>
    </div>
</div>

<script>
    var offcanvasEl = document.getElementById('addCertificate');
    offcanvasEl.addEventListener('show.bs.offcanvas', function (event) {
        var button = event.relatedTarget;
        var enrollmentId = button.getAttribute('data-enrollment');
        document.getElementById('enrollment_id').value = enrollmentId;
    });

    document.getElementById('generateCode').addEventListener('click', function() {
        fetch("{{ route('admin.certificates.generate_code') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById('certificate_code').value = data.code;
            });
    });

    document.getElementById('copyCode').addEventListener('click', function() {
        let codeInput = document.getElementById('certificate_code');
        codeInput.select();
        codeInput.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(codeInput.value);
        alert('Certificate code copied!');
    });
</script>
@endsection