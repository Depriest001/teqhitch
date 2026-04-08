@extends('admindashboardLayout')

@section('title', 'Testimonies | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Testimonies</h4>
            <span class="text-muted">What our students and clients are saying</span>
        </div>

        <!-- Trigger Offcanvas -->
        <button class="btn btn-sm btn-primary" data-bs-toggle="offcanvas" data-bs-target="#createTestimony">
            <i class="bx bx-plus"></i> New Testimony
        </button>
    </div>

    <!-- Table Design -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-sm table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Occupation</th>
                            <th>Message</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>1</td>
                            <td>
                                <img src="https://via.placeholder.com/50" class="rounded-circle" width="30" height="30">
                            </td>
                            <td>John Doe</td>
                            <td>Developer</td>
                            <td>"Teqhitch ICT Academy transformed my tech skills."</td>

                            <td class="text-center">
                                <a href="{{ route('admin.testimonies.show1') }}" class="btn btn-sm btn-info me-1">
                                    <i class="bx bx-show"></i>
                                </a>
                                <button class="btn btn-sm btn-danger"> 
                                    <i class="bx bx-trash"></i> 
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>
                                <img src="https://via.placeholder.com/50" class="rounded-circle" width="30" height="30">
                            </td>
                            <td>Mary Johnson</td>
                            <td>Student</td>
                            <td>"I got my first tech job after learning here."</td>

                            <td class="text-center">
                                <a href="{{ route('admin.testimonies.show1') }}" class="btn btn-sm btn-info me-1">
                                    <i class="bx bx-show"></i>
                                </a>
                                <button class="btn btn-sm btn-danger"> 
                                    <i class="bx bx-trash"></i> 
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>
                                <img src="https://via.placeholder.com/50" class="rounded-circle" width="30" height="30">
                            </td>
                            <td>Samuel Lee</td>
                            <td>Intern</td>
                            <td>"The hands-on projects made learning easy."</td>

                            <td class="text-center">
                                <a href="{{ route('admin.testimonies.show1') }}" class="btn btn-sm btn-info me-1">
                                    <i class="bx bx-show"></i>
                                </a>
                                <button class="btn btn-sm btn-danger"> 
                                    <i class="bx bx-trash"></i> 
                                </button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- ================= OFFCANVAS ================= -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="createTestimony">

    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Create New Testimony</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        <form>

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" placeholder="Enter name">
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" class="form-control">
            </div>

            <!-- Message -->
            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea class="form-control" rows="4" placeholder="Enter testimony"></textarea>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select class="form-select">
                    <option>Active</option>
                    <option>Inactive</option>
                </select>
            </div>

            <button type="button" class="btn btn-primary w-100">
                Save Testimony
            </button>

        </form>

    </div>

</div>
@endsection