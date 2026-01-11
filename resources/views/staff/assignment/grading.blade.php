@extends('staffdashboardLayout')
@section('title','Grade Submission | Teqhitch ICT Academy LTD')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Student Submission</h4>

        <a href="{{ route('staff.assignment.show', $assignment->id) }}" class="btn btn-sm btn-outline-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="row g-4">

        <!-- Student & Assignment Info -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h6 class="fw-bold mb-3">Student Info</h6>

                    <div class="mb-3">
                        <p class="mb-1"><strong>Name:</strong> {{ $student->name }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ $student->email }}</p>

                        <p class="mb-1">
                            <strong>Status:</strong>
                            @if($submission->score !== null)
                                <span class="badge bg-success">Graded</span>
                            @else
                                <span class="badge bg-info">Submitted</span>
                            @endif
                        </p>

                        <p class="mb-1">
                            <strong>Submitted On:</strong>
                            {{ $submission->submitted_at->format('M d, Y') }}
                        </p>
                    </div>

                    <hr>

                    <h6 class="fw-bold mb-2">Assignment</h6>
                    <p class="mb-1"><strong>Title:</strong> {{ $assignment->title }}</p>
                    <p class="mb-1"><strong>Total Marks:</strong> {{ $assignment->max_score }}</p>

                </div>
            </div>
        </div>

        <!-- Submission Content -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <!-- Document Preview -->
                    <h6 class="fw-bold mb-3">Submitted Document</h6>

                    <div class="border rounded overflow-hidden mb-4" style="height: 450px;">
                        @if($submission->file_path)
                            <iframe
                                src="{{ asset('storage/' . $submission->file_path) }}"
                                width="100%"
                                height="100%"
                                style="border:0;"
                            ></iframe>

                            <div class="text-end mt-3">
                                <a href="{{ asset('storage/' . $submission->file_path) }}"
                                target="_blank"
                                class="btn btn-outline-primary">
                                    <i class="bx bx-download"></i> Download File
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Grading Section -->
                    <h6 class="fw-bold mb-3">Instructor Grading</h6>

                    <form method="POST"
                        action="{{ route('staff.assignment.grade.store', [$assignment, $submission]) }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Marks Awarded</label>
                                <input type="number"
                                    name="score"
                                    class="form-control"
                                    value="{{ old('score', $submission->score) }}"
                                    max="{{ $assignment->max_score }}"
                                    required>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Feedback</label>
                                <textarea
                                    name="feedback"
                                    rows="3"
                                    class="form-control">{{ old('feedback', $submission->feedback) }}</textarea>
                            </div>

                            <div class="col-12 text-end">
                                <button class="btn btn-primary">
                                    <i class="bx bx-check"></i> Submit Grade
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection