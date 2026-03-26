@extends('admindashboardLayout')

@section('title','View Newsletter | Teqhitch ICT Academy LTD')

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
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold">View Newsletter</h4>
            <span class="text-muted">Newsletter details and content</span>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.newsletter.index') }}" class="btn btn-sm btn-secondary me-2">
                <i class="bx bx-arrow-back"></i> Back
            </a>
            <a href="{{ route('admin.newsletter.edit', $newsletter->id) }}" class="btn btn-sm btn-warning me-2">
                <i class="bx bx-edit"></i> Edit
            </a>
            <form action="{{ route('admin.newsletter.destroy', $newsletter->id) }}" method="POST" class="d-inline" 
                  onsubmit="return confirm('Are you sure you want to delete this newsletter?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger"><i class="bx bx-trash"></i> Delete</button>
            </form>
        </div>
    </div>

    <!-- Newsletter Info -->
    <div class="row mb-4">
        <div class="col-md-4 mb-2 mb-md-0">
            <div class="card shadow-sm p-3 mb-3 h-100">
                <h6 class="text-muted">Subject</h6>
                <p class="fw-semibold">{{ $newsletter->subject }}</p>
            </div>
        </div>
        <div class="col-md-4 col-6">
            <div class="card shadow-sm p-3 mb-3 h-100">
                <h6 class="text-muted">Status</h6>
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
                @if(in_array($newsletter->status, ['draft', 'scheduled']))
                    <a href="{{ route('admin.newsletter.send', $newsletter->id) }}"
                        class="btn btn-primary btn-sm mt-2"
                        onclick="return confirm('Send this newsletter now?');">
                        Send Now
                    </a>
                @endif
            </div>
        </div>
        <div class="col-md-4 col-6">
            <div class="card shadow-sm p-3 mb-3 h-100">
                <h6 class="text-muted">Scheduled At</h6>
                <p>{{ $newsletter->send_at ? $newsletter->send_at->format('M d, Y H:i') : 'Not Scheduled' }}</p>
            </div>
        </div>
    </div>

    <!-- Newsletter Content -->
    <div class="card shadow-sm"> 
        <div class="card-header border-bottom">
            <h5 class="mb-0">Content</h5>
        </div>

        <div class="card-body">
            {!! $newsletter->content !!}

            @if(!empty($newsletter->url))
                <div class="mt-3">
                    <strong>Link: </strong><span class="text-wrap">{{ $newsletter->url }}</span> <br>
                    <a href="{{ $newsletter->url }}" 
                    class="btn btn-primary"
                    target="_blank">
                        {{ $newsletter->url_text ?? 'Visit Link' }}
                    </a>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection