@extends('staffdashboardLayout')
@section('title','Manage Assignments | Teqhitch ICT Academy LTD')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Page Header -->
    <div class="mb-4">
        <h4 class="fw-bold mb-0">Manage Assignments</h4>
    </div>

    <!-- Search & Filters -->
    <form method="GET">
        <div class="row mb-4 g-2">
            
            <!-- Search -->
            <div class="col-md-4">
                <input type="text"
                    name="search"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="Search assignments by title or course">
            </div>

            <!-- Filter by course -->
            <div class="col-md-3">
                <select name="course_id" class="form-select">
                    <option value="">Filter by course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}"
                            {{ request('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter by status -->
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Filter by status</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected':'' }}>Pending</option>
                    <option value="submitted" {{ request('status')=='submitted' ? 'selected':'' }}>Submitted</option>
                    <option value="graded" {{ request('status')=='graded' ? 'selected':'' }}>Graded</option>
                    <option value="late" {{ request('status')=='late' ? 'selected':'' }}>Late</option>
                </select>
            </div>

            <!-- Apply -->
            <div class="col-md-2 text-end">
                <button class="btn btn-outline-secondary">
                    <i class="bx bx-filter-alt"></i> Apply Filter
                </button>
            </div>

        </div>
    </form>

    <!-- Assignments Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0">
            <h6 class="fw-bold mb-0">Assignments List</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0 align-middle" id="exampleTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Assignment Title</th>
                            <th>Course</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignments as $index => $assignment)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $assignment->title }}</td>

                            <td>{{ $assignment->course->title ?? 'N/A' }}</td>

                            <td>{{ \Carbon\Carbon::parse($assignment->deadline)->format('M d, Y') }}</td>

                            <td>
                                @php
                                    $status = now()->greaterThan($assignment->deadline) ? 'Late' : 'Pending';
                                @endphp

                                <span class="badge 
                                    @if($status=='Pending') bg-warning
                                    @elseif($status=='Late') bg-danger
                                    @else bg-secondary
                                    @endif">
                                    {{ $status }}
                                </span>
                            </td>

                            <td class="text-nowrap">
                                <a href="{{ route('staff.assignment.show', $assignment->id) }}" 
                                class="btn btn-sm btn-outline-primary">
                                    <i class="bx bx-show"></i>
                                </a>

                                <form action="{{ route('staff.assignment.destroy', $assignment->id) }}" 
                                    method="POST" 
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Delete assignment?')">
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
    </div>

</div>

@endsection