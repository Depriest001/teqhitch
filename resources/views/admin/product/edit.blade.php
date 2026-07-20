@extends('admindashboardLayout')
@section('title','Edit Product | Teqhitch ICT Academy LTD')

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
            <h4 class="fw-bold mb-1">Edit Product</h4>
            <p class="text-muted mb-0">Update details for "{{ $product->title }}"</p>
        </div>
        <a href="{{ route('admin.product.index') }}" class="btn btn-label-secondary">
            <i class="icon-base bx bx-arrow-back me-1"></i> Back to Products
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" value="{{ $product->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="4">{{ $product->description }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Type</label>
                                <select class="form-select" name="type" required>
                                    <option value="software" {{ $product->type === 'software' ? 'selected' : '' }}>Software</option>
                                    <option value="website" {{ $product->type === 'website' ? 'selected' : '' }}>Website</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Link (optional)</label>
                                <input type="text" class="form-control" name="link" value="{{ $product->link }}" placeholder="https://example.com">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Change Thumbnail</label>
                            <input type="file" class="form-control" name="thumbnail" id="editThumbInput" accept="image/*">
                        </div>

                        <button class="btn btn-primary">
                            <i class="icon-base bx bx-save me-1"></i> Update Product
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Thumbnail Preview</h6>
                </div>
                <div class="card-body text-center">
                    <img id="editThumbPreview"
                        src="{{ $product->thumbnail ? asset('uploads/'.$product->thumbnail) : asset('assets/img/placeholder.png') }}"
                        class="img-fluid rounded shadow mb-2" style="object-fit:cover; max-height:200px;">
                    <p class="text-muted small mb-0">Upload a new image above to replace it.</p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Status</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.product.toggle-status', $product->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <p class="mb-2">
                            Current status:
                            <span class="badge {{ $product->status ? 'bg-label-success' : 'bg-label-danger' }}">
                                {{ $product->status ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                        <button type="submit" class="btn btn-sm {{ $product->status ? 'btn-warning' : 'btn-success' }} w-100"
                            onclick="return confirm('Change status of this product?')">
                            {{ $product->status ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('editThumbInput')?.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('editThumbPreview').src = URL.createObjectURL(file);
        }
    });
</script>

@endsection