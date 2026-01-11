@extends('admindashboardLayout')
@section('title','Course Details | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Toast Notifications --}}
    @if (session('success') || session('error') || $errors->any())
        <div id="appToast"
             class="bs-toast toast fade show position-fixed bottom-0 end-0 m-3
             {{ session('success') ? 'bg-success' : (session('error') ? 'bg-danger' : 'bg-warning') }}"
             role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">

            <div class="toast-header text-white">
                <i class="bx bx-bell me-2"></i>
                <strong class="me-auto">
                    {{ session('success') ? 'Success' : (session('error') ? 'Error' : 'Validation') }}
                </strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>

            <div class="toast-body text-white">
                @if (session('success'))
                    {{ session('success') }}
                @elseif(session('error'))
                    {{ session('error') }}
                @elseif($errors->any())
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">{{ $course->title }}</h4>
            <span class="text-muted">Course Details</span>
        </div>

        <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="row g-4">

        {{-- Left Card --}}
        <div class="col-md-4">
            <div class="card shadow-sm p-3 text-center">

                {{-- Thumbnail --}}
                <img src="{{ $course->thumbnail ? asset('storage/'.$course->thumbnail) : 'https://images.unsplash.com/photo-1555066931-4365d14bab8c' }}"
                     class="card-img-top rounded"
                     style="height:180px; object-fit:cover;"
                     alt="Course Thumbnail">

                {{-- Title --}}
                <h5 class="mt-3 mb-0">{{ $course->title }}</h5>

                {{-- Instructor --}}
                <span class="text-muted">
                    Instructor: {{ $course->instructor->name ?? 'Unknown' }}
                </span>

                {{-- Status Badge --}}
                <div class="mt-3">
                    @if($course->status === 'published')
                        <span class="badge bg-success px-3">Published</span>
                    @elseif($course->status === 'draft')
                        <span class="badge bg-warning px-3">Draft</span>
                    @else
                        <span class="badge bg-secondary px-3">{{ ucfirst($course->status) }}</span>
                    @endif
                </div>

                <hr>

                {{-- Stats --}}
                <div class="text-start">
                    <p><i class="bx bx-user"></i> Enrolled Students:
                        {{ $course->students_count ?? $course->enrollments()->count() }}
                    </p>

                    <p><i class="bx bx-time"></i> Duration:
                        {{ $course->duration ?? '—' }}
                    </p>

                    <p><i class="bx bx-calendar"></i>
                        Created: {{ $course->created_at->format('M d, Y') }}
                    </p>
                </div>

                <hr>

                {{-- Actions --}}
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-warning">
                        <i class="bx bx-edit"></i> Edit
                    </a>

                    <form method="POST" action="{{ route('admin.courses.toggleStatus', $course->id) }}">
                        @csrf
                        @method('PATCH')
                        <button onclick="return confirm('You are about to change course status?')"
                                class="btn {{ $course->status === 'draft' ? 'btn-success' : 'btn-info' }}">
                            <i class="bx bx-toggle-right"></i>
                            {{ $course->status === 'draft' ? 'Publish' : 'Draft' }}
                        </button>
                    </form>
                </div>

            </div>
        </div>

        {{-- Right Section --}}
        <div class="col-md-8">

            {{-- Description --}}
            <div class="card shadow-sm p-3 mb-4">
                <h5 class="fw-bold mb-3">Course Description</h5>

                <p>{!! $course->description !!}</p>
            </div>

            {{-- Enrolled Students --}}
            <div class="card shadow-sm p-3">
                <h5 class="fw-bold mb-3">Enrolled Students</h5>

                @if($course->enrollments->count() > 0)
                    <ul class="list-group">
                        @foreach($course->enrollments as $enroll)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $enroll->student->name ?? 'Unknown Student' }}
                                <span class="badge bg-success">Active</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted mb-0">No students enrolled yet.</p>
                @endif
            </div>

        </div>
    </div>

</div>
@endsection
