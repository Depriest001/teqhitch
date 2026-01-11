@extends('userdashboardLayout')

@section('title', $assignment->title.' | Teqhitch ICT Academy LTD')

@section('content')
<style>
.assignment-header{
    background: linear-gradient(135deg,#99FFEE,#19DDFF);
    border-radius: 16px;
    color: #b3afafff;
}
.info-card{
    border-radius: 16px;
}
.file-box{
    background: #f8fafc;
    border: 1px dashed #cbd5f5;
    border-radius: 12px;
    padding: 1rem;
}
</style>

<div class="container-xxl container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between assignment-header p-4 mb-4 shadow-sm">
        <div class="col-lg-8">
            <h4 class="fw-bold mb-1">{{ $assignment->title }}</h4>
            <p class="mb-0 opacity-75">
                {{ $assignment->course->title }}
            </p>
        </div>
        <div class="">
            <a class="btn rounded-pill btn-outline-secondary" href=" {{ route('user.assignment.index') }} ">
                Go back
            </a>
        </div>
        
    </div>

    <div class="row g-4">

        <!-- LEFT: ASSIGNMENT INFO -->
        <div class="col-lg-7">
            <div class="card info-card shadow-sm border-0 p-4 h-100">
                <h5 class="fw-semibold mb-3">Assignment Overview</h5>

                <p class="text-muted">
                    {{ $assignment->instructions }}
                </p>

                <hr>

                <div class="row small text-muted">
                    <div class="col-md-4">
                        <strong>Due Date</strong><br>
                        {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y') }}
                    </div>
                    <div class="col-md-4">
                        <strong>Maximum Score</strong><br>
                        {{ $assignment->max_score }} points
                    </div>
                    <div class="col-md-4">
                        <strong>Status</strong><br>

                        @if(!$submission)
                            <span class="rounded-pill py-1 px-2 mt-2 bg-warning text-dark">Not Submitted</span>
                        @elseif($submission->graded_at)
                            <span class="rounded-pill py-1 px-2 mt-2 bg-success">Graded</span>
                        @else
                            <span class="rounded-pill py-1 px-2 mt-2 bg-info">Submitted</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: SUBMISSION PANEL -->
        <div class="col-lg-5">
            <div class="card info-card shadow-sm border-0 p-4 h-100">
                <h5 class="fw-semibold mb-3">Your Submission</h5>

                @if(!$submission)
                    <!-- NOT SUBMITTED -->
                    <p class="text-muted">
                        You haven’t submitted this assignment yet.
                    </p>

                    @if(now()->lte($assignment->deadline))
                        <button
                            class="btn btn-primary rounded-pill px-4"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#submitAssignment">
                            Submit Assignment
                        </button>
                    @else
                        <div class="alert alert-danger small">
                            Submission deadline has passed.
                        </div>
                    @endif

                @else
                    <!-- SUBMITTED -->
                    <div class="file-box mb-3">
                        <p class="mb-1 fw-medium">
                            {{ basename($submission->file_path) }}
                        </p>
                        <small class="text-muted">
                            Submitted on
                            {{ \Carbon\Carbon::parse($submission->submitted_at)->format('d M Y, h:i A') }}
                        </small>
                    </div>

                    <a href="{{ asset('storage/'.$submission->file_path) }}"
                       target="_blank"
                       class="btn btn-outline-primary btn-sm rounded-pill">
                        Download File
                    </a>

                    @if($submission->graded_at)
                        <hr>

                        <button class="btn btn-success btn-sm rounded-pill mt-2"
                                data-bs-toggle="modal"
                                data-bs-target="#viewGradeModal">
                            View Grade
                        </button>
                    @endif

                @endif
            </div>
        </div>
    </div>
</div>

<!-- SUBMISSION OFFCANVAS -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="submitAssignment">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Submit Assignment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form method="POST"
              action="{{ route('user.assignment.store') }}"
              enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">

            <div class="mb-3">
                <label class="form-label fw-medium">Upload File</label>
                <input type="file"
                       class="form-control"
                       name="file"
                       required>
                <small class="text-muted">
                    Accepted formats: PDF, DOCX, ZIP
                </small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-medium">Notes (optional)</label>
                <textarea class="form-control"
                          name="notes"
                          rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-success w-100 rounded-pill">
                Submit Assignment
            </button>
        </form>
    </div>
</div>

@if($submission && $submission->graded_at)
<div class="modal fade" id="viewGradeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title">Assignment Grade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <strong>Score</strong>
                    <p class="mb-0">
                        {{ $submission->score }} / {{ $assignment->max_score }}
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Feedback</strong>
                    <p class="text-muted mb-0">
                        {{ $submission->feedback ?? 'No feedback provided.' }}
                    </p>
                </div>

                <div class="small text-muted">
                    Graded on
                    {{ \Carbon\Carbon::parse($submission->graded_at)->format('d M Y, h:i A') }}
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary rounded-pill"
                        data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@endsection