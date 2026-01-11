@extends('staffdashboardLayout')
@section('title','Manage Course | Teqhitch ICT Academy LTD')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Notifications --}}
        @if (session('success') || session('error') || $errors->any())
            <div id="appToast"
                class="bs-toast toast fade show position-fixed bottom-0 end-0 m-3
                {{ session('success') ? 'bg-success' : (session('error') ? 'bg-danger' : 'bg-warning') }}"
                role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">

                <div class="toast-header text-white">
                    <i class="icon-base bx bx-bell me-2"></i>
                    <div class="me-auto fw-medium">
                        {{ session('success') ? 'Success' : (session('error') ? 'Error' : 'Validation') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                </div>

                <div class="toast-body text-white">
                    @if (session('success')) {{ session('success') }}
                    @elseif (session('error')) {{ session('error') }}
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
        <!-- Header -->
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Manage Course</h4>
                <p class="text-muted mb-0">Control course settings, students, materials & progress</p>
            </div>

            <div>
                <a href="{{ route('staff.courses.index')}}" class="btn btn-sm mt-md-0 mt-3 btn-outline-secondary me-2">
                    <i class="bx bx-arrow-back"></i> Back
                </a>
            </div>
        </div>


        <!-- Course Overview -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div class="mb-3 mb-md-0">
                        <h5 class="fw-bold mb-1">{{ $course->title }}</h5>
                        <p class="text-muted small mb-1">{!! Str::limit(strip_tags($course->description),100) !!}</p>
                        <span class="badge bg-success">{{ ucfirst($course->status) }}</span>
                    </div>

                    <div>
                        <button class="btn btn-dark btn-sm mb-2 mb-md-0" data-bs-toggle="offcanvas" data-bs-target="#addModuleCanvas">
                            <i class="bx bx-plus-circle me-1"></i> Add Module
                        </button>                        

                        <!-- Button trigger Offcanvas -->
                        <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#createAssignment" aria-controls="createAssignment">
                            <i class="bx bx-task me-1"></i> Create Assignment
                        </button>
                    </div>
                </div>

            </div>
        </div>


        <div class="row g-3">

            <!-- Left Panel -->
            <div class="col-lg-8">

                <!-- Course Materials -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">Course Materials</h6>
                    </div>

                    <div class="card-body">

                        <!-- Module -->
                        @forelse($course->modules as $module)
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold mb-0">
                                        {{ $module->title }}
                                        <!-- Status Badge -->
                                        <span class="badge {{ $module->status === 'active' ? 'bg-success' : 'bg-secondary' }} ms-2">
                                            {{ ucfirst($module->status) }}
                                        </span>
                                    </h6>

                                    <div>
                                        <a href="{{ route('staff.module.edit', [$course->id, $module->id]) }}" class="btn btn-sm mb-md-0 mb-2 btn-outline-dark">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <form action="{{ route('staff.module.destroy', [$course->id, $module->id]) }}" method="POST" class="d-inline" 
                                            onsubmit="return confirm('Are you sure you want to delete this module?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="border rounded p-3 d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="me-2" style="min-width: 0;">
                                        <h6 class="fw-bold small mb-1 text-truncate" title="{{ basename($module->file_path) }}">
                                            <i class="bx bx-file me-1 text-primary"></i>
                                            <span class="text-break">{{ basename($module->file_path) }}</span>
                                        </h6>
                                        <small class="text-muted">
                                            Uploaded: {{ $module->created_at->diffForHumans() }}
                                        </small>
                                    </div>

                                    <a href="{{ Storage::url($module->file_path) }}" target="_blank" class="btn btn-outline-dark btn-sm mt-2 mt-md-0">
                                        View
                                    </a>
                                </div>

                            </div>

                        @empty
                            <p class="text-muted">No modules uploaded yet.</p>
                        @endforelse

                    </div>
                </div>

            </div>


            <!-- Right Panel -->
            <div class="col-lg-4">

                <!-- Course Stats -->
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-white border-0">
                        <h6 class="fw-bold mb-0">Course Statistics</h6>
                    </div>

                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Students</span>
                            <span class="fw-bold">{{ $stats['students'] }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Assignments</span>
                            <span class="fw-bold">{{ $stats['assignments'] }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Materials</span>
                            <span class="fw-bold">{{ $stats['materials'] }}</span>
                        </div>

                    </div>
                </div>


                <!-- Quick Actions -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h6 class="fw-bold mb-0">Quick Actions</h6>
                    </div>

                    <div class="card-body">

                        <a href="#" class="btn btn-outline-dark w-100 mb-2">
                            <i class="bx bx-group me-1"></i> View Students
                        </a>

                        <a href="{{ route('staff.assignment.index') }}" class="btn btn-outline-dark w-100 mb-2">
                            <i class="bx bx-task me-1"></i> Manage Assignments
                        </a>

                        <a href="#" class="btn btn-outline-dark w-100 mb-2">
                            <i class="bx bx-bar-chart-alt-2 me-1"></i> Course Analytics
                        </a>

                    </div>
                </div>

            </div>

        </div>
    </div>

<!-- Add Module Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="addModuleCanvas">
    <div class="offcanvas-header">
        <h5 class="fw-bold mb-0">Add New Module</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form action="{{ route('staff.course.module.store', $course->id) }} " method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Module Title</label>
                <input type="text" name="module_title" class="form-control" placeholder="Enter module title" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Short Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Brief module description" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Upload Material</label>
                <input type="file" name="material" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/zip,text/plain" class="form-control" required>
                <small class="text-muted">Supported: PDF, DOCX, PPT, ZIP</small>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-dark">
                    <i class="bx bx-save me-1"></i> Save Module
                </button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- create Assignment Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="createAssignment" aria-labelledby="createAssignmentLabel">
    <div class="offcanvas-header">
        <h5 id="createAssignmentLabel" class="offcanvas-title">Create New Assignment</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">

        <form action="{{ route('staff.course.assignment.store', $course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="assignmentTitle" class="form-label">Assignment Title</label>
                <input type="text" class="form-control" id="assignmentTitle" name="title" placeholder="Enter assignment title" required>
            </div>

            <div class="mb-3">
                <label for="assignmentDescription" class="form-label">Description</label>
                <textarea class="form-control" id="assignmentDescription" name="description" rows="4" placeholder="Enter description" required></textarea>
            </div>

            <div class="mb-3">
                <label for="dueDate" class="form-label">Due Date</label>
                <input type="date" class="form-control" id="dueDate" name="deadline" required>
            </div>

            <div class="mb-3">
                <label for="maxScore" class="form-label">Maximum Score</label>
                <input type="number" class="form-control" id="maxScore" name="max_score" placeholder="Enter max score" required>
            </div> 

            <button type="submit" class="btn btn-success w-100">
                <i class="bx bx-plus-circle me-1"></i> Create Assignment
            </button>
        </form>


    </div>
</div>


@endsection