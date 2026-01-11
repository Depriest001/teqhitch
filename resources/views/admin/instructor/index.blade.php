@extends('admindashboardLayout')
@section('title','Instructors | Teqhitch ICT Academy LTD')

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
            <h4 class="fw-bold">Instructors</h4>
            <span class="text-muted">Manage all platform instructors</span>
        </div>

        <button class="btn btn-sm btn-sm btn-primary" data-bs-toggle="offcanvas" data-bs-target="#addInstructor">
            <i class="bx bx-plus"></i> Add New Instructor
        </button>
    </div>

    <!-- Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Total Instructors</h6>
                <h3>{{ $total }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Active</h6>
                <h3 class="text-success">{{ $active }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Suspended</h6>
                <h3 class="text-danger">{{ $suspended }}</h3>
            </div>
        </div>
    </div>

    <!-- Instructors Table -->
    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Instructor List</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle" id="exampleTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Instructor</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Courses</th>
                        <th>Joined At</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($instructors as $instructor)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $instructor->name }}</td>

                        <td>{{ $instructor->email }}</td>

                        <td>
                            <span class="badge {{ $instructor->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($instructor->status) }}
                            </span>
                        </td>

                        <td>{{ $instructor->courses_count ?? 0 }}</td>

                        <td>{{ $instructor->created_at->format('M d, Y') }}</td>

                        <td class="text-nowrap">
                            <a href="{{ route('admin.instructor.show', $instructor->id) }}" 
                            class="btn btn-sm btn-info">
                            <i class="bx bx-show"></i>
                            </a>

                            <a href="{{ route('admin.instructor.edit', $instructor->id) }}" 
                            class="btn btn-sm btn-warning">
                            <i class="bx bx-edit"></i>
                            </a>

                            <form action="{{ route('admin.instructor.destroy', $instructor->id) }}" 
                                method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure you want to delete this user?')" 
                                        class="btn btn-sm btn-danger">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <!-- ================= Add Instructor Offcanvas ================== -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="addInstructor">
        <div class="offcanvas-header">
            <h5>Add New Instructor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body">
            <form action="{{ route('admin.instructor.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter full name">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number">
                </div>
                
                <div class="mb-3">
                    <small>The default password is <b>123456</b></small>
                </div>

                <button class="btn btn-primary w-100">
                    <i class="bx bx-save"></i> Add Instructor
                </button>
            </form>
        </div>
    </div>
</div>
@endsection