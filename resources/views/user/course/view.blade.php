@extends('userdashboardLayout')
@section('title','Available Courses | Teqhitch ICT Academy LTD')
@section('content')
<div class="container py-5">
    <h4 class="mb-4">Available Courses</h4>
    <div class="row g-4">
        @forelse($courses as $course)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                @if($course->thumbnail)
                <img src="{{ asset('storage/' . $course->thumbnail) }}" class="card-img-top" alt="{{ $course->title }}">
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
