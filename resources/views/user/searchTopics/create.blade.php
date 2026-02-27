@extends('userdashboardLayout')
@section('title','Seminar/Project Topic Generator - Teqhitch ICT Academy LTD')

@section('content')

<style>
.hover-shadow:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    cursor: pointer;
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
    <!-- PAGE TITLE -->
    <h4 class="fw-bold py-3 mb-4 text-center">Generate Seminar / Project Topics</h4>

    <div class="row justify-content-center g-4">
        <div class="col-lg-10">

            {{-- GENERATOR CARD --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">

                    <div class="text-center mb-4">
                        <h5 class="fw-bold">Generate Topic</h5>
                        <p class="text-muted mb-0">
                            You have <strong>{{ $remaining }}</strong> free generation(s) left.
                        </p>
                    </div>

                    <form method="post" action="">
                        @csrf
                        <div class="row g-4">

                            {{-- Department --}}
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold">Department</label>
                                <select name="department" class="form-select" required>
                                    <option value="" selected disabled>Select Department</option>
                                    <option value="Computer Science">Computer Science</option>
                                </select>
                            </div>

                            {{-- Topic Type --}}
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold">Topic Type</label>
                                <select name="type" class="form-select" required>
                                    <option value="" selected disabled>Select Topic Type</option>
                                    <option value="seminar">Seminar</option>
                                    <option value="project">Project</option>
                                </select>
                            </div>

                            {{-- Level --}}
                            <div class="col-12 col-md-4">
                                <label class="form-label fw-semibold">Level</label>
                                <select name="level" class="form-select" required>
                                    <option value="" selected disabled>Select Level</option>
                                    <option value="BSc">B.Sc</option>
                                    <option value="MSc">M.Sc</option>
                                    <option value="PhD">Ph.D</option>
                                </select>
                            </div>

                            {{-- Keyword --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold">Focus Area <span class="text-muted">(optional)</span></label>
                                <input type="text" name="keyword" class="form-control" placeholder="e.g. Artificial Intelligence, Cyber Security">
                            </div>

                            {{-- Generate Button --}}
                            <div class="col-12 text-center mt-3">
                                <button class="btn btn-primary px-5">
                                    <i class="bx bx-bulb me-2"></i> Generate Topics
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

            {{-- RESULTS CARD --}}
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Generated Topics</h5>
                    @if(session('generatedTopics'))
                        <form action="{{ route('user.searchTopics.useMultiple') }}" method="POST">
                            @csrf

                            <ul class="list-group list-group-flush" style="font-size: 14px;">
                                @foreach(session('generatedTopics') as $topic)
                                    <li class="list-group-item border rounded mb-3 p-4 hover-shadow">

                                        <input type="hidden" name="topics[]" value="{{ $topic->id }}">

                                        <div class="mb-3">
                                            <h6 class="fw-semibold mb-1">{{ $topic->title }}</h6>
                                            <small class="text-muted">
                                                Focus: {{ $topic->description ?? 'N/A' }}
                                            </small>
                                        </div>

                                        <div class="row text-center align-items-center g-3" style="font-size: 12px;">
                                            <div class="col-6 col-md border-end">
                                                <div class="fw-semibold">{{ $topic->rating ?? '0.0' }} ★</div>
                                                <small class="text-muted">Rated</small>
                                            </div>

                                            <div class="col-6 col-md">
                                                <div class="fw-semibold">{{ $topic->used_count ?? 0 }}</div>
                                                <small class="text-muted">Used</small>
                                            </div>
                                        </div>

                                    </li>
                                @endforeach
                            </ul>

                            <div class="text-center mt-3">
                                <button class="btn btn-success px-4">
                                    <i class="bx bx-check-circle me-2"></i> Use These Topics
                                </button>
                            </div>
                        </form>
                    @else
                        <p class="text-center text-muted">
                            No topics generated yet.
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
