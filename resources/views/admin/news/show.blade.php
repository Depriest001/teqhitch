@extends('admindashboardLayout')
@section('title','View News Post | Teqhitch ICT Academy LTD')

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
                @endif
            </div>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">View News Post</h4>
            <p class="text-muted mb-0">Read-only preview of the published article.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('news.show', $news) }}" target="_blank" class="btn btn-label-secondary">
                <i class="icon-base bx bx-link-external me-1"></i> View Live
            </a>
            <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-primary">
                <i class="icon-base bx bx-edit-alt me-1"></i> Edit
            </a>
            <a href="{{ route('admin.news.index') }}" class="btn btn-label-secondary">
                <i class="icon-base bx bx-arrow-back me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <img src="{{ $news->image_url }}" class="card-img-top" style="height:320px;object-fit:cover;" alt="{{ $news->title }}">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge bg-label-primary">{{ $news->category ?? 'Uncategorized' }}</span>
                        @if($news->is_published)
                            <span class="badge bg-label-success">Published</span>
                        @else
                            <span class="badge bg-label-secondary">Draft</span>
                        @endif
                    </div>
                    <h3 class="fw-bold mb-3">{{ $news->title }}</h3>
                    <div class="text-muted small mb-4">
                        <i class="icon-base bx bx-calendar me-1"></i> {{ $news->published_at?->format('M d, Y') ?? '—' }}
                        &nbsp;&bull;&nbsp;
                        <i class="icon-base bx bx-user me-1"></i> {{ $news->author ?? 'Teqhitch Team' }}
                    </div>

                    <hr class="my-4">

                    <div class="news-preview-body">
                        {!! $news->body !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header"><h6 class="mb-0">Metadata</h6></div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Slug</td>
                            <td class="text-end">/{{ $news->slug }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Icon</td>
                            <td class="text-end"><code>{{ $news->icon ?? '—' }}</code></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Excerpt</td>
                            <td class="text-end small">{{ $news->excerpt }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created</td>
                            <td class="text-end">{{ $news->created_at->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Last Updated</td>
                            <td class="text-end">{{ $news->updated_at->format('M d, Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection