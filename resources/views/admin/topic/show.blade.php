@extends('admindashboardLayout')
@section('title','Topic Details | Admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- ================= Backend Message ================= --}}
    @if (session('success') || session('error') || $errors->any())
        <div id="appToast"
            class="bs-toast toast fade show position-fixed bottom-0 end-0 m-3
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

    {{-- ================= HEADER ================= --}}

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-4 gap-2">

        <div>
            <h4 class="fw-bold mb-1">Topic Overview</h4>
            <p class="text-muted mb-0">
                Manage topic information, files, and availability
            </p>
        </div>

        {{-- Buttons Container --}}
        <div class="d-flex gap-2 mt-2 mt-md-0 ms-md-3">
            <a href="{{ route('admin.topics.index') }}"
            class="btn btn-sm btn-outline-secondary w-100 w-md-auto">
                <i class="bx bx-arrow-back"></i> Back
            </a>

            <a href="{{ route('admin.topics.edit',$topic->id) }}"
            class="btn btn-sm btn-warning w-100 w-md-auto">
                <i class="bx bx-edit"></i> Edit
            </a>

            <button class="btn btn-sm btn-primary w-100 w-md-auto"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#uploadFiles">
                <i class="bx bx-upload"></i> Upload Files
            </button>
        </div>

    </div>

    {{-- ================= SUMMARY CARD ================= --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="fw-bold mb-2">{{ $topic->title }}</h5>

                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge bg-primary">{{ $topic->academic_level }}</span>
                        <span class="badge bg-info text-capitalize">{{ $topic->paper_type }}</span>

                        @if($topic->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                        <span class="text-warning fw-semibold">
                            {{ number_format($topic->average_rating, 1) }}
                            <i class="bx bxs-star"></i>
                        </span>
                        <span class="fw-semibold">{{ $topic->usage_count }} Downloads</span>
                    </div>
                </div>

                <small class="text-muted text-end">
                    Created<br>
                    {{ $topic->created_at->format('d M Y') }}
                </small>
            </div>

            <hr>
            <h6 class="fw-bold text-uppercase text-muted mb-0">Department</h6>
            <p class="mb-4 text-muted">
                {{ $topic->department ?? 'Null' }}
            </p>

            <h6 class="fw-bold text-uppercase text-muted">Description</h6>
            <p class="mb-0 text-muted">
                {{ $topic->description ?? 'No description provided.' }}
            </p>

        </div>
    </div>

    {{-- ================= FILE MANAGEMENT ================= --}}
    <div class="row g-4">

        {{-- PAPER CARD --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">Paper Document</h6>

                        @if($topic->paper && $topic->paper->paper_path)
                            <span class="badge bg-success">Uploaded</span>
                        @else
                            <span class="badge bg-warning">Not Uploaded</span>
                        @endif
                    </div>

                    @if($topic->paper && $topic->paper->paper_path)
                        <p class="mb-2 fw-semibold">
                            {{ $topic->paper->title }}
                        </p>

                        <small class="text-muted">
                            Uploaded on {{ $topic->paper->created_at->format('d M Y') }}
                        </small>

                        <div class="mt-3 d-flex gap-2">
                            <a href="{{ route('admin.papers.download',$topic->paper->id) }}"
                               class="btn btn-outline-primary btn-sm">
                                Download
                            </a>

                            <button class="btn btn-outline-warning btn-sm"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#uploadFiles">
                                Replace
                            </button>
                        </div>
                    @else
                        <p class="text-muted mb-0">
                            No paper uploaded yet.
                        </p>
                    @endif

                </div>
            </div>
        </div>

        {{-- SOFTWARE CARD (PROJECT ONLY) --}}
        @if($topic->paper_type === 'project')
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">Project Software</h6>

                        @if($topic->paper && $topic->paper->software_path)
                            <span class="badge bg-success">Uploaded</span>
                        @else
                            <span class="badge bg-warning">Not Uploaded</span>
                        @endif
                    </div>

                    @if($topic->paper && $topic->paper->software_path)
                        <p class="mb-2 fw-semibold">
                            Source Code Package
                        </p>

                        <small class="text-muted">
                            Last updated {{ $topic->paper->updated_at->format('d M Y') }}
                        </small>

                        <div class="mt-3 d-flex gap-2">
                            <a href="{{ route('admin.papers.downloadSoftware',$topic->paper->id) }}"
                               class="btn btn-outline-dark btn-sm">
                                Download
                            </a>

                            <button class="btn btn-outline-warning btn-sm"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#uploadFiles">
                                Replace
                            </button>
                        </div>
                    @else
                        <p class="text-muted mb-0">
                            No software uploaded yet.
                        </p>
                    @endif

                </div>
            </div>
        </div>
        @endif

    </div>
</div>

{{-- ================= OFFCANVAS UPLOAD ================= --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="uploadFiles">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Upload Topic Files</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form action="{{ route('admin.papers.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="topic_id" value="{{ $topic->id }}">

            <div class="mb-3">
                <label class="form-label">Paper Title</label>
                <input type="text"
                       name="title"
                       class="form-control"
                       value="{{ $topic->paper->title ?? '' }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Paper Document</label>
                <input type="file"
                       name="paper_file"
                       class="form-control"
                       accept=".pdf,.doc,.docx">
                <small class="text-muted">
                    PDF or Word document
                </small>
            </div>

            @if($topic->paper_type === 'project')
            <div class="mb-3">
                <label class="form-label">Project Software</label>
                <input type="file"
                       name="software_file"
                       class="form-control"
                       accept=".zip,.rar">
                <small class="text-muted">
                    ZIP or RAR archive
                </small>
            </div>
            @endif

            <button class="btn btn-primary w-100">
                Save Files
            </button>
        </form>
    </div>
</div>

@endsection
