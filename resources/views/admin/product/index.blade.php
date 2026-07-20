@extends('admindashboardLayout')
@section('title','Products | Teqhitch ICT Academy LTD')

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
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Products</h4>
            <p class="text-muted mb-0">Manage software builds and client websites showcased on the homepage.</p>
        </div>
        <button type="button" class="btn btn-primary text-nowrap" data-bs-toggle="offcanvas" data-bs-target="#createProductOffcanvas">
            <i class="icon-base bx bx-plus me-1"></i> Add Product
        </button>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar avatar-md me-3">
                        <span class="avatar-initial rounded bg-label-primary"><i class="icon-base bx bx-package"></i></span>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $products->count() }}</h5>
                        <small class="text-muted">Total Products</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar avatar-md me-3">
                        <span class="avatar-initial rounded bg-label-info"><i class="icon-base bx bx-laptop"></i></span>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $products->where('type', 'software')->count() }}</h5>
                        <small class="text-muted">Software</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="avatar avatar-md me-3">
                        <span class="avatar-initial rounded bg-label-warning"><i class="icon-base bx bx-globe"></i></span>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $products->where('type', 'website')->count() }}</h5>
                        <small class="text-muted">Websites</small>
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
                        <h5 class="mb-0">{{ $products->where('status', true)->count() }}</h5>
                        <small class="text-muted">Active</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">All Products</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-sm  table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px;">S/N</th>
                        <th>Product</th>
                        <th>Type</th>
                        <th>Link</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $product->thumbnail ? asset('uploads/'.$product->thumbnail) : asset('assets/img/placeholder.png') }}"
                                     class="rounded me-3" width="48" height="48" style="object-fit:cover;">
                                <div>
                                    <h6 class="mb-0">{{ $product->title }}</h6>
                                    <small class="text-muted">{{ Str::limit($product->description, 40) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $product->type === 'software' ? 'bg-label-info' : 'bg-label-warning' }} text-capitalize">
                                {{ $product->type }}
                            </span>
                        </td>
                        <td>
                            @if($product->link)
                                <a href="{{ $product->link }}" target="_blank" class="text-primary">
                                    <i class="icon-base bx bx-link-external"></i> Visit
                                </a>
                            @else
                                <span class="text-muted">Private</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.product.toggle-status', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    onclick="return confirm('Change status of this product?')"
                                    class="btn btn-sm {{ $product->status ? 'btn-success' : 'btn-danger' }}">
                                    {{ $product->status ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.product.show', $product->id) }}" class="btn btn-icon btn-sm btn-text-info" title="View">
                                <i class="icon-base bx bx-show"></i>
                            </a>
                            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-icon btn-sm btn-text-primary" title="Edit">
                                <i class="icon-base bx bx-edit"></i>
                            </a>
                            <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-icon btn-sm btn-text-danger" title="Delete"
                                    onclick="return confirm('Permanently delete this product?')">
                                    <i class="icon-base bx bx-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="icon-base bx bx-package fs-1 d-block mb-2"></i>
                            No products added yet. Click "Add Product" to get started.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- OFFCANVAS: Create Product -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="createProductOffcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Add New Product</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" placeholder="e.g Student Management System" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="4" placeholder="Short description..."></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Type</label>
                <select class="form-select" name="type" required>
                    <option value="software">Software</option>
                    <option value="website">Website</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Link (optional)</label>
                <input type="text" class="form-control" name="link" placeholder="https://example.com">
            </div>

            <div class="mb-3">
                <label class="form-label">Thumbnail</label>
                <input type="file" class="form-control" name="thumbnail" id="createThumbInput" accept="image/*">
            </div>

            <div class="text-center mb-3">
                <img src="https://dummyimage.com/150x100/f0f0f0/000&text=Preview"
                     class="rounded shadow" width="150" height="100" id="createThumbPreview" style="object-fit:cover;">
            </div>

            <button class="btn btn-primary w-100">
                <i class="icon-base bx bx-save me-1"></i> Save Product
            </button>
        </form>
    </div>
</div>

<script>
    document.getElementById('createThumbInput')?.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('createThumbPreview').src = URL.createObjectURL(file);
        }
    });
</script>

@endsection