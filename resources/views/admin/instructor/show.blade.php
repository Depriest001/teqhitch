@extends('admindashboardLayout')
@section('title','Instructor Details | Teqhitch ICT Academy LTD')

@section('content')
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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Instructor Details</h4>
            <span class="text-muted">View detailed instructor information</span>
        </div>

        <a href="{{ route('admin.instructor.index') }}" class="btn btn-sm btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="row g-4">

        {{-- ================= PROFILE CARD ================= --}}
        <div class="col-md-4">
            <div class="card shadow-sm p-3 text-center">

                <img src="{{ $instructor->profile_photo_url ?? asset('assets/img/user/icon-male.png') }}"
                     class="rounded-circle mx-auto mb-3"
                     width="130">

                <h5 class="mb-0">{{ $instructor->name }}</h5>

                <span class="badge 
                    {{ $instructor->status == 'active' ? 'bg-success' : 
                       ($instructor->status == 'suspended' ? 'bg-warning' : 'bg-danger') }}">
                    {{ ucfirst($instructor->status) }}
                </span>

                <hr>

                <div class="text-start">
                    <p><i class="bx bx-envelope"></i> {{ $instructor->email }}</p>
                    <p><i class="bx bx-calendar"></i> Joined:
                        {{ $instructor->created_at->format('M d, Y') }}
                    </p>
                    <p><i class="bx bx-book"></i> Courses:
                        {{ $instructor->courses_count ?? 0 }}
                    </p>
                </div>

                <hr>

                <div class="d-flex gap-2 justify-content-center">

                    <a href="{{ route('admin.instructor.edit', $instructor->id) }}"
                       class="btn btn-warning">
                        <i class="bx bx-edit"></i> Edit
                    </a>

                    @if($student->status !== 'Deleted')
                    <form action="{{ route('admin.instructor.suspend', $instructor->id) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to suspend this instructor?');">
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


        {{-- ================= RIGHT SIDE ================= --}}
        <div class="col-md-8">

            {{-- ACCOUNT INFORMATION --}}
            <div class="card shadow-sm p-3 mb-4">
                <h5 class="fw-bold mb-3">Account Information</h5>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Full Name:</strong> {{ $instructor->name }}</p>
                        <p><strong>Phone Number:</strong> {{ $instructor->phone ?? 'N/A' }}</p>
                        <p><strong>Role:</strong> {{ ucfirst($instructor->role) }}</p>
                    </div>

                    <div class="col-md-6">
                        <p><strong>Bio:</strong> {{ $instructor->instructorProfile->bio ?? 'No Bio Yet' }}</p>
                        <p><strong>Qualification:</strong>{{ $instructor->instructorProfile->qualification ?? 'N/A' }}</strong></p>
                    </div>
                </div>
            </div>


            {{-- COURSES --}}
            <div class="card shadow-sm p-3">
                <h5 class="fw-bold mb-3">Courses Assigned</h5>

                @if(isset($courses) && $courses->count())
                    <ul class="list-group">
                        @foreach($courses as $course)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $course->title }}
                                <span class="badge
                                    {{ $course->status == 'active' ? 'bg-success' :
                                       ($course->status == 'draft' ? 'bg-warning' : 'bg-danger') }}">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No courses assigned yet.</p>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
