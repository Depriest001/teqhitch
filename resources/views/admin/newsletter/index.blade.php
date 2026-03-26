@extends('admindashboardLayout') 

@section('title','Manage Newsletters | Teqhitch ICT Academy LTD')

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
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Newsletters</h4>
            <span class="text-muted">Manage all newsletters and announcements</span>
        </div>
        <a href="{{ route('admin.newsletter.create') }}" class="btn btn-sm btn-primary">
            <i class="bx bx-plus"></i> New Newsletter
        </a>
    </div>

    <!-- Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Total Newsletters</h6>
                <h3>{{ $total ?? $newsletters->count() }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Drafts</h6>
                <h3 class="text-warning">{{ $drafts ?? $newsletters->where('status','draft')->count() }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Sending</h6>
                <h3 class="text-info">{{ $sending ?? $newsletters->where('status','sending')->count() }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h6 class="text-muted">Completed</h6>
                <h3 class="text-success">{{ $completed ?? $newsletters->where('status','completed')->count() }}</h3>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="row mb-4 g-3">
        <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Search newsletters..." />
        </div>
        <div class="col-md-3">
            <select class="form-select">
                <option value="">Filter by status</option>
                <option value="draft">Draft</option>
                <option value="sending">Sending</option>
                <option value="completed">Completed</option>
            </select>
        </div>
    </div>

    <!-- Newsletters Table -->
    <div class="card shadow-sm">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Newsletter List</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle" id="exampleTable">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Scheduled At</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($newsletters as $newsletter)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $newsletter->subject }}</td>
                            <td>
                                @php
                                    $statusClasses = [
                                        'draft' => 'bg-secondary text-white',
                                        'sending' => 'bg-warning text-dark',
                                        'completed' => 'bg-success text-white',
                                    ];
                                @endphp
                                <span class="badge {{ $statusClasses[$newsletter->status] ?? 'bg-secondary text-white' }}">
                                    {{ ucfirst($newsletter->status) }}
                                </span>
                            </td>
                            <td>{{ $newsletter->send_at ? $newsletter->send_at->format('M d, Y H:i') : 'Not Scheduled' }}</td>
                            <td class="text-center text-nowrap">
                                <a href="{{ route('admin.newsletter.show', $newsletter->id) }}" class="btn btn-sm btn-primary me-1" title="Edit">
                                    <i class="bx bx-show"></i>
                                </a>
                                <a href="{{ route('admin.newsletter.edit', $newsletter->id) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                                    <i class="bx bx-edit"></i>
                                </a>
                                <form action="{{ route('admin.newsletter.destroy', $newsletter->id) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this newsletter?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Delete">
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
@endsection