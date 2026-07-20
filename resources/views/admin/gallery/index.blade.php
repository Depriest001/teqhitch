@extends('admindashboardLayout')
@section('title','Gallery | Teqhitch ICT Academy LTD')

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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Gallery</h4>
            <p class="text-muted mb-0">Manage images shown in the homepage gallery slider.</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#createGalleryOffcanvas">
            <i class="icon-base bx bx-plus me-1"></i> Add Image
        </button>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar avatar-md me-3">
                        <span class="avatar-initial rounded bg-label-primary"><i class="icon-base bx bx-images"></i></span>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $gallery->count() }}</h5>
                        <small class="text-muted">Total Images</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar avatar-md me-3">
                        <span class="avatar-initial rounded bg-label-success"><i class="icon-base bx bx-check-circle"></i></span>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $gallery->where('status', true)->count() }}</h5>
                        <small class="text-muted">Active</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Images</h5>
        </div>
        <div class="card-body">
            <div class="row g-4">
                @forelse($gallery as $item)
                <div class="col-sm-6 col-lg-3">
                    <div class="card h-100">
                        <img src="{{ asset('uploads/'.$item->image) }}"
                             class="card-img-top" style="height:160px; object-fit:cover;">
                        <div class="card-body p-3">
                            <h6 class="mb-1 text-truncate">{{ $item->title ?: 'Untitled' }}</h6>
                            <span class="badge {{ $item->status ? 'bg-label-success' : 'bg-label-danger' }} mb-2">
                                {{ $item->status ? 'Active' : 'Inactive' }}
                            </span>
                            <div class="d-flex gap-2 mt-2">
                                <form action="{{ route('admin.gallery.toggle-status', $item->id) }}" method="POST" class="flex-fill">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="btn btn-sm w-100 {{ $item->status ? 'btn-warning' : 'btn-success' }}"
                                        onclick="return confirm('Change status of this image?')">
                                        {{ $item->status ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Permanently delete this image?')">
                                        <i class="icon-base bx bx-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5 text-muted">
                    <i class="icon-base bx bx-images fs-1 d-block mb-2"></i>
                    No gallery images added yet. Click "Add Image" to get started.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- OFFCANVAS: Create Gallery Image -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="createGalleryOffcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Add Gallery Image</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('admin.gallery.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title (optional)</label>
                <input type="text" class="form-control" name="title" placeholder="e.g Graduation Day 2025">
            </div>

            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" class="form-control" name="image" id="createGalleryInput" accept="image/*" required>
            </div>

            <div class="text-center mb-3">
                <img src="https://dummyimage.com/200x150/f0f0f0/000&text=Preview"
                     class="rounded shadow" width="200" height="150" id="createGalleryPreview" style="object-fit:cover;">
            </div>

            <button class="btn btn-primary w-100">
                <i class="icon-base bx bx-save me-1"></i> Save Image
            </button>
        </form>
    </div>
</div>

<script>
    document.getElementById('createGalleryInput')?.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('createGalleryPreview').src = URL.createObjectURL(file);
        }
    });
</script>
@endsection