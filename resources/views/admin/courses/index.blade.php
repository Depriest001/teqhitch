@extends('admindashboardLayout')
@section('title','Manage Courses | Teqhitch ICT Academy LTD')

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
            <h4 class="fw-bold">Courses</h4>
            <span class="text-muted">Manage all platform courses</span>
        </div>

        <a href="{{ route('admin.courses.create')}}" class="btn btn-primary">
            <i class="bx bx-plus"></i> Add New Course
        </a>
    </div>

    <!-- Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Total Courses</h6>
                <h3>{{ $totalCourses }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Published</h6>
                <h3 class="text-success">{{ $publishedCourses }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Drafts</h6>
                <h3 class="text-warning">{{ $draftCourses }}</h3>
            </div>
        </div>
    </div>

    <!-- Courses Table -->
    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Course List</h5>
        </div>

        <div class="table-responsive">
            <table class="table tabl-sm table-hover align-middle" id="exampleTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>image</th>
                        <th>Course Title</th>
                        <th>Instructor</th>
                        <th>Status</th>
                        <th>Students</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($courses as $course)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <img src="{{ $course->thumbnail ? asset('storage/'.$course->thumbnail) : '' }}" 
                                width="40" height="40" class="rounded">
                        </td>

                        <td>{{ $course->title }}</td>

                        <td>{{ $course->instructor->name ?? 'Unknown' }}</td>

                        <td>
                            @if($course->status == 'published')
                                <span class="badge bg-success">Published</span>
                            @elseif($course->status == 'draft')
                                <span class="badge bg-warning">Draft</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($course->status) }}</span>
                            @endif
                        </td>

                        <td>{{ $course->students_count }}</td>

                        <td>{{ $course->created_at->format('M d, Y') }}</td>

                        <td class="text-nowrap">
                            <a href="{{ route('admin.courses.show', $course->id) }}" class="btn btn-sm btn-info">
                                <i class="bx bx-show"></i>
                            </a>

                            <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-sm btn-warning">
                                <i class="bx bx-edit"></i>
                            </a>

                            <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure you want to permanently remove this course?')" class="btn btn-sm btn-danger">
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
@endsection