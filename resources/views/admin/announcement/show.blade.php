@extends('admindashboardLayout')
@section('title','Announcement Details | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Announcement Details</h4>
            <span class="text-muted">View detailed announcement information</span>
        </div>

        <a href="{{ route('admin.announcement.index') }}" class="btn btn-sm btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="row g-4">

        <!-- Announcement Card -->
        <div class="col-md-12">
            <div class="card shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold">{{ $announcement->title }}</h5>

                    @if($announcement->status === 'published')
                        <span class="badge bg-success">Published</span>
                    @elseif($announcement->status === 'draft')
                        <span class="badge bg-warning">Draft</span>
                    @else
                        <span class="badge bg-danger">Deleted</span>
                    @endif
                </div>

                <p class="text-muted"><i class="bx bx-calendar"></i> Created: {{ $announcement->created_at->format('M d, Y') }}</p>
                <p class="text-muted"><i class="bx bx-category"></i> Type: {{ ucfirst($announcement->type) }}</p>
                <p class="text-muted"><i class="bx bx-user"></i> Audience: {{ ucfirst($announcement->audience) }}</p>

                @if($announcement->type === 'course' && $announcement->course)
                    <p class="text-muted"><i class="bx bx-book"></i> Course: {{ $announcement->course->title }}</p>
                @endif

                <hr>

                <div class="mb-3">
                    <p>{!! nl2br(e($announcement->message)) !!}</p>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.announcement.edit', $announcement->id) }}" class="btn btn-warning">
                        <i class="bx bx-edit"></i> Edit
                    </a>

                    <form action="{{ route('admin.announcement.destroy', $announcement->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="bx bx-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
