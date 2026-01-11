@extends('staffdashboardLayout')
@section('title','Students | Teqhitch ICT Academy LTD')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="mb-4">
        <div>
            <h4 class="fw-bold mb-1">Enrolled Students</h4>
            <p class="text-muted mb-0">Manage students enrolled in this course</p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <!-- Students Table -->
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0" id="exampleTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $index => $enroll)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $enroll->student->name }}</td>

                            <td>{{ $enroll->student->email }}</td>

                            <td>{{ $enroll->course->title }}</td>

                            <td>
                                <div class="progress" style="height:6px;">
                                    <div class="progress-bar 
                                        {{ ($enroll->progress ?? 0) >= 70 ? 'bg-success' : 'bg-info' }}"
                                        style="width: {{ $enroll->progress ?? 0 }}%">
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge 
                                    {{ $enroll->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($enroll->status ?? 'active') }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('staff.student.show', $enroll->id) }}" 
                                class="btn btn-sm btn-outline-primary">
                                    <i class="bx bx-show"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
