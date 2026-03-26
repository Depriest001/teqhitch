@extends('userdashboardLayout')
@section('title','Activities | Teqhitch ICT Academy LTD')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Activities</h4>
            <p class="text-muted mb-0">Track your learning journey, submissions and achievements</p>
        </div>
        <button class="btn btn-dark btn-sm" onclick="window.location.reload()">
            <i class="bx bx-refresh me-1"></i> Refresh
        </button>
    </div>

    <!-- Timeline -->
    <div class="card border-0 shadow-sm">
        <div class="mt-4 d-flex justify-content-center">
            {{ $activities->links() }}
        </div>

        <div class="card-body">

            @php
                use Carbon\Carbon;
                $today = Carbon::today();
                $currentWeekStart = Carbon::now()->startOfWeek();
                $currentWeekEnd = Carbon::now()->endOfWeek();
            @endphp

            @php
                $todayActivities = [];
                $weekActivities = [];
                $olderActivities = [];

                foreach ($activities as $activity) {
                    $created = Carbon::parse($activity->created_at);
                    if ($created->isToday()) {
                        $todayActivities[] = $activity;
                    } elseif ($created->between($currentWeekStart, $currentWeekEnd)) {
                        $weekActivities[] = $activity;
                    } else {
                        $olderActivities[] = $activity;
                    }
                }
            @endphp

            {{-- Today --}}
            @if(count($todayActivities))
                <h6 class="text-uppercase text-muted small mb-3">Today</h6>
                @foreach($todayActivities as $activity)
                    <div class="timeline-item mb-4 d-flex">
                        <div class="me-3">
                            <span class="badge {{ $activity->badge_color ?? 'bg-primary' }} rounded-circle p-3">
                                <i class="bx {{ $activity->icon ?? 'bx-task' }}"></i>
                            </span>
                        </div>
                        <div>
                            <h6 class="mb-1">{{ $activity->action }}</h6>
                            @if(!empty($activity->details['description']))
                                <p class="text-muted small mb-1">{{ $activity->details['description'] }}</p>
                            @endif
                            <span class="badge bg-light text-dark">{{ ucfirst($activity->module) }}</span>
                            <span class="text-muted small ms-2">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            @endif

            {{-- This Week --}}
            @if(count($weekActivities))
                <h6 class="text-uppercase text-muted small mb-3 mt-4">This Week</h6>
                @foreach($weekActivities as $activity)
                    <div class="timeline-item mb-4 d-flex">
                        <div class="me-3">
                            <span class="badge {{ $activity->badge_color ?? 'bg-warning' }} rounded-circle p-3">
                                <i class="bx {{ $activity->icon ?? 'bx-award' }}"></i>
                            </span>
                        </div>
                        <div>
                            <h6 class="mb-1">{{ $activity->action }}</h6>
                            @if(!empty($activity->details['description']))
                                <p class="text-muted small mb-1">{{ $activity->details['description'] }}</p>
                            @endif
                            <span class="badge bg-light text-dark">{{ ucfirst($activity->module) }}</span>
                            <span class="text-muted small ms-2">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            @endif

            {{-- Older --}}
            @if(count($olderActivities))
                <h6 class="text-uppercase text-muted small mb-3 mt-4">Earlier</h6>
                @foreach($olderActivities as $activity)
                    <div class="timeline-item mb-4 d-flex">
                        <div class="me-3">
                            <span class="badge {{ $activity->badge_color ?? 'bg-secondary' }} rounded-circle p-3">
                                <i class="bx {{ $activity->icon ?? 'bx-time' }}"></i>
                            </span>
                        </div>
                        <div>
                            <h6 class="mb-1">{{ $activity->action }}</h6>
                            @if(!empty($activity->details['description']))
                                <p class="text-muted small mb-1">{{ $activity->details['description'] }}</p>
                            @endif
                            <span class="badge bg-light text-dark">{{ ucfirst($activity->module) }}</span>
                            <span class="text-muted small ms-2">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>

</div>

@endsection
