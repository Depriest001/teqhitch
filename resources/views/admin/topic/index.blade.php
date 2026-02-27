@extends('admindashboardLayout')
@section('title','Topics Management | Teqhitch ICT Academy LTD')

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
    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Topics Management</h4>
            <p class="text-muted mb-0">Manage all generated seminar and project topics</p>
        </div>

        <a href="{{ route('admin.topics.create') }}" class="btn btn-sm btn-primary">
            <i class="bx bx-plus me-2"></i> Add New Topic
        </a>
    </div>

    {{-- Filters --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Academic Level</label>
                    <select name="academic_level" class="form-select">
                        <option value="">All Levels</option>
                        <option value="BSc" {{ request('academic_level') == 'BSc' ? 'selected' : '' }}>B.Sc</option>
                        <option value="MSc" {{ request('academic_level') == 'MSc' ? 'selected' : '' }}>M.Sc</option>
                        <option value="PhD" {{ request('academic_level') == 'PhD' ? 'selected' : '' }}>Ph.D</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Paper Type</label>
                    <select name="paper_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="seminar" {{ request('paper_type') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                        <option value="project" {{ request('paper_type') == 'project' ? 'selected' : '' }}>Project</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Department</label>
                    <input type="text" name="search" class="form-control" placeholder="Search department..."
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-outline-primary w-100">
                        <i class="bx bx-filter-alt"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Topics Table --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table id="exampleTable" class="table table-sm table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Topic Title</th>
                            <th>Level</th>
                            <th>Type</th>
                            <th>Paper</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topics as $topic)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <strong> {{ Str::limit($topic->title, 30) }}</strong>
                                    <div class="text-muted small">
                                        {{ Str::limit($topic->description, 35) }}
                                    </div>
                                </td>

                                <td>
                                    <span class="badge bg-info">
                                        {{ $topic->academic_level }}
                                    </span>
                                </td>

                                <td>
                                    @if ($topic->paper_type === 'project')
                                        <span class="badge bg-primary">Project</span>
                                    @else
                                        <span class="badge bg-secondary">Seminar</span>
                                    @endif
                                </td>

                                <td>
                                    @if($topic->paper)
                                        <span class="badge bg-success">
                                            Uploaded
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            Not Uploaded
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if ($topic->status === 'inactive')
                                        <span class="badge bg-danger">{{ $topic->status }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $topic->status }}</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $topic->created_at->format('d M, Y') }}
                                </td>

                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                            type="button" data-bs-toggle="dropdown">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.topics.show', $topic->id) }}">
                                                    <i class="bx bx-show me-1"></i> View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.topics.edit', $topic->id) }}">
                                                    <i class="bx bx-edit me-1"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form method="POST" action="{{ route('admin.topics.destroy', $topic->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dropdown-item text-danger"
                                                        onclick="return confirm('Are you sure you want to delete this topic?')">
                                                        <i class="bx bx-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $topics->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
