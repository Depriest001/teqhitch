@extends('admindashboardLayout')
@section('title','Profile | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Notifications --}}
    @if (session('success') || session('error') || $errors->any())
        <div id="appToast"
            class="bs-toast toast fade show position-fixed bottom-0 end-0 m-3
            {{ session('success') ? 'bg-success' : (session('error') ? 'bg-danger' : 'bg-warning') }}"
            role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">

            <div class="toast-header text-white">
                <i class="icon-base bx bx-bell me-2"></i>
                <div class="me-auto fw-medium">
                    {{ session('success') ? 'Success' : (session('error') ? 'Error' : 'Validation') }}
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>

            <div class="toast-body text-white">
                @if (session('success')) {{ session('success') }}
                @elseif (session('error')) {{ session('error') }}
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

    <div class="mb-4">
        <h4 class="fw-bold mb-0">
            <i class="bx bx-user text-primary"></i> Profile Settings
        </h4>
    </div>

    {{-- PROFILE SETTINGS --}}
    <div class="card mb-6">
        <div class="card-header h5 py-2 bg-light">Profile Setting</div>

        <div class="card-body pt-4">
            <form class="row" 
                  action="{{ route('admin.profile.update') }}" 
                  method="POST">

                @csrf
                @method('PATCH')

                {{-- Full Name --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" 
                           name="name"
                           class="form-control"
                           value="{{ old('name', $user->name) }}"
                           required>
                </div>

                {{-- Email --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" 
                           name="email"
                           class="form-control"
                           value="{{ old('email', $user->email) }}"
                           required>
                </div>

                {{-- Phone --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Phone</label>
                    <input type="text" 
                           name="phone"
                           class="form-control"
                           value="{{ old('phone', $user->phone) }}">
                </div>

                {{-- Role (View Only) --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Role</label>
                    <input type="text" class="form-control" value="{{ strtoupper($user->role) }}" disabled>
                </div>

                {{-- Status (View Only) --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <input type="text" 
                           class="form-control {{ $user->status == 'active' ? 'text-success' : 'text-danger' }}" 
                           value="{{ ucfirst($user->status) }}" 
                           disabled>
                </div>

                <div class="col-md-12 d-flex justify-content-end gap-2">
                    <a href="{{ url()->previous() }}" class="btn btn-light">Cancel</a>
                    <button class="btn btn-primary">
                        <i class="bx bx-save"></i> Update Profile
                    </button>
                </div>

            </form>
        </div>
    </div>


    {{-- CHANGE PASSWORD --}}
    <div class="card">
        <h5 class="card-header py-2 bg-light">Change Password</h5>

        <div class="card-body">
            <form method="POST" 
                  action="{{ route('admin.profile.password.update') }}">

                @csrf
                @method('PUT')

                <div class="row pt-3 g-4">

                    {{-- Old Password --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Old Password</label>
                        <input class="form-control"
                               type="password"
                               name="old_password"
                               required />
                    </div>

                    {{-- New Password --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">New Password</label>
                        <input class="form-control"
                               type="password"
                               name="new_password"
                               required />
                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Confirm Password</label>
                        <input class="form-control"
                               type="password"
                               name="new_password_confirmation"
                               required />
                    </div>

                    <div class="col-12 mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            🔐 Change Password
                        </button>
                    </div>

                </div>

            </form>
        </div>
    </div>

</div>
@endsection
