@extends('userdashboardLayout')
@section('title','Available Courses | Teqhitch ICT Academy LTD')
@section('content')
<div class="container py-5">
    @if (session('success') || session('info') || $errors->any())
        <div id="appToast"
            class="bs-toast toast fade show position-fixed top-0 end-0 m-3
            {{ session('success') ? 'bg-success' : (session('info') ? 'bg-warning' : 'bg-danger') }}"
            role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header text-white">
                <i class="icon-base bx bx-bell me-2"></i>
                <div class="me-auto fw-medium">
                @if (session('success'))
                    Success
                @elseif (session('info'))
                    info
                @else
                    Validation
                @endif
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>

            <div class="toast-body text-white">
                @if (session('success'))
                {{ session('success') }}
                @elseif (session('info'))
                {{ session('info') }}
                @endif
            </div>
        </div>
    @endif
    <h4 class="mb-4">Available Courses</h4>
    <div class="row g-4">
        @forelse($courses as $course)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                @if($course->thumbnail)
                <img src="{{ asset('uploads/'.$course->thumbnail) }}" class="card-img-top" alt="{{ $course->title }}">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $course->title }}</h5>
                    <p class="card-text text-truncate">{{ Str::limit(strip_tags($course->description), 120) }}</p>
                    <p class="mt-auto"><strong>Price:</strong> ₦{{ number_format($course->price, 2) }}</p>
                    <p class="mt-auto"><strong>Duration:</strong> {{ $course->duration }}</p>
                    <a href="{{ route('user.course.buy', $course->id) }}" class="btn btn-primary w-100 mt-2">Buy Now</a>
                </div>
            </div>
        </div>
        @empty
        <p>No courses available at the moment.</p>
        @endforelse
    </div>
</div>
@endsection
