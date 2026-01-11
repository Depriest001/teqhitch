@extends('staffdashboardLayout')

@section('title','View Announcement | Teqhitch ICT Academy LTD')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">View Announcement</h4>

        <div>
            <a href="{{ route('staff.announcement.view') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bx bx-arrow-back"></i> Back
            </a>

            {{-- Delete Form --}}
            <form action="{{ route('staff.announcement.destroy', $announcement->id) }}" 
                  method="POST" 
                  class="d-inline">

                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure you want to delete this announcement?')">
                    <i class="bx bx-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>


    <div class="card shadow-sm border-0">
        <div class="card-body">

            {{-- Title --}}
            <h5 class="fw-bold mb-2">
                {{ $announcement->title }}
            </h5>

            {{-- Status Badge --}}
            @if($announcement->status === 'deleted')
                <span class="badge bg-danger mb-3">Deleted</span>
            @elseif($announcement->status === 'inactive')
                <span class="badge bg-warning mb-3">Inactive</span>
            @else
                <span class="badge bg-success mb-3">Active</span>
            @endif


            {{-- Posted Info --}}
            <p class="text-muted mb-3">
                Posted by 
                <strong>{{ $announcement->posted_by_name ?? 'You' }}</strong>
                • {{ $announcement->published_at ? $announcement->published_at->format('M d, Y') : 'Not Published' }}
            </p>

            {{-- Content --}}
            <p class="mb-3">
                {!! nl2br(e($announcement->message)) !!}
            </p>

        </div>
    </div>

</div>

@endsection
