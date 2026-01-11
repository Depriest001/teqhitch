@extends('userdashboardLayout')
@section('title','Assignments | Teqhitch ICT Academy LTD')
@section('content')
<style>
.assignment-card{
    border-radius: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.assignment-card:hover{
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}
.badge{
    font-size: 0.8rem;
    border-radius: 12px;
    padding: 0.4em 0.7em;
}
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    
    @if (session('success') || session('error') || $errors->any())
        <div id="appToast"
            class="bs-toast toast fade show position-fixed bottom-0 end-0 m-3
            {{ session('success') ? 'bg-success' : (session('error') ? 'bg-danger' : 'bg-warning') }}"
            role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header text-white">
                <i class="icon-base bx bx-bell me-2"></i>
                <div class="me-auto fw-medium">
                @if (session('success'))
                    Success
                @elseif (session('error'))
                    Error
                @else
                    Validation
                @endif
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>

            <div class="toast-body text-white">
                @if (session('success'))
                {{ session('success') }}
                @elseif (session('error'))
                {{ session('error') }}
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
    <h4 class="fw-bold py-3 mb-4">Assignments</h4>

    <!-- Assignments Table/Card List -->
    <div class="row g-4">

        @forelse ($assignments as $assignment)

        @php
            $submission = $assignment->submissions->first();

            if (!$submission) {
                $status = 'Pending';
                $badge  = 'bg-info';
            } elseif ($submission && !$submission->graded_at) {
                $status = 'Submitted';
                $badge  = 'bg-warning';
            } else {
                $status = 'Graded';
                $badge  = 'bg-success';
            }
        @endphp

        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 assignment-card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $assignment->title }}</h5>

                    <p class="text-muted small mb-2">
                        Course: {{ $assignment->course->title }} <br>
                        Due: {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y') }}
                    </p>

                    <span class="badge {{ $badge }} mb-3">{{ $status }}</span>

                    <p class="text-muted small">
                        {{ Str::limit($assignment->instructions, 120) }}
                    </p>

                    {{-- ACTIONS --}}
                    @if ($status === 'Pending')
                        <button class="btn btn-primary btn-sm mt-2"
                                data-bs-toggle="offcanvas"
                                data-bs-target="#submitAssignment{{ $assignment->id }}">
                            Submit
                        </button>
                    @elseif ($status === 'Submitted')
                        <a href="{{ route('user.assignment.show', $assignment->id) }}"
                        class="btn btn-outline-secondary btn-sm mt-2">
                            View Submission
                        </a>
                    @else
                        <a href="#" class="btn btn-outline-success btn-sm mt-2">
                            View Grade ({{ $submission->score }}/{{ $assignment->max_score }})
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- OFFCANVAS --}}
        <div class="offcanvas offcanvas-end"
            tabindex="-1"
            id="submitAssignment{{ $assignment->id }}">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Submit Assignment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <form method="POST"
                    action="{{ route('user.assignment.store', $assignment->id) }}"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="hidden"
                        name="assignment_id"
                        value="{{ $assignment->id }}">

                    <div class="mb-3">
                        <label class="form-label">Upload File</label>
                        <input class="form-control" type="file" name="file" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">
                        Submit Assignment
                    </button>
                </form>
            </div>
        </div>

        @empty
        <div class="col-12 text-center text-muted">
            No assignments available.
        </div>
        @endforelse

    </div>

</div>

<!-- Offcanvas -->
<!-- <div class="offcanvas offcanvas-end" tabindex="-1" id="submitAssignment" aria-labelledby="submitAssignmentLabel">
    <div class="offcanvas-header">
        <h5 id="submitAssignmentLabel" class="offcanvas-title">Submit Assignment</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form enctype="multipart/form-data">
            <div class="mb-3">
                <label for="assignmentFile" class="form-label">Upload File</label>
                <input class="form-control" type="file" accept="application/*" id="assignmentFile">
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">Notes / Comments</label>
                <textarea class="form-control" id="notes" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit Assignment</button>
        </form>
    </div>
</div> -->

@endsection