@extends('userdashboardLayout')
@section('title','User Dashboard | Teqhitch ICT Academy LTD')
@section('content')

<style>
.course-card{
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.course-card:hover{
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
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
    <h4 class="fw-bold py-3 mb-4">My Courses</h4>

    <div class="row g-4">

        @forelse ($enrollments as $enrollment)
            <div class="col-md-4">
                <div class="card h-100 course-card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">{{ $enrollment->course->title }}</h5>

                        <p class="card-text text-secondary">
                            {{ Str::limit(strip_tags($enrollment->course->description), 120) ?? 'No description available' }}
                        </p>

                        <div class="progress mb-2" style="height:6px;">
                            <div
                                class="progress-bar
                                {{ $enrollment->progress < 50 ? 'bg-danger' :
                                ($enrollment->progress < 80 ? 'bg-warning' : 'bg-success') }}"
                                style="width: {{ $enrollment->progress }}%">
                            </div>
                        </div>

                        <small>{{ $enrollment->progress }}% Completed</small>

                        <div class="mt-3">
                            <a href="{{ route('user.courses.show', $enrollment->course->id) }}"
                            class="btn btn-primary btn-sm">
                                Continue
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">You have not enrolled in any course yet.</p>
            </div>
        @endforelse

    </div>

</div>

@endsection