@extends('admindashboardLayout')

@section('title','Manage Enrollments | Teqhitch ICT Academy LTD')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success') || session('error') || $errors->any())
        <div id="appToast"
            class="bs-toast toast fade show position-fixed top-0 end-0 m-3
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

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Enrollments</h4>
            <p class="text-muted mb-0">Manage student applications submitted through the enrollment form.</p>
        </div>
        <div class="d-flex flex-column flex-sm-row gap-2">
            <a href="{{ route('admin.enrollments.exportFiltered', request()->query()) }}" class="btn btn-label-primary">
                <i class="icon-base bx bx-export me-1"></i> Export Table
            </a>
            <a href="{{ route('admin.enrollments.export') }}" class="btn btn-primary">
                <i class="icon-base bx bx-download me-1"></i> Export All (CSV)
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control" placeholder="Name or email...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Program</label>
                    <select name="course_id" class="form-select">
                        <option value="">All Programs</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label">From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label">To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                </div>
                <div class="col-md-1 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="icon-base bx bx-filter-alt"></i>
                    </button>
                    <a href="{{ route('admin.enrollments.index') }}" class="btn btn-label-secondary">
                        <i class="icon-base bx bx-x"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Actions Bar (hidden until rows selected) -->
    <div id="bulkActionsBar" class="alert alert-primary d-none flex-column flex-sm-row align-items-sm-center justify-content-sm-between gap-2 mb-3">
        <span class="mb-2 mb-sm-0"><span id="selectedCount">0</span> selected</span>
        <div class="d-flex flex-wrap gap-2">
            <button type="submit" form="bulkActionForm" name="action" value="approve" class="btn btn-sm btn-success flex-fill flex-sm-grow-0">
                <i class="icon-base bx bx-check"></i> Approve
            </button>
            <button type="submit" form="bulkActionForm" name="action" value="reject" class="btn btn-sm btn-danger flex-fill flex-sm-grow-0"
                onclick="return confirm('Reject all selected applications?')">
                <i class="icon-base bx bx-x"></i> Reject
            </button>
            <button type="submit" form="bulkActionForm" name="action" value="delete" class="btn btn-sm btn-outline-danger flex-fill flex-sm-grow-0"
                onclick="return confirm('Permanently delete all selected applications? This cannot be undone.')">
                <i class="icon-base bx bx-trash"></i> Delete
            </button>
        </div>
    </div>

    <!-- Hidden forms for bulk actions -->
    <form id="bulkActionForm" action="{{ route('admin.enrollments.bulkAction') }}" method="POST" class="d-none">
        @csrf
        <div id="bulkActionIdsContainer"></div>
    </form>

    <!-- Table Card -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="table table-sm table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 40px;">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th style="width: 50px;">#</th>
                        <th>Applicant</th>
                        <th>Contact</th>
                        <th>Program</th>
                        <th>Status</th>
                        <th>Applied</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrollments as $item)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input row-checkbox" value="{{ $item->id }}">
                            </td>
                            <td class="text-muted">{{ $loop->iteration + ($enrollments->currentPage() - 1) * $enrollments->perPage() }}</td>
                            <td>
                                <span class="fw-medium">{{ $item->first_name }} {{ $item->last_name }}</span>
                            </td>
                            <td>
                                <div class="small">{{ $item->email }}</div>
                                <div class="small text-muted">{{ $item->phone }}</div>
                            </td>
                            <td>
                                <span class="badge bg-label-primary">{{ $item->course->title ?? '—' }}</span>
                            </td>
                            <td>
                                @if($item->status === 'approved')
                                    <span class="badge bg-label-success">Approved</span>
                                @elseif($item->status === 'rejected')
                                    <span class="badge bg-label-danger">Rejected</span>
                                @else
                                    <span class="badge bg-label-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-nowrap small">{{ $item->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="text-nowrap text-end">
                                <!-- <a href="#" class="btn btn-icon btn-sm btn-text-secondary rounded-pill" title="View">
                                    <i class="icon-base bx bx-show"></i>
                                </a> -->
                                <button type="button" class="btn btn-icon btn-sm btn-text-danger rounded-pill"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}" title="Delete">
                                    <i class="icon-base bx bx-trash"></i>
                                </button>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body text-center p-4">
                                                <i class="icon-base bx bx-error-circle text-danger mb-3" style="font-size: 3rem;"></i>
                                                <h5>Delete this application?</h5>
                                                <p class="text-muted">{{ $item->first_name }} {{ $item->last_name }}'s application will be permanently removed.</p>
                                                <form action="{{ route('admin.enrollments.destroy', $item) }}" method="POST" class="d-flex justify-content-center gap-2 mt-3">
                                                    @csrf @method('DELETE')
                                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                No enrollment applications yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($enrollments->hasPages())
            <div class="card-footer">
                {{ $enrollments->links() }}
            </div>
        @endif
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const bulkBar = document.getElementById('bulkActionsBar');
    const selectedCount = document.getElementById('selectedCount');
    const exportSelectedBtn = document.getElementById('exportSelectedBtn');
    const bulkActionContainer = document.getElementById('bulkActionIdsContainer');
    const bulkExportContainer = document.getElementById('bulkExportIdsContainer');

    function updateBulkUI() {
        const checked = Array.from(rowCheckboxes).filter(cb => cb.checked);
        const count = checked.length;

        selectedCount.textContent = count;
        bulkBar.classList.toggle('d-none', count === 0);
        bulkBar.classList.toggle('d-flex', count > 0);
        exportSelectedBtn.disabled = count === 0;

        // Sync hidden id inputs into both bulk forms
        bulkActionContainer.innerHTML = '';
        bulkExportContainer.innerHTML = '';
        checked.forEach(cb => {
            const input1 = document.createElement('input');
            input1.type = 'hidden';
            input1.name = 'ids[]';
            input1.value = cb.value;
            bulkActionContainer.appendChild(input1);

            const input2 = document.createElement('input');
            input2.type = 'hidden';
            input2.name = 'ids[]';
            input2.value = cb.value;
            bulkExportContainer.appendChild(input2);
        });

        selectAll.checked = count > 0 && count === rowCheckboxes.length;
    }

    selectAll.addEventListener('change', function () {
        rowCheckboxes.forEach(cb => cb.checked = selectAll.checked);
        updateBulkUI();
    });

    rowCheckboxes.forEach(cb => cb.addEventListener('change', updateBulkUI));

    updateBulkUI();
});
</script>

@endsection