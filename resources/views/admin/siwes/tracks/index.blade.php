@extends('admindashboardLayout')
@section('title','Manage SIWES Tracks')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if (session('status') || session('error') || $errors->any())
        <div id="appToast"
            class="bs-toast toast fade show position-fixed top-0 end-0 m-3
            {{ session('status') ? 'bg-success' : (session('error') ? 'bg-danger' : 'bg-warning') }}"
            role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header text-white">
                <i class="icon-base bx bx-bell me-2"></i>
                <div class="me-auto fw-medium">
                @if (session('status'))
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
                @if (session('status'))
                {{ session('status') }}
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
            <h4 class="fw-bold mb-1">SIWES Tracks</h4>
            <p class="text-muted mb-0">Manage the available SIWES tracks and their pricing.</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#addTrackOffcanvas">
            <i class="icon-base bx bx-plus me-1"></i> Add Track
        </button>
    </div>

    <!-- Tracks Table -->
    <div class="card">
        <div class="table-responsive table-sm text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Applications</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($tracks as $track)
                        <tr>
                            <td>{{ $loop->iteration + ($tracks->currentPage() - 1) * $tracks->perPage() }}</td>
                            <td class="fw-medium">{{ $track->name }}</td>
                            <td>&#8358;{{ number_format($track->price, 2) }}</td>
                            <td>
                                <span class="badge bg-label-{{ $track->applications_count > 0 ? 'info' : 'secondary' }}">
                                    {{ $track->applications_count }}
                                </span>
                            </td>
                            <td>{{ $track->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.siwes.tracks.edit', $track) }}"
                                   class="btn btn-sm btn-icon" title="Edit">
                                    <i class="icon-base bx bx-edit-alt"></i>
                                </a>
                                <form action="{{ route('admin.siwes.tracks.destroy', $track) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete the &quot;{{ $track->name }}&quot; track? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-icon text-danger" title="Delete">
                                        <i class="icon-base bx bx-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No tracks have been created yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($tracks->hasPages())
            <div class="card-footer">
                {{ $tracks->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Add Track Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="addTrackOffcanvas" aria-labelledby="addTrackOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 id="addTrackOffcanvasLabel" class="offcanvas-title">Add New Track</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('admin.siwes.tracks.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Track Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       id="name" name="name" value="{{ old('name') }}"
                       placeholder="e.g. Software Engineering" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price (&#8358;)</label>
                <input type="number" step="0.01" min="{{ \App\Models\SiwesTrack::MINIMUM_PRICE }}"
                       class="form-control @error('price') is-invalid @enderror"
                       id="price" name="price" value="{{ old('price') }}"
                       placeholder="Minimum &#8358;{{ number_format(\App\Models\SiwesTrack::MINIMUM_PRICE, 2) }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Minimum allowed price is &#8358;{{ number_format(\App\Models\SiwesTrack::MINIMUM_PRICE, 2) }}.</div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="icon-base bx bx-check me-1"></i> Save Track
                </button>
            </div>
        </form>
    </div>
</div>
@endsection