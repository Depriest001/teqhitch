@extends('admindashboardLayout')
@section('title','Edit Students | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Edit Student</h4>
            <span class="text-muted">Update student information</span>
        </div>

        <a href="{{ route('admin.student.index') }}" class="btn btn-sm btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="row g-4">

        <!-- Student Preview Card -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3 text-center">
                <img src="{{ asset('assets/img/user/icon-male.png') }}" class="rounded-circle mx-auto mb-3" width="130">
                <h5 class="mb-0">{{ $student->name }}</h5>
                <span class="text-muted">{{ $student->status }}</span>

                <hr>

                <div class="text-start">
                    <p><i class="bx bx-envelope"></i> {{ $student->email }}</p>
                    <p><i class="bx bx-phone"></i> Phone: {{ $student->phone ?? 'N/A' }}</p>
                    <p><i class="bx bx-calendar"></i> Joined: {{ $student->created_at->format('M d, Y') }}</p>
                    <p><i class="bx bx-book"></i> Enrolled Courses: {{ $student->courses_count ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="col-md-8">
            <div class="card shadow-sm p-3">
                <h5 class="fw-bold mb-3">Edit Student Details</h5>

                <form action="{{ route('admin.student.update', $student) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="active" {{ $student->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="suspended" {{ $student->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-secondary">
                            <i class="bx bx-reset"></i> Reset
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save"></i> Update Student
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
