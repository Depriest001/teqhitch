@extends('admindashboardLayout')
@section('title','Edit Instructor | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Edit Instructor</h4>
            <span class="text-muted">Update instructor information</span>
        </div>

        <a href="{{ route('admin.instructor.index') }}" class="btn btn-sm btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>


    <div class="row g-4">

        {{-- ================= INSTRUCTOR PREVIEW ================= --}}
        <div class="col-md-4">
            <div class="card shadow-sm p-3 text-center">

                <img src="{{ $instructor->profile_photo_url ?? asset('assets/img/user/icon-male.png') }}"
                     class="rounded-circle mx-auto mb-3"
                     width="130">

                <h5 class="mb-0">{{ $instructor->name }}</h5>

                <span class="badge 
                    {{ $instructor->status == 'active' ? 'bg-success' :
                       ($instructor->status == 'suspended' ? 'bg-warning' : 'bg-danger') }}">
                    {{ ucfirst($instructor->status) }}
                </span>

                <hr>

                <div class="text-start">
                    <p><i class="bx bx-envelope"></i> {{ $instructor->email }}</p>
                    <p><i class="bx bx-calendar"></i> Joined:
                        {{ $instructor->created_at->format('M d, Y') }}
                    </p>
                    <p><i class="bx bx-book"></i> Courses Assigned:
                        {{ $instructor->courses_count ?? 0 }}
                    </p>
                </div>

            </div>
        </div>


        {{-- ================= EDIT FORM ================= --}}
        <div class="col-md-8">
            <div class="card shadow-sm p-3">
                <h5 class="fw-bold mb-3">Edit Instructor Details</h5>

                <form action="{{ route('admin.instructor.update', $instructor->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Name --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="{{ old('name', $instructor->name) }}"
                                   required>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="{{ old('email', $instructor->email) }}"
                                   required>
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text"
                                   name="phone"
                                   class="form-control"
                                   value="{{ old('phone', $instructor->phone) }}"
                                   required>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="active"
                                    {{ $instructor->status == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="suspended"
                                    {{ $instructor->status == 'suspended' ? 'selected' : '' }}>
                                    Suspended
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-secondary">
                            <i class="bx bx-reset"></i> Reset
                        </button>

                        <button class="btn btn-primary">
                            <i class="bx bx-save"></i> Update Instructor
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
