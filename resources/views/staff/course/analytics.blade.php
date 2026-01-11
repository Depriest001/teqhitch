@extends('staffdashboardLayout')
@section('title','Course Analytics | Teqhitch ICT Academy LTD')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Course Analytics</h4>
            <p class="text-muted mb-0">Monitor course performance and student progress</p>
        </div>
        <button class="btn btn-outline-dark btn-sm">
            <i class="bx bx-printer me-1"></i> Print
        </button>
    </div>

    <div class="row g-3">

        <!-- Course Summary -->
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 mt-3">
                <div class="card-body">
                    <div class="row g-3 text-center">

                        <div class="col-md-3 col-6">
                            <h6 class="fw-bold mb-1">Total Students</h6>
                            <p class="text-muted mb-0">85</p>
                        </div>

                        <div class="col-md-3 col-6">
                            <h6 class="fw-bold mb-1">Assignments</h6>
                            <p class="text-muted mb-0">6</p>
                        </div>

                        <div class="col-md-3 col-6">
                            <h6 class="fw-bold mb-1">Completed Modules</h6>
                            <p class="text-muted mb-0">8 / 12</p>
                        </div>

                        <div class="col-md-3 col-6">
                            <h6 class="fw-bold mb-1">Average Grade</h6>
                            <p class="text-muted mb-0">87%</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Students Performance Chart -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0">
                    <h6 class="fw-bold mb-0">Student Performance</h6>
                </div>
                <div class="card-body">
                    <canvas id="studentPerformanceChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Assignment Stats -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0">
                    <h6 class="fw-bold mb-0">Assignment Stats</h6>
                </div>
                <div class="card-body">
                    <canvas id="assignmentStatsChart" height="250"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Students Performance (Line Chart)
    const ctx1 = document.getElementById('studentPerformanceChart').getContext('2d');
    const studentPerformanceChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'],
            datasets: [{
                label: 'Average Score (%)',
                data: [75, 80, 78, 85, 90, 87],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                tension: 0.3,
                fill: true,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, position: 'top' },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: { beginAtZero: true, max: 100 },
                x: { grid: { display: false } }
            }
        }
    });

    // Assignment Stats (Bar Chart)
    const ctx2 = document.getElementById('assignmentStatsChart').getContext('2d');
    const assignmentStatsChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Assignment 1', 'Assignment 2', 'Assignment 3', 'Assignment 4', 'Assignment 5'],
            datasets: [{
                label: 'Submitted (%)',
                data: [100, 95, 80, 90, 85],
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: { beginAtZero: true, max: 100, title: { display: true, text: 'Submission (%)' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>

@endsection
