@extends('userdashboardLayout')
@section('title','Announcements | Teqhitch ICT Academy LTD')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Announcements</h4>
            <p class="text-muted mb-0">
                Stay updated with the latest platform and course notifications
            </p>
        </div>
        <a href="{{ route('user.announcement.index') }}" class="btn btn-outline-dark btn-sm">
            <i class="bx bx-refresh me-1"></i> Refresh
        </a>
    </div>

    <!-- Filters -->
    <div class="mb-4">
        <ul class="nav nav-pills flex-nowrap overflow-auto">
            <li class="nav-item">
                <a class="nav-link {{ request('filter') === null ? 'active' : '' }}" 
                href="{{ route('user.announcement.index') }}">
                All
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('filter') === 'course' ? 'active' : '' }}" 
                href="{{ route('user.announcement.index', ['filter' => 'course']) }}">
                    Courses
                </a>
            </li>
        </ul>
    </div>

    <!-- Announcement List -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <!-- Announcement -->
            @forelse($announcements as $announcement)
                <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between p-3 border rounded mb-3">

                    <div class="d-flex align-items-start">
                        <span class="badge 
                            {{ $announcement->type === 'system' ? 'bg-danger' : 
                            ($announcement->type === 'course' ? 'bg-primary' : 'bg-success') }} 
                            rounded-circle p-2 me-3">
                            <i class="bx 
                                {{ $announcement->type === 'system' ? 'bxs-megaphone' : 
                                ($announcement->type === 'course' ? 'bx-book-open' : 'bx-calendar-event') }}">
                            </i>
                        </span>

                        <div>
                            <h6 class="fw-bold mb-1">
                                {{ $announcement->title }}

                                @if(!$announcement->is_read)
                                    <span class="badge bg-warning ms-2">New</span>
                                @endif
                            </h6>

                            <p class="text-muted small mb-1">
                                {{ Str::limit($announcement->message, 90) }}
                            </p>

                            <small class="text-muted">
                                Posted: {{ $announcement->published_at?->diffForHumans() }}
                                @if($announcement->course)
                                    • {{ $announcement->course->title }}
                                @endif
                            </small>
                        </div>
                    </div>

                    <div class="mt-3 mt-sm-0">
                        <button class="btn btn-outline-dark btn-sm"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#announcementView"
                            data-id="{{ $announcement->id }}"
                            data-title="{{ $announcement->title }}"
                            data-message="{{ $announcement->message }}"
                            data-type="{{ ucfirst($announcement->type) }}"
                            data-posted="{{ $announcement->published_at?->format('M d, Y • h:i A') }}">
                            View
                        </button>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center">No announcements available.</p>
            @endforelse

        </div>
    </div>
</div>


<!-- ==========================
     OFFCANVAS VIEW (Modern)
=========================== -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="announcementView">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold">
            Announcement Details
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <span class="badge bg-dark mb-2" id="aType"></span>

        <h5 class="fw-bold mb-2" id="aTitle"></h5>

        <p class="text-muted small mb-3" id="aPosted"></p>

        <p class="text-muted" id="aMessage"></p>

        <hr>

        <button class="btn btn-dark w-100" id="markReadBtn">
            Mark as Read
        </button>

    </div>

</div>

<script>
document.addEventListener('click', function (e) {
    if (e.target.matches('[data-bs-target="#announcementView"]')) {

        const btn = e.target;

        document.getElementById('aTitle').textContent = btn.dataset.title;
        document.getElementById('aMessage').textContent = btn.dataset.message;
        document.getElementById('aType').textContent = btn.dataset.type;
        document.getElementById('aPosted').textContent = 'Posted: ' + btn.dataset.posted;

        const markBtn = document.getElementById('markReadBtn');
        markBtn.onclick = function () {
            fetch(`/announcements/${btn.dataset.id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => location.reload());
        };
    }
});
</script>

@endsection
