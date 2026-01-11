@extends('admindashboardLayout')
@section('title','Manage Admins | Teqhitch ICT Academy LTD')

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
            <h4 class="fw-bold">Administrators</h4>
            <span class="text-muted">Manage platform administrators & permissions</span>
        </div>

        <button class="btn btn-sm btn-primary" data-bs-toggle="offcanvas" data-bs-target="#addAdmin">
            <i class="bx bx-plus"></i> Add New Admin
        </button>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Total Admins</h6>
                <h3>{{ $total }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Super Admins</h6>
                <h3>{{ $superAdmins }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Active</h6>
                <h3 class="text-success">{{ $active }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Suspended</h6>
                <h3 class="text-danger">{{ $suspended }}</h3>
            </div>
        </div>
    </div>

    <!-- Admin Table -->
    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Admin List</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle" id="exampleTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Admin</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Date Added</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            <span class="badge {{ $admin->role == 'superadmin' ? 'bg-dark' : 'bg-primary' }}">
                                {{ $admin->role }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $admin->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ $admin->status }}
                            </span>
                        </td>
                        <td>{{ $admin->created_at->format('M d, Y') }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.admins.show', $admin) }}" class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                            <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                            <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button onclick="return confirm('Are you sure you want delete this?')" class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ================= Add Admin Offcanvas ================== -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="addAdmin">
        <div class="offcanvas-header">
            <h5>Add New Admin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body">
            <form action="{{ route('admin.admins.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Admin email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="Phone Number" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option selected disabled>-- Select Role --</option>
                        <option value="admin">Admin</option>
                        <option value="moderator">Moderator</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" value="123456" readonly>
                    <span class="">The default password is <b>123456</b></span>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bx bx-save"></i> Create Admin
                </button>
            </form>
        </div>
    </div>

</div>
@endsection