@extends('staffdashboardLayout')
@section('title','View Assignment | Teqhitch ICT Academy LTD')
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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">View Assignment</h4>
        <a href="{{ route('staff.assignment.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bx bx-arrow-back"></i> Back to Assignments
        </a>
    </div>

    <div class="row g-4">

        <!-- Assignment Info -->
        <div class="col-lg-4 col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-2">{{ $assignment->title }}</h5>

                    <p class="text-muted mb-3">
                        Course: <span class="fw-semibold">{{ $course->title }}</span>
                    </p>

                    <p class="text-muted mb-3">
                        Deadline:
                        <span class="fw-semibold">
                            {{ \Carbon\Carbon::parse($assignment->deadline)->format('M d, Y') }}
                        </span>
                    </p>

                    <p class="text-muted mb-3">
                        Total Marks:
                        <span class="fw-semibold">{{ $assignment->max_score }}</span>
                    </p>

                    <p class="text-muted mb-2 fw-semibold">Description</p>
                    <p class="text-sm text-muted mb-0">
                        {{ $assignment->instructions }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="col-lg-8 col-md-7">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Submission Overview</h6>

                    <div style="height:320px;">
                        <canvas id="submissionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Table -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h6 class="fw-bold mb-3">Student Submissions</h6>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Student</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Marks</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($submissions as $index => $submission)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>{{ $submission->student->name }}</td>
                                    <td>{{ $submission->student->email }}</td>

                                    <td>
                                        @switch($submission->status)
                                            @case('graded')
                                                <span class="badge bg-primary">Graded</span>
                                                @break
                                            @case('late')
                                                <span class="badge bg-danger">Late</span>
                                                @break
                                            @case('submitted')
                                                <span class="badge bg-success">Submitted</span>
                                                @break
                                            @default
                                                <span class="badge bg-warning">Pending</span>
                                        @endswitch
                                    </td>

                                    <td>
                                        @if($submission->score)
                                            {{ $submission->score }}/{{ $assignment->max_score }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        @if($submission->submitted_at)
                                            <a href="{{ route('staff.assignment.grade', [
                                                'assignment' => $assignment->id,
                                                'submission' => $submission->id
                                            ]) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="bx bx-edit-alt"></i> View / Grade
                                            </a>
                                        @else
                                            <button class="btn btn-sm btn-primary" disabled>
                                                <i class="bx bx-edit-alt"></i> View / Grade
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('submissionChart');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Submitted', 'Pending', 'Late'],
            datasets: [{
                data: [
                    {{ $stats['submitted'] }},
                    {{ $stats['pending'] }},
                    {{ $stats['late'] }}
                ],
                backgroundColor: ['#198754', '#ffc107', '#dc3545']
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' },
                title: { display: false }
            }
        }
    });
</script>

@endsection
