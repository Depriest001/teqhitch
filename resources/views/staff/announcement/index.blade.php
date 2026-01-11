@extends('staffdashboardLayout')
@section('title','Announcements | Teqhitch ICT Academy LTD')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold mb-1">Announcements</h4>
            <p class="text-muted mb-0">Stay updated with latest academy information</p>
        </div>
        <div class="col-md-6 text-md-end">

            <a href="{{ route('staff.announcement.view')}}" class="btn btn-sm btn-outline-secondary">
                <i class="bx bxs-cog me-1"></i> Manage Announcement
            </a>
        </div>
        
    </div>

    <!-- Announcement List -->
    <div class="row g-4">
        @forelse($announcements as $announcement)
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <div class="d-flex justify-content-between">
                            <h5 class="fw-bold mb-1">{{ $announcement->title }}</h5>

                            @php
                                $badgeClass = match($announcement->status) {
                                    'published' => 'bg-success',
                                    'draft' => 'bg-warning text-dark',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <p><span class="badge {{ $badgeClass }} h-auto">{{ ucfirst($announcement->status) }}</span></p>
                        </div>

                        <p class="text-muted mb-2">
                            {{ Str::limit($announcement->message, 150) }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bx bx-user"></i> {{ $announcement->postedBy?->name ?? 'Admin' }} •
                                <i class="bx bx-time-five"></i> {{ $announcement->published_at?->format('M d, Y') ?? $announcement->created_at->format('M d, Y') }}
                            </small>

                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#announcementModal{{ $announcement->id }}">
                                Read More
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Modal for each announcement -->
            <div class="modal fade" id="announcementModal{{ $announcement->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">{{ $announcement->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p>{{ $announcement->message }}</p>
                        <hr>
                        <small class="text-muted">
                            Posted by {{ $announcement->postedBy?->name ?? 'Admin' }} • 
                            {{ $announcement->published_at?->format('M d, Y') ?? $announcement->created_at->format('M d, Y') }}
                        </small>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No announcements available.</p>
        @endforelse
    </div>


</div>

<!-- Include Offcanvas for New Announcement -->
<div class="offcanvas offcanvas-end shadow" tabindex="-1" id="newAnnouncement">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fw-bold">Create New Announcement</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <form>
            <div class="mb-3">
                <label class="form-label fw-semibold">Title</label>
                <input type="text" class="form-control" placeholder="Enter announcement title">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Message</label>
                <textarea rows="4" class="form-control" placeholder="Write announcement details..."></textarea>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">
                    Cancel
                </button>

                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-send"></i> Publish Announcement
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
