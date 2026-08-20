@extends('admindashboardLayout')
@section('title','Edit Track')

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
            <h4 class="fw-bold mb-1">Edit Track</h4>
            <p class="text-muted mb-0">Update details for "{{ $track->name }}".</p>
        </div>
        <a href="{{ route('admin.siwes.tracks.index') }}" class="btn btn-outline-secondary">
            <i class="icon-base bx bx-arrow-back me-1"></i> Back to Tracks
        </a>
    </div>

    <div class="row">
        <!-- Edit Form -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Track Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.siwes.tracks.update', $track) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Track Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $track->name) }}"
                                   placeholder="e.g. Software Engineering" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price (&#8358;)</label>
                            <input type="number" step="0.01" min="{{ \App\Models\SiwesTrack::MINIMUM_PRICE }}"
                                   class="form-control @error('price') is-invalid @enderror"
                                   id="price" name="price" value="{{ old('price', $track->price) }}"
                                   required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Minimum allowed price is &#8358;{{ number_format(\App\Models\SiwesTrack::MINIMUM_PRICE, 2) }}.</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.siwes.tracks.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="icon-base bx bx-check me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar: Meta + Danger Zone -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Track Info</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Applications</span>
                            <span class="badge bg-label-{{ $track->applications()->count() > 0 ? 'info' : 'secondary' }}">
                                {{ $track->applications()->count() }}
                            </span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Created</span>
                            <span>{{ $track->created_at->format('M d, Y') }}</span>
                        </li>
                        <li class="d-flex justify-content-between py-2">
                            <span class="text-muted">Last Updated</span>
                            <span>{{ $track->updated_at->diffForHumans() }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card border-danger">
                <div class="card-header text-danger">
                    <h5 class="mb-0">Danger Zone</h5>
                </div>
                <div class="card-body">
                    @if ($track->applications()->exists())
                        <p class="text-muted small mb-0">
                            <i class="icon-base bx bx-lock-alt me-1"></i>
                            This track cannot be deleted because it has applications attached to it.
                        </p>
                    @else
                        <p class="text-muted small">Deleting a track is permanent and cannot be undone.</p>
                        <form action="{{ route('admin.siwes.tracks.destroy', $track) }}" method="POST"
                              onsubmit="return confirm('Delete the &quot;{{ $track->name }}&quot; track? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="icon-base bx bx-trash me-1"></i> Delete Track
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection