@extends('admindashboardLayout')
@section('title','Manage Announcements | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    
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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Announcements</h4>
            <span class="text-muted">Manage platform-wide announcements</span>
        </div>

        <button class="btn btn-sm btn-primary" data-bs-toggle="offcanvas" data-bs-target="#createAnnouncement">
            <i class="bx bx-plus"></i> New Announcement
        </button>
    </div>

    <!-- Announcements Table -->
    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h5 class="mb-0">All Announcements</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle" id="exampleTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Audience</th>
                        <th>Date Created</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($announcements as $index => $announcement)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td class="fw-semibold">
                                {{ $announcement->title }}
                            </td>

                            <td>
                                <span class="badge 
                                    {{ $announcement->type === 'course' ? 'bg-info' : 'bg-primary' }}">
                                    {{ ucfirst($announcement->type) }}
                                </span>
                            </td>

                            <td>
                                @if($announcement->status === 'published')
                                    <span class="badge bg-success">Published</span>
                                @elseif($announcement->status === 'draft')
                                    <span class="badge bg-warning text-dark">Draft</span>
                                @else
                                    <span class="badge bg-danger">Deleted</span>
                                @endif
                            </td>

                            <td>
                                @if($announcement->audience === 'everyone')
                                    <span class="badge bg-secondary">Everyone</span>
                                @elseif($announcement->audience === 'students')
                                    <span class="badge bg-success">Students</span>
                                @else
                                    <span class="badge bg-primary">Instructors</span>
                                @endif
                            </td>

                            <td>
                                {{ $announcement->created_at->format('M d, Y') }}
                            </td>

                            <td class="text-nowrap">

                                <!-- Show -->
                                <a href="{{ route('admin.announcement.show', $announcement->id) }}"
                                    class="btn btn-sm btn-info">
                                    <i class="bx bx-show"></i>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('admin.announcement.edit', $announcement->id) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="bx bx-edit"></i>
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('admin.announcement.destroy', $announcement->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Delete this announcement?')"
                                            class="btn btn-sm btn-danger">
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

    <!-- ================= Create Announcement Offcanvas ================== -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="createAnnouncement">
        <div class="offcanvas-header">
            <h5>Create New Announcement</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body">
            <form method="POST" action="{{ route('admin.announcement.store') }}">
                @csrf

                {{-- Title --}}
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title') }}"
                        placeholder="Enter announcement title"
                        required>
                </div>

                {{-- Type --}}
                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" id="announcementType" class="form-select" required>
                        <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General</option>
                        <option value="course" {{ old('type') == 'course' ? 'selected' : '' }}>Course</option>
                    </select>
                </div>

                {{-- Audience --}}
                <div class="mb-3">
                    <label class="form-label">Audience</label>
                    <select name="audience" class="form-select" required>
                        <option value="everyone" {{ old('audience') == 'everyone' ? 'selected' : '' }}>Everyone</option>
                        <option value="students" {{ old('audience') == 'students' ? 'selected' : '' }}>Students</option>
                        <option value="instructors" {{ old('audience') == 'instructors' ? 'selected' : '' }}>Instructors</option>
                    </select>
                </div>

                {{-- Course (Only visible when type = course) --}}
                <div class="mb-3 d-none" id="courseSelectBox">
                    <label class="form-label">Select Course</label>
                    <select name="course_id" class="form-select">
                        <option value="">-- Select Course --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Message --}}
                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea class="form-control"
                            name="message"
                            rows="5"
                            placeholder="Write your announcement"
                            required>{{ old('message') }}</textarea>
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <button class="btn btn-primary w-100">
                    <i class="bx bx-save"></i> Save Announcement
                </button>
            </form>

        </div>
    </div>

</div>
<script>
    const typeSelect = document.getElementById('announcementType');
    const courseBox = document.getElementById('courseSelectBox');

    function toggleCourseBox() {
        if (typeSelect.value === 'course') {
            courseBox.classList.remove('d-none');
        } else {
            courseBox.classList.add('d-none');
        }
    }

    typeSelect.addEventListener('change', toggleCourseBox);
    toggleCourseBox(); // run on load
</script>
@endsection