@extends('admindashboardLayout')
@section('title','Edit Administrator | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Edit Administrator</h4>
            <span class="text-muted">Update admin details and permissions</span>
        </div>

        <a href="{{ route('admin.admins.index')}}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="row g-4">

        <!-- Profile Card -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3 text-center">
                <img src="{{ asset('dashboardassets/images/avatar/user.png')}}" class="rounded-circle mx-auto mb-3" width="130">

                <h5 class="mb-0">{{ $admin->name }}</h5>
                <span class="text-muted text-capitalize">{{ $admin->role }}</span>

                <div class="mt-3">
                    @if($admin->status == 'active')
                        <span class="badge bg-success px-3">Active</span>
                    @else
                        <span class="badge bg-danger px-3">Suspended</span>
                    @endif
                </div>

                <hr>

                <div class="text-start">
                    <p><i class="bx bx-envelope"></i> {{ $admin->email }}</p>
                    <p><i class="bx bx-phone"></i> {{ $admin->phone ?? 'N/A' }}</p>
                    <p><i class="bx bx-calendar"></i> Joined: {{ $admin->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="col-md-8">
            <div class="card shadow-sm p-3">
                <h5 class="fw-bold mb-3">Edit Admin Details</h5>

                <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" 
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $admin->name) }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" 
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $admin->email) }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" 
                                   name="phone"
                                   class="form-control"
                                   value="{{ old('phone', $admin->phone) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="admin" {{ $admin->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="moderator" {{ $admin->role == 'moderator' ? 'selected' : '' }}>Moderator</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account Status</label>
                            <select name="status" class="form-select">
                                <option value="active" {{ $admin->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="suspended" {{ $admin->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Change Password (Optional)</label>
                            <input type="password" 
                                   name="password"
                                   class="form-control"
                                   placeholder="Leave empty if not changing">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-secondary">
                            <i class="bx bx-reset"></i> Reset
                        </button>

                        <button class="btn btn-primary">
                            <i class="bx bx-save"></i> Update Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
