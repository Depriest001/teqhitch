@extends('userdashboardLayout')
@section('title','Certificates | Teqhitch ICT Academy LTD')
@section('content')
<style>
.certificate-card{
    border-radius: 14px;
    transition: .2s;
}
.certificate-card:hover{
    transform: translateY(-3px);
}
.certificate-badge{
    display:inline-block;
    padding:6px 12px;
    border-radius:50px;
    font-size:12px;
    font-weight:600;
}
.locked-overlay{
    position:absolute;
    top: 50%;
    left:50%;
    transform:translate(-50%,-50%);
    background:#000000c9;
    color:#fff;
    border-radius:50%;
    width:55px;
    height:55px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:25px;
}
</style>
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Certificates</h4>
            <p class="text-muted mb-0">
                View and download certificates earned from completed courses
            </p>
        </div>
    </div>

    <!-- Certificates Section -->
    <div class="row g-4">

        <!-- Earned Certificate -->
        <div class="col-md-6 col-lg-4">
            <div class="card certificate-card shadow-sm border-0 h-100">
                <div class="card-body">

                    <div class="certificate-badge bg-success-subtle text-success mb-3">
                        <i class="bx bx-check-circle me-1"></i> Earned
                    </div>

                    <div class="certificate-preview border rounded p-2 mb-3">
                        <img src="https://dummyimage.com/600x400/e0e0e0/000&text=Certificate+Preview"
                             class="img-fluid rounded" alt="">
                    </div>

                    <h6 class="fw-bold mb-1">
                        Web Development Fundamentals
                    </h6>

                    <p class="text-muted small mb-2">
                        Awarded on: March 08, 2025
                    </p>

                    <p class="small text-muted mb-3">
                        Successfully completed course requirements and assessments.
                    </p>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-outline-dark btn-sm">
                            <i class="bx bx-show me-1"></i> View
                        </button>
                        <button class="btn btn-dark btn-sm">
                            <i class="bx bx-download me-1"></i> Download
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Earned Certificate -->
        <div class="col-md-6 col-lg-4">
            <div class="card certificate-card shadow-sm border-0 h-100">
                <div class="card-body">

                    <div class="certificate-badge bg-success-subtle text-success mb-3">
                        <i class="bx bx-check-circle me-1"></i> Earned
                    </div>

                    <div class="certificate-preview border rounded p-2 mb-3">
                        <img src="https://dummyimage.com/600x400/d9d9d9/000&text=Certificate+Preview"
                             class="img-fluid rounded" alt="">
                    </div>

                    <h6 class="fw-bold mb-1">
                        Data Analysis Essentials
                    </h6>

                    <p class="text-muted small mb-2">
                        Awarded on: February 21, 2025
                    </p>

                    <p class="small text-muted mb-3">
                        Demonstrated strong understanding of analytical techniques.
                    </p>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-outline-dark btn-sm">
                            <i class="bx bx-show me-1"></i> View
                        </button>
                        <button class="btn btn-dark btn-sm">
                            <i class="bx bx-download me-1"></i> Download
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Not Earned Yet -->
        <div class="col-md-6 col-lg-4">
            <div class="card certificate-card shadow-sm border-0 h-100">
                <div class="card-body">

                    <div class="certificate-badge bg-warning-subtle text-warning mb-3">
                        <i class="bx bx-time me-1"></i> In Progress
                    </div>

                    <div class="certificate-preview border rounded p-2 mb-3 position-relative">
                        <img src="https://dummyimage.com/600x400/f0f0f0/000&text=Locked+Certificate"
                             class="img-fluid rounded opacity-75" alt="">
                        <span class="locked-overlay">
                            <i class="bx bx-lock-alt"></i>
                        </span>
                    </div>

                    <h6 class="fw-bold mb-1">
                        Advanced Cybersecurity
                    </h6>

                    <p class="text-muted small mb-2">
                        Certificate will be available after completion
                    </p>

                    <p class="small text-muted">
                        Progress: 65%
                    </p>

                    <button class="btn btn-outline-dark btn-sm w-100">
                        Continue Course
                    </button>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection
