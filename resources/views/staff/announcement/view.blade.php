@extends('staffdashboardLayout')
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
     
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Manage Announcements</h4>
            <p class="text-muted mb-0">Create, update, or delete announcements</p>
        </div>

        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="offcanvas" data-bs-target="#newAnnouncement">
            <i class="bx bx-plus"></i> New Announcement
        </a>
    </div>

    <!-- Announcements Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-md-5 p-2">

            <div class="table-responsive">
                <table class="table table-sm table-hover table-sm align-middle mb-0" id="exampleTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Audience</th>
                            <th>Status</th>
                            <th>Posted On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($announcements as $announcement)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $announcement->title }}</td>
                                <td>
                                    @if($announcement->audience == 'everyone')
                                        All Students
                                    @elseif($announcement->audience == 'students')
                                        Students Only
                                    @elseif($announcement->audience == 'instructors')
                                        Instructors Only
                                    @else
                                        Specific
                                    @endif
                                </td>
                                <td>
                                    @if($announcement->status == 'published')
                                        <span class="badge bg-success">Published</span>
                                    @elseif($announcement->status == 'draft')
                                        <span class="badge bg-warning text-dark">Draft</span>
                                    @else
                                        <span class="badge bg-secondary">Expired</span>
                                    @endif
                                </td>
                                <td>{{ $announcement->published_at?->format('M d, Y') ?? '-' }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('staff.announcement.show', $announcement->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="offcanvas" data-bs-target="#editAnnouncement{{ $announcement->id }}">
                                        <i class="bx bx-edit-alt"></i>
                                    </button>
                                    <form action="{{ route('staff.announcement.destroy', $announcement->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this announcement?')"><i class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Optional: individual edit offcanvas for each announcement -->
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="editAnnouncement{{ $announcement->id }}">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title fw-bold">Edit Announcement</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                                </div>

                                <div class="offcanvas-body">
                                    <form action="{{ route('staff.announcement.update', $announcement->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Title</label>
                                            <input type="text" name="title" class="form-control" value="{{ $announcement->title }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Message</label>
                                            <textarea name="message" rows="4" class="form-control">{{ $announcement->message }}</textarea>
                                        </div>

                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Status</label>
                                            <select name="status" class="form-select">
                                                <option value="draft" {{ $announcement->status == 'draft' ? 'selected' : '' }}>
                                                    Draft
                                                </option>
                                                <option value="published" {{ $announcement->status == 'published' ? 'selected' : '' }}>
                                                    Published
                                                </option>
                                            </select>
                                        </div>

                                        <div class="d-flex justify-content-end gap-2 mt-3">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">
                                                Cancel
                                            </button>

                                            <button type="submit" class="btn btn-primary">
                                                Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<!-- Include Offcanvas for New Announcement -->
<div class="offcanvas offcanvas-end shadow" tabindex="-1" id="newAnnouncement">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold">Create New Announcement</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <form action="{{ route('staff.announcement.store') }}" method="POST">
            @csrf

            <!-- Title -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter announcement title" required>
            </div>

            <!-- Message -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Message</label>
                <textarea name="message" rows="4" class="form-control" placeholder="Write announcement details..." required></textarea>
            </div>

            <!-- Select Course (only instructor's courses) -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Course</label>
                <select name="course_id" class="form-select" required>
                    @foreach(auth()->user()->instructorCourses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status (optional: draft or published) -->
            <input type="hidden" name="status" value="published">

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">
                    Cancel
                </button>

                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-send"></i> Publish Announcement
                </button>
            </div>
        </form>


    </div>
</div>

@endsection
