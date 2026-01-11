@extends('staffdashboardLayout')
@section('title','Student Details | Teqhitch ICT Academy LTD')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Student Details</h4>
        <a href="{{ route('staff.student.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bx bx-arrow-back"></i> Back to Students
        </a>
    </div>

    <div class="row g-4">

        <!-- Student Info Card -->
        <div class="col-lg-4 col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">

                    <img src="{{ asset('assets/img/user/icon-male.png')}}" 
                         alt="Student Avatar" class="rounded-circle mb-3" width="100">

                    <h5 class="fw-bold mb-1">{{ $enrollment->student->name }}</h5>

                    <p class="text-muted mb-2">{{ $enrollment->student->email }}</p>

                    <span class="badge bg-primary mb-3">
                        Enrolled: {{ $enrollment->created_at->format('M d, Y') }}
                    </span>

                    <ul class="list-group list-group-flush text-start mt-3">
                        <li class="list-group-item d-flex justify-content-between">
                            Phone
                            <span class="text-muted">
                                {{ $enrollment->student->phone ?? 'N/A' }}
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            Status
                            <span class="badge 
                                {{ $enrollment->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            Course
                            <span class="text-muted">
                                {{ $enrollment->course->title }}
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            Progress
                            <span class="text-muted">
                                {{ $enrollment->progress ?? 0 }}%
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Performance -->
        <div class="col-lg-8 col-md-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#course">
                                Course Progress
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#assignments">
                                Assignments
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">

                        <!-- Course Progress -->
                        <div class="tab-pane fade show active" id="course">
                            <canvas id="courseProgressChart" height="200"></canvas>
                        </div>

                        <!-- Assignments -->
                        <div class="tab-pane fade" id="assignments">
                            <p class="text-muted">Assignment analytics coming soon…</p>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctxCourses = document.getElementById('courseProgressChart').getContext('2d');
new Chart(ctxCourses, {
    type: 'bar',
    data: {
        labels: ['{{ $enrollment->course->title }}'],
        datasets: [{
            label: 'Progress (%)',
            data: [{{ $enrollment->progress ?? 0 }}],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            title: { display: true, text: 'Course Progress' }
        },
        scales: {
            y: { beginAtZero: true, max: 100 }
        }
    }
});
</script>

@endsection
