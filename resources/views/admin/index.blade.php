@extends('admindashboardLayout')
@section('title','Admin Dashboard | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- TOP SECTION --}}
    <div class=" mb-4">
        <h4 class="fw-bold">Dashboard Overview</h4>
    </div>

    {{-- STAT CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <i class="bx bx-user fs-2 text-primary"></i>
                    <h6 class="mt-2 mb-1">Total Students</h6>
                    <h4 class="fw-bold">{{ $totalStudents }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <i class="bx bx-user-voice fs-2 text-info"></i>
                    <h6 class="mt-2 mb-1">Instructors</h6>
                    <h4 class="fw-bold">{{ $totalInstructors }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <i class="bx bx-book-open fs-2 text-success"></i>
                    <h6 class="mt-2 mb-1">Courses</h6>
                    <h4 class="fw-bold">{{ $totalCourses }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <i class="bx bx-credit-card fs-2 text-warning"></i>
                    <h6 class="mt-2 mb-1">Earnings</h6>
                    <h4 class="fw-bold">₦{{ number_format($totalEarnings) }}</h4>
                </div>
            </div>
        </div>

    </div>

    {{-- ANALYTICS + RECENT ACTIVITIES --}}
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 p-2">
                    <h6 class="fw-bold">Earnings (Last 12 Months)</h6>
                    <div id="earningsChart"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-0 p-2">
                    <h6 class="fw-bold">Enrollments Trend</h6>
                    <div id="enrollmentChart"></div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white border-0">
                    <h6 class="fw-bold mb-0">Recent Activities</h6>
                </div>

                <div class="card-body">
                    @forelse($activities as $log)
                        <div class="d-flex align-items-start mb-3">
                            <span class="badge bg-dark p-2 me-3">
                                <i class="bx bx-activity"></i>
                            </span>
                            <div>
                                <p class="mb-1 fw-bold small">
                                    {{ $log->action }}
                                </p>
                                <small class="text-muted">
                                    {{ $log->module }} —
                                    {{ $log->created_at->diffForHumans() }}
                                </small><br>
                                <small class="text-muted">
                                    @if($log->user)
                                        By: {{ $log->user->name }}
                                    @else
                                        System
                                    @endif
                                </small>
                            </div>
                        </div>
                    @empty
                        <small class="text-muted">No recent activities</small>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 table-card mb-">
                <h6 class="fw-bold mb-3">Recent Enrollments</h6>
                <table class="table">
                    @forelse($recentEnrollments as $enroll)
                    <tr>
                        <td><b>{{ $enroll->student->name ?? 'N/A' }}</b></td>
                        <td>{{ $enroll->course->title ?? 'N/A' }}</td>
                        <td>
                            <span class="badge 
                                @if($enroll->status=='active') bg-success
                                @elseif($enroll->status=='pending') bg-warning
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($enroll->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">No enrollments yet</td>
                    </tr>
                    @endforelse
                </table>

            </div>
        </div>
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h6 class="fw-bold mb-0">System Performance</h6>
                </div>
                <div class="card-body">
                    <p class="mb-1">CPU Usage</p>
                    <div class="progress mb-2 ">
                        <div class="progress-bar bg-danger p-1" style="width: {{ $cpu }}%">
                            {{ $cpu }}%
                        </div>
                    </div>

                    <p class="mb-1">RAM Usage</p>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-warning p-1" style="width: {{ $ram }}%">
                            {{ $ram }}%
                        </div>
                    </div>

                    <p class="mb-1">Server Uptime</p>
                    <span class="badge bg-success">{{ $serverUptime }}</span>
                </div>
            </div>

        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
var months = @json($months);
var earningsData = @json($earningsData);
var enrollmentData = @json($enrollmentData);

// Earnings
var earningsChart = new ApexCharts(document.querySelector("#earningsChart"), {
    chart:{ type:"bar", height:350 },
    series:[{ name:"Earnings", data:earningsData }],
    xaxis:{ categories:months },
    colors:["#28a745"],
    dataLabels:{ enabled:false },
    tooltip:{ y:{ formatter:(v)=>"₦" + v.toLocaleString() } }
});
earningsChart.render();

// Enrollments
var enrollmentChart = new ApexCharts(document.querySelector("#enrollmentChart"), {
    chart:{ type:"line", height:350 },
    series:[{ name:"Enrollments", data:enrollmentData }],
    xaxis:{ categories:months },
    stroke:{ curve:"smooth", width:3 },
    colors:["#007bff"]
});
enrollmentChart.render();
</script>
@endsection
