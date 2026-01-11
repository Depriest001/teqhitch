@extends('admindashboardLayout') 
@section('title','View Student | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Toast Messages --}}
    @if (session('success') || session('error') || $errors->any())
        <div id="appToast"
            class="bs-toast toast fade show position-fixed bottom-0 end-0 m-3
            {{ session('success') ? 'bg-success' : (session('error') ? 'bg-danger' : 'bg-warning') }}"
            role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header text-white">
                <i class="icon-base bx bx-bell me-2"></i>
                <div class="me-auto fw-medium">
                @if (session('success')) Success
                @elseif (session('error')) Error
                @else Validation @endif
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body text-white">
                @if (session('success')) {{ session('success') }}
                @elseif (session('error')) {{ session('error') }}
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
            <h4 class="fw-bold">Student Details</h4>
            <span class="text-muted">View detailed student information</span>
        </div>
        <a href="{{ route('admin.student.index') }}" class="btn btn-sm btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="row g-4">

        {{-- Profile Card --}}
        <div class="col-md-4">
            <div class="card shadow-sm p-3 text-center">
                <img src="{{ asset('assets/img/user/icon-male.png') }}" class="rounded-circle mx-auto mb-3" width="130">
                <h5 class="mb-0">{{ $student->name }}</h5>
                <span class="text-muted">{{ $student->status }}</span>

                <hr>

                <div class="text-start">
                    <p><i class="bx bx-envelope"></i> {{ $student->email }}</p>
                    <p><i class="bx bx-phone"></i> Phone: {{ $student->phone ?? 'N/A' }}</p>
                    <p><i class="bx bx-calendar"></i> Joined: {{ $student->created_at->format('M d, Y') }}</p>
                </div>

                <hr>

                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('admin.student.edit', $student) }}" class="btn btn-warning">
                        <i class="bx bx-edit"></i> Edit
                    </a>
                    @if($student->status !== 'Deleted')
                        <form action="{{ route('admin.student.suspend', $student) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to suspend this student?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger">
                                <i class="bx bx-block"></i> Suspend
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Courses & Activities --}}
        <div class="col-md-8">

            {{-- ACCOUNT INFORMATION --}}
            <div class="card shadow-sm p-3 mb-4">
                <h5 class="fw-bold mb-3">Account Information</h5>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Full Name:</strong> {{ $student->name }}</p>
                        <p><strong>Phone Number:</strong> {{ $student->phone ?? 'N/A' }}</p>
                        <p><strong>Role:</strong> {{ ucfirst($student->role) }}</p>
                    </div>

                    <div class="col-md-6">
                        <p><strong>Address:</strong> {{ $student->StudentProfile->address ?? 'No Address Yet' }}</p>
                        <p><strong>Institution:</strong>{{ $student->StudentProfile->institution ?? 'N/A' }}</strong></p>
                    </div>
                </div>
            </div>

            {{-- Enrolled Courses --}}
            <div class="card shadow-sm p-3 mb-4">
                <h5 class="fw-bold mb-3">Enrolled Courses</h5>
                <ul class="list-group">
                    @forelse($student->courses ?? [] as $course)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $course->title }}
                            <span class="badge bg-{{ $course->status == 'Active' ? 'success' : 'warning' }}">
                                {{ $course->status }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No courses enrolled</li>
                    @endforelse
                </ul>
            </div>

            {{-- Recent Activities --}}
            <div class="card shadow-sm p-3">
                <h5 class="fw-bold mb-3">Recent Activities</h5>
                <ul class="list-group">
                    @forelse($student->activities ?? [] as $activity)
                        <li class="list-group-item">
                            {{ $activity->description }}
                            <span class="float-end text-muted">{{ $activity->created_at->diffForHumans() }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No recent activity</li>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection
