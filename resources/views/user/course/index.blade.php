@extends('userdashboardLayout')
@section('title','User Dashboard | Teqhitch ICT Academy LTD')
@section('content')

<style>
.course-card{
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.course-card:hover{
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}
</style>
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
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-4">My Courses</h4>
        <a href="{{ route('user.courses.enroll') }}" class="btn btn-primary rounded-pill px-4"><i class="bx bx-plus-circle me-1"></i> Enroll Course</a>
    </div>
    <div class="row g-4">
    @forelse ($enrollments as $enrollment)
        @php
            $totalModules = $enrollment->course->modules->count();
            $completedModules = $enrollment->moduleProgress->where('status', 'completed')->count();

            $assignments = $enrollment->course->modules->flatMap(fn($module) => $module->assignments);
            $totalAssignments = $assignments->count();
            $gradedAssignments = $assignments->flatMap(fn($assignment) => 
                $assignment->submissions->where('student_id', $enrollment->student_id)->whereNotNull('graded_at')
            )->count();
            // Calculate progress percentage
            $moduleProgressPercent = $totalModules > 0 ? round(($completedModules / $totalModules) * 100) : 0;
            $assignmentProgressPercent = $totalAssignments > 0 ? round(($gradedAssignments / $totalAssignments) * 100) : 0;

            // Average progress (optional)
            $progress = $totalModules + $totalAssignments > 0
                ? round(($completedModules + $gradedAssignments) / ($totalModules + $totalAssignments) * 100)
                : 0;
        @endphp

        <div class="col-md-4">
            <div class="card h-100 course-card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">{{ $enrollment->course->title }}</h5>

                    <p class="card-text text-secondary">
                        {{ Str::limit(strip_tags($enrollment->course->description), 120) ?? 'No description available' }}
                    </p>

                    <div class="progress mb-2" style="height:6px;">
                        <div
                            class="progress-bar
                            {{ $progress < 50 ? 'bg-danger' :
                            ($progress < 80 ? 'bg-warning' : 'bg-success') }}"
                            style="width: {{ $progress }}%">
                        </div>
                    </div>

                    <small>{{ $progress }}% Completed</small>

                    <ul class="list-unstyled small mt-2 mb-2">
                        <li>Modules Completed: {{ $completedModules }} / {{ $totalModules }}</li>
                        <li>Assignments Graded: {{ $gradedAssignments }} / {{ $totalAssignments }}</li>
                    </ul>

                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('user.courses.show', $enrollment->course->id) }}"
                           class="btn btn-sm btn-primary">
                            Continue
                        </a>

                        @if($totalModules === 0 && $totalAssignments === 0)
                            <p class="text-muted mt-2">No content uploaded for this course yet.</p>

                        @elseif(!is_null($enrollment->completed_at))
                            <span class="badge bg-success mt-2">Course Completed</span>

                        @elseif($completedModules === $totalModules && $gradedAssignments === $totalAssignments)
                            <form action="{{ route('user.courses.complete', $enrollment->id) }}" method="POST" class="p-0 d-inline-block">
                                @csrf
                                <button class="btn btn-success btn-sm">
                                    Complete Course
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            <p class="text-muted">You have not enrolled in any course yet.</p>
        </div>
    @endforelse
</div>

</div>

@endsection