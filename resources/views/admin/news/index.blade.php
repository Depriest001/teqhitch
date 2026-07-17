@extends('admindashboardLayout')
@section('title','Manage News | Teqhitch ICT Academy LTD')

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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">News &amp; Updates</h4>
            <p class="text-muted mb-0">Manage articles shown on the homepage and news page.</p>
        </div>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="icon-base bx bx-plus me-1"></i> New Post
        </a>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="table table-sm table-hover align-middle" id="exampleTable">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th style="width: 70px;">Cover</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Published</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $item)
                        <tr>
                            <td class="text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                                    class="rounded" style="width:48px;height:48px;object-fit:cover;">
                            </td>
                            <td>
                                <span class="fw-medium">{{ Str::limit($item->title, 45) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-label-primary">{{ $item->category ?? '—' }}</span>
                            </td>
                            <td>{{ $item->author ?? '—' }}</td>
                            <td>
                                <span class="small">{{ $item->published_at?->format('M d, Y') ?? '—' }}</span>
                            </td>
                            <td>
                                @if($item->is_published)
                                    <span class="badge bg-label-success">Published</span>
                                @else
                                    <span class="badge bg-label-secondary">Draft</span>
                                @endif
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.news.show', $item) }}" class="btn btn-icon btn-sm btn-text-secondary rounded-pill" title="View">
                                    <i class="icon-base bx bx-show"></i>
                                </a>
                                <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-icon btn-sm btn-text-secondary rounded-pill" title="Edit">
                                    <i class="icon-base bx bx-edit-alt"></i>
                                </a>
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
                                                <h5>Delete this post?</h5>
                                                <p class="text-muted">"{{ $item->title }}" will be permanently removed. This can't be undone.</p>
                                                <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-flex justify-content-center gap-2 mt-3">
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection