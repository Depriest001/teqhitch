@extends('admindashboardLayout')
@section('title','Edit Announcement | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Edit Announcement</h4>
            <span class="text-muted">Update announcement details</span>
        </div>

        <a href="{{ route('admin.announcement.index') }}" class="btn btn-sm btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm p-4">
                <h5 class="fw-bold mb-4">Update Announcement</h5>

                <form method="POST" action="{{ route('admin.announcement.update', $announcement->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title', $announcement->title) }}"
                               required>
                    </div>

                    {{-- Type --}}
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" id="announcementType" class="form-select" required>
                            <option value="general" {{ old('type', $announcement->type) == 'general' ? 'selected' : '' }}>General</option>
                            <option value="course" {{ old('type', $announcement->type) == 'course' ? 'selected' : '' }}>Course</option>
                            <option value="system" {{ old('type', $announcement->type) == 'system' ? 'selected' : '' }}>System</option>
                        </select>
                    </div>

                    {{-- Audience --}}
                    <div class="mb-3">
                        <label class="form-label">Audience</label>
                        <select name="audience" class="form-select" required>
                            <option value="students" {{ old('audience', $announcement->audience) == 'students' ? 'selected' : '' }}>Student</option>
                            <option value="instructors" {{ old('audience', $announcement->audience) == 'instructors' ? 'selected' : '' }}>Instructor</option>
                            <option value="admin" {{ old('audience', $announcement->audience) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    {{-- Content --}}
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="message" class="form-control" rows="6" required>{{ old('message', $announcement->message) }}</textarea>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="published" {{ old('status', $announcement->status) == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ old('status', $announcement->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="archived" {{ old('status', $announcement->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="reset" class="btn btn-secondary">
                            <i class="bx bx-reset"></i> Reset
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> Update Announcement
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    // Optional: toggle course selection if type is 'course'
    const typeSelect = document.getElementById('announcementType');
    typeSelect.addEventListener('change', () => {
        // Add logic here if you want a dynamic course select box
    });
</script>
@endsection
