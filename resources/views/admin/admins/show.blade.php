@extends('admindashboardLayout')
@section('title','Admin Details | Teqhitch ICT Academy LTD')

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
            <h4 class="fw-bold">Admin Details</h4>
            <span class="text-muted">View admin profile and account activities</span>
        </div>

        <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="row g-4">

        <!-- Profile Card -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3 text-center">
                <img src="{{ asset('dashboardassets/images/avatar/user.png')}}" class="rounded-circle mx-auto mb-3" width="130">
                <h5 class="mb-0">{{ $admin->name }}</h5>
                <span class="text-muted">{{ $admin->role }}</span>

                <div class="mt-3">
                    <span class="badge {{ $admin->status == 'active' ? 'bg-success' : 'bg-danger' }} px-3">
                        {{ $admin->status }}
                    </span>
                </div>

                <hr>

                <div class="text-start">
                    <p><i class="bx bx-envelope"></i> {{ $admin->email }}</p>
                    <p><i class="bx bx-phone"></i> {{ $admin->phone ?? 'N/A' }}</p>
                    <p><i class="bx bx-calendar"></i> Joined: {{ $admin->created_at->format('M d, Y') }}</p>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-warning w-50">
                        <i class="bx bx-edit"></i> Edit
                    </a>

                    @if($admin->role !== 'Super Admin')
                    <form action="{{ route('admin.admins.suspend', $admin->id) }}" method="POST" class="d-inline" 
                        onsubmit="return confirm('Are you sure you want to suspend this admin?');">
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

        <!-- Details & Activities -->
        <div class="col-md-8">

            <div class="card shadow-sm p-3 mb-4">
                <h5 class="fw-bold mb-3">Account Information</h5>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Full Name:</strong> {{ $admin->name }}</p>
                        <p><strong>Phone Number:</strong> {{ $admin->phone ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p><strong>Role:</strong> {{ $admin->role }}</p>
                        <p><strong>Status:</strong> {{ $admin->status }}</p>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm p-3">
                <h5 class="fw-bold mb-3">Recent Activities</h5>

                <ul class="list-group">
                    @forelse($admin->activities ?? [] as $activity)
                        <li class="list-group-item">
                            <i class="bx {{ $activity['icon'] ?? 'bx-task' }} text-{{ $activity['color'] ?? 'primary' }}"></i>
                            {{ $activity['description'] }}
                            <span class="float-end text-muted">{{ $activity['time'] }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">No recent activities.</li>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection
