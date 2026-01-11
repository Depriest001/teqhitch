@extends('staffdashboardLayout')
@section('title','Instructor Dashboard | Teqhitch ICT Academy LTD')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Welcome Back, {{ auth()->user()->name }} 👋</h4>
            <p class="text-muted mb-0">Manage your courses, students, and academic activities</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Active Courses</h6>
                        <h3 class="fw-bold mb-0">{{ $activeCoursesCount }}</h3>
                    </div>
                    <span class="badge bg-dark p-3 rounded-circle">
                        <i class="bx bx-book-open fs-5"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Students Enrolled</h6>
                        <h3 class="fw-bold mb-0">{{ $totalStudents }}</h3>
                    </div>
                    <span class="badge bg-primary p-3 rounded-circle">
                        <i class="bx bx-user fs-5"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Assignments To Grade</h6>
                        <h3 class="fw-bold mb-0">{{ $pendingGrading }}</h3>
                    </div>
                    <span class="badge bg-warning p-3 rounded-circle">
                        <i class="bx bx-edit fs-5"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted">Reviews</h6>
                        <h3 class="fw-bold mb-0">0</h3>
                    </div>
                    <span class="badge bg-success p-3 rounded-circle">
                        <i class="bx bx-check-circle fs-5"></i>
                    </span>
                </div>
            </div>
        </div>

    </div>


    <div class="row g-3">

        <!-- My Courses -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between">
                    <h6 class="fw-bold mb-0">My Courses</h6>
                    <a href="#" class="text-dark small">View All</a>
                </div>

                <div class="card-body">

                    @forelse($courses as $course)
                        <div class="border rounded p-3 mb-3 d-flex flex-column flex-sm-row justify-content-between">
                            <div>
                                <h6 class="fw-bold mb-1">{{ $course->title }}</h6>
                                <p class="text-muted small mb-1">
                                    Enrolled Students: {{ $course->students_count }}
                                </p>

                                <span class="badge 
                                    {{ $course->status == 'published' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </div>

                            <div class="mt-3 mt-sm-0">
                                <a href="{{ route('staff.courses.show', $course->id) }}" class="btn btn-dark btn-sm me-2">Manage</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No courses yet.</p>
                    @endforelse

                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="col-lg-4">

            <!-- Pending Assignments -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white">
                    <h6 class="fw-bold mb-0">Assignments To Grade</h6>
                </div>

                <div class="card-body">
                    @forelse($pendingAssignmentsList as $assignment)
                        <div class="border rounded p-3 mb-2">
                            <h6 class="fw-bold mb-1">{{ $assignment->title }}</h6>
                            <small class="text-muted">
                                {{ $assignment->pending_submissions_count }} submissions pending
                            </small>

                            <div class="mt-2">
                                <a href="{{ route('staff.assignment.show', $assignment->id) }}" class="btn btn-sm btn-dark">Review</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">No pending grading 🎉</p>
                    @endforelse
                </div>
            </div>

            <!-- Recent Activities (Optional later dynamic) -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h6 class="fw-bold mb-0">Recent Activities</h6>
                </div>

                <div class="card-body">
                    <p class="text-muted">Activity logs coming soon...</p>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection