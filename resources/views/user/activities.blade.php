@extends('userdashboardLayout')
@section('title','Activities | Teqhitch ICT Academy LTD')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Activities</h4>
            <p class="text-muted mb-0">Track your learning journey, submissions and achievements</p>
        </div>
        <button class="btn btn-dark btn-sm">
            <i class="bx bx-refresh me-1"></i> Refresh
        </button>
    </div>

    <!-- Filters -->
    <div class="mb-4">
        <ul class="nav nav-pills flex-nowrap overflow-auto">
            <li class="nav-item">
                <a class="nav-link active" href="#">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Assignments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Certificates</a>
            </li>
        </ul>
    </div>

    <!-- Timeline -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <!-- Today -->
            <h6 class="text-uppercase text-muted small mb-3">Today</h6>

            <div class="timeline-item mb-4 d-flex">
                <div class="me-3">
                    <span class="badge bg-primary rounded-circle p-3">
                        <i class="bx bx-book-open"></i>
                    </span>
                </div>
                <div>
                    <h6 class="mb-1">You continued “Web Development Fundamentals”</h6>
                    <p class="text-muted small mb-1">Progress updated to 65%</p>
                    <span class="badge bg-light text-dark">Course</span>
                    <span class="text-muted small ms-2">2 mins ago</span>
                </div>
            </div>

            <div class="timeline-item mb-4 d-flex">
                <div class="me-3">
                    <span class="badge bg-success rounded-circle p-3">
                        <i class="bx bx-upload"></i>
                    </span>
                </div>
                <div>
                    <h6 class="mb-1">Assignment Submitted</h6>
                    <p class="text-muted small mb-1">Intro to HTML — Assignment 1</p>
                    <span class="badge bg-light text-dark">Assignment</span>
                    <span class="text-muted small ms-2">1 hr ago</span>
                </div>
            </div>

            <!-- This Week -->
            <h6 class="text-uppercase text-muted small mb-3 mt-4">This Week</h6>

            <div class="timeline-item mb-4 d-flex">
                <div class="me-3">
                    <span class="badge bg-warning rounded-circle p-3">
                        <i class="bx bx-award"></i>
                    </span>
                </div>
                <div>
                    <h6 class="mb-1">You earned a Certificate</h6>
                    <p class="text-muted small mb-1">UI/UX Beginner Track</p>
                    <span class="badge bg-light text-dark">Achievement</span>
                    <span class="text-muted small ms-2">3 days ago</span>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
