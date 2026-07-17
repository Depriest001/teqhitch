@extends('admindashboardLayout')
@section('title','Create News Post | Teqhitch ICT Academy LTD')

@section('content')
<style>
.ck-editor__editable_inline {
    height: 300px; /* Set your desired fixed height */
    overflow-y: auto; /* Adds a scrollbar if the content exceeds the height */
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    @if (session('success') || session('error') || $errors->any())
        <div id="appToast"
            class="bs-toast toast fade show position-fixed top-0 end-0 m-3
            {{ session('success') ? 'bg-success' : (session('error') ? 'bg-danger' : 'bg-warning') }}"
            role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header text-white">
                <i class="icon-base bx bx-bell me-2"></i>
                <div class="me-auto fw-medium">
                @if (session('success')) Success
                @elseif (session('error')) Error
                @else Validation
                @endif
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body text-white">
                @if (session('success')) {{ session('success') }}
                @elseif (session('error')) {{ session('error') }}
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
            <h4 class="fw-bold mb-1">Create News Post</h4>
            <p class="text-muted mb-0">Add a new article to the news feed.</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="btn btn-label-secondary">
            <i class="icon-base bx bx-arrow-back me-1"></i> Back to List
        </a>
    </div>

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Main Column -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Content</h6></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                class="form-control @error('title') is-invalid @enderror" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Excerpt (shown on cards) <span class="text-danger">*</span></label>
                            <textarea name="excerpt" rows="2"
                                class="form-control @error('excerpt') is-invalid @enderror" required>{{ old('excerpt') }}</textarea>
                            @error('excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-1">
                            <label class="form-label">Body <span class="text-danger">*</span></label>
                            <textarea name="body" id="editor" class="@error('body') is-invalid @enderror">{{ old('body') }}</textarea>
                            @error('body') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="col-lg-4">

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Details</h6></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select">
                                <option value="Announcement">Announcement</option>
                                <option value="Event">Event</option>
                                <option value="Partnership">Partnership</option>
                                <option value="Update">Update</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Icon (FontAwesome class)</label>
                            <input type="text" name="icon" value="{{ old('icon') }}"
                                class="form-control" placeholder="fas fa-graduation-cap">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Author</label>
                            <input type="text" name="author" value="{{ old('author', 'Teqhitch Team') }}"
                                class="form-control">
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Cover Image</h6></div>
                    <div class="card-body">
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted d-block mt-2">Recommended: 1200×630px, max 4MB.</small>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><h6 class="mb-0">Publish</h6></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="is_published" class="form-select">
                                <option value="1" selected>Published</option>
                                <option value="0">Draft</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="icon-base bx bx-check me-1"></i> Publish Post
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#editor'), {
        
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'leadParagraph', // Give it a unique model name
                    view: { 
                        name: 'p', 
                        classes: 'lead-paragraph' 
                    }, 
                    title: 'Lead Paragraph', class: 'ck-heading_lead' 
                },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'h1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'h2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'h3' }, // Standard H3
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'h4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'h5' },
                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'h6' }
            ]
        }
    })
    .catch(error => console.error(error));
</script>
@endsection