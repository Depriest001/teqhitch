@extends('admindashboardLayout')
@section('title','Course Details | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl container-p-y">
    
    @if (session('success') || session('error') || $errors->any())
        <div id="appToast"
            class="bs-toast toast fade show position-fixed top-0 end-0 m-3
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

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">{{ $course->title }}</h4>
            <small class="text-muted">Course Overview & Management</small>
        </div>

        <div class="text-end">
            <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-warning mb-2 mb-md-0">
                <i class="bx bx-edit"></i> Edit
            </a>

            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- LEFT PANEL --}}
        <div class="col-lg-4">

            <div class="card shadow-sm">

                {{-- Thumbnail --}}
                <img src="{{ $course->thumbnail 
                    ? asset('uploads/'.$course->thumbnail) 
                    : 'https://images.unsplash.com/photo-1555066931-4365d14bab8c' }}"
                    class="card-img-top"
                    style="height:200px; object-fit:cover;"
                    alt="Thumbnail">

                <div class="card-body text-center">

                    <h5 class="fw-bold"><i class="{{ $course->icon }} me-2"></i>{{ $course->title }}</h5>
                    <p class="text-muted mb-1">
                        Instructor: {{ $course->instructor->name ?? 'Not Assigned' }}
                    </p>

                    <span class="badge 
                        @if($course->status === 'published') bg-success
                        @elseif($course->status === 'draft') bg-warning
                        @else bg-secondary @endif">
                        {{ ucfirst($course->status) }}
                    </span>

                    <hr>

                    {{-- Quick Stats --}}
                    <div class="row text-center">
                        <div class="col-4">
                            <h6 class="mb-0">{{ $course->students_count }}</h6>
                            <small>Students</small>
                        </div>
                        <div class="col-4">
                            <h6 class="mb-0">{{ $course->modules_count }}</h6>
                            <small>Modules</small>
                        </div>
                        <div class="col-4">
                            @php
                                $totalAssignments = $course->modules->sum('assignments_count');
                            @endphp
                            <h6 class="mb-0">{{ $totalAssignments }}</h6>
                            <small>Assignments</small>
                        </div>
                    </div>

                    <hr>

                    <p class="text-start">
                        <strong>Duration:</strong> {{ $course->duration ?? '—' }} <br>
                        <strong>Price:</strong> ₦{{ number_format($course->price,2) ?? '0.00' }} <br>
                        <strong>Created:</strong> {{ $course->created_at->format('M d, Y') }}
                    </p>
                    <form method="POST" action="{{ route('admin.courses.toggleStatus', $course->id) }}">
                        @csrf
                        @method('PATCH')
                        <button onclick="return confirm('You are about to change course status?')" class="btn {{ $course->status === 'draft' ? 'btn-success' : 'btn-info' }}">
                            <i class="bx bx-toggle-right"></i> {{ $course->status === 'draft' ? 'Publish' : 'Draft' }}
                        </button>
                    </form>

                </div>
            </div>
        </div>

        {{-- RIGHT PANEL --}}
        <div class="col-lg-8">

            {{-- Description --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-2">Course Description</h5>
                    <div>{!! $course->description !!}</div>
                </div>
                <div class="card-body">
                    <h5 class="fw-bold mb-2">Course Overview</h5>
                    <div>{!! $course->overview !!}</div>
                </div>
            </div>
            
            {{-- Features --}}
            @if($course->features->count())
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Course Features</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($course->features as $feature)
                            <li class="list-group-item">
                                <strong>{{ $feature->title }}</strong><br>
                                <small class="text-muted">{{ $feature->description }}</small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            {{-- Outcomes --}}
            @if($course->outcomes->count())
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Learning Outcomes</h5>
                    <ul>
                        @foreach($course->outcomes as $outcome)
                            <li>{{ $outcome->content }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            {{-- Enrolled Students --}}
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Enrolled Students</h5>

                    @if($course->enrollments->count())
                        <ul class="list-group">
                            @foreach($course->enrollments as $enroll)
                                <li class="list-group-item d-flex justify-content-between">
                                    {{ $enroll->student->name ?? 'Unknown' }}
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
</div>
@endsection