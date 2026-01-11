@extends('userdashboardLayout')
@section('title','View Grade | Teqhitch ICT Academy LTD')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Assignment Grade</h4>
    <div class="row g-4">

        <!-- Assignment Details Card -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">CSS Fundamentals Assignment</h5>
                    <p class="text-muted small mb-2">Due Date: 30 Dec 2025</p>
                    <p class="text-muted small mb-2">Submitted: 29 Dec 2025</p>
                    <p class="text-muted small mb-2">Submitted File: <a href="#">assignment-css.zip</a></p>
                    <p class="text-muted small mb-2">Notes: Styled the HTML page with colors, fonts, and layout.</p>
                </div>
            </div>
        </div>

        <!-- Grade Card -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 text-center p-4">
                <h5 class="card-title">Your Grade</h5>
                <div class="display-4 fw-bold my-3 text-primary">85%</div>
                <span class="badge bg-success rounded-pill mb-3">Passed</span>
                <p class="text-muted">Feedback from instructor: Great job! Your CSS implementation is clean and well-structured. Keep practicing for responsiveness.</p>
                <a href="#" class="btn btn-outline-primary btn-sm mt-3">Download Feedback</a>
            </div>
        </div>

    </div>

    <!-- Teacher Feedback Section -->
    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 p-4">
                <h5 class="mb-3">Teacher Feedback</h5>
                <p class="text-muted">Great job! Your HTML structure is correct, and the webpage renders as expected. Make sure to follow semantic HTML best practices for future assignments.</p>
                <p class="text-muted"><strong>Grade:</strong> 95/100</p>
            </div>
        </div>
    </div>

</div>

@endsection
