@extends('userdashboardLayout')
@section('title','User Dashboard | Teqhitch ICT Academy LTD')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold">Student Dashboard</h4>
                <a href="{{ route('user.courses.enroll') }}" class="btn btn-primary rounded-pill px-4"><i class="bx bx-plus-circle me-1"></i> Enroll Course</a>
            </div>

            <!-- Stats Row -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card h-100 p-4 card-glow rounded-2xl">
                        <h6 class="text-uppercase text-secondary mb-2">Enrolled Courses</h6>
                        <h4 class="fw-bold">{{ $totalCourses }}</h4>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 p-4 card-glow rounded-2xl">
                        <h6 class="text-uppercase text-secondary mb-2">Completed</h6>
                        <h4 class="fw-bold">{{ $completedCourses }}</h4>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 p-4 card-glow rounded-2xl">
                        <h6 class="text-uppercase text-secondary mb-2">Overall Progress</h6>
                        <div class="progress">
                            <div class="progress-bar" style="width: {{ $overallProgress }}%"></div>
                        </div>
                        <small class="text-secondary">{{ $overallProgress }}% Completed</small>

                    </div>
                </div>

                <!-- Courses & Activity -->
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card p-4 rounded-2xl">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="section-title">Ongoing Courses</h5>
                                <!-- <a href="#" class="text-info">View all</a> -->
                            </div>

                            <div class="table-responsive rounded-2xl">
                                <table class="table table-dark table-striped align-middle">
                                    <thead>
                                        <tr>
                                        <th>Course</th>
                                        <th>Module</th>
                                        <th>Progress</th>
                                        <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($ongoingEnrollments as $enrollment)
                                            @php
                                                $progress = round($enrollment->moduleProgress->avg('progress') ?? 0);
                                            @endphp
                                            <tr>
                                                <td>{{ $enrollment->course->title }}</td>
                                                <td>
                                                    Module {{ $enrollment->moduleProgress->count() }}
                                                </td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar" style="width: {{ $enrollment->progress }}%"></div>
                                                    </div>
                                                    <small>{{ $enrollment->progress }}%</small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">In Progress</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">
                                                    No ongoing courses
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card p-4 rounded-2xl">
                        <h5 class="section-title mb-3">Upcoming Deadlines</h5>
                            <ul class="list-group list-group-flush">
                                @forelse($upcomingAssignments as $assignment)
                                    @php
                                        $daysLeft = now()->startOfDay()
                                            ->diffInDays(\Carbon\Carbon::parse($assignment->deadline)->startOfDay(), false);
                                    @endphp

                                    <li class="list-group-item bg-transparent border-secondary">
                                        <div class="d-flex justify-content-between">
                                            <span>{{ $assignment->title }}</span>

                                            @if($daysLeft < 0)
                                                <span class="badge bg-secondary">Expired</span>
                                            @elseif($daysLeft === 0)
                                                <span class="badge bg-danger">Today</span>
                                            @elseif($daysLeft === 1)
                                                <span class="badge bg-danger">Tomorrow</span>
                                            @elseif($daysLeft <= 3)
                                                <span class="badge bg-warning text-dark">{{ $daysLeft }} Days</span>
                                            @else
                                                <span class="badge bg-info">
                                                    {{ \Carbon\Carbon::parse($assignment->deadline)->format('M d') }}
                                                </span>
                                            @endif
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted bg-transparent">
                                        No upcoming deadlines
                                    </li>
                                @endforelse
                            </ul>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection