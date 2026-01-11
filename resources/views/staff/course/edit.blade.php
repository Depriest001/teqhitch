@extends('staffdashboardLayout')
@section('title','Edit Module | Teqhitch ICT Academy LTD')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- Header -->
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Edit Module</h4>
            <p class="text-muted mb-0">Update module title, description, or replace uploaded material</p>
        </div>
        <div>
            <a href="{{ route('staff.courses.show', $course->id) }}" class="btn btn-sm mt-md-0 mt-3 btn-outline-secondary">
                <i class="bx bx-arrow-back"></i> Back to Course
            </a>
        </div>
    </div>

    <!-- Edit Module Form -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('staff.module.update', [$course->id, $module->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Module Title -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Module Title</label>
                    <input type="text" name="module_title" class="form-control" value="{{ old('module_title', $module->title) }}" required>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Enter module description">{{ old('description', $module->description ?? '') }}</textarea>
                </div>

                <!-- Current Material -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Current Material</label>
                    @if($module->file_path)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bx bx-file text-primary fs-4"></i>
                            <span>{{ basename($module->file_path) }}</span>
                            <a href="{{ asset('storage/' . $module->file_path) }}" target="_blank" class="btn btn-sm btn-outline-dark ms-auto">
                                View
                            </a>
                        </div>
                    @else
                        <p class="text-muted">No material uploaded yet.</p>
                    @endif
                </div>

                <div class="row">
                    <!-- Status Select -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ $module->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $module->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Replace Material -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-semibold">Replace Material (Optional)</label>
                        <input type="file" name="material" class="form-control"
                            accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/zip,text/plain">
                        <small class="text-muted">Supported: PDF, DOC, DOCX, PPT, PPTX, ZIP, TXT</small>
                    </div>
                </div>

                <!-- Form Buttons -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('staff.courses.show', $course->id) }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> Update Module
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
