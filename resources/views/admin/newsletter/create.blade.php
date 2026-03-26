@extends('admindashboardLayout') 

@section('title','Create Newsletter | Teqhitch ICT Academy LTD')

@section('content')
<style>
.ck-editor__editable {
    height: 300px !important;
    max-height: 400px;
    overflow-y: auto;
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
    <div class="d-md-flex d-block justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Create Newsletter</h4>
            <span class="text-muted">Compose a new newsletter to send to subscribers</span>
        </div>
        <a href="{{ route('admin.newsletter.index') }}" class="btn btn-sm btn-secondary mt-2 mt-md-0">
            <i class="bx bx-arrow-back"></i> Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.newsletter.store') }}" method="POST">
                @csrf

                <!-- Subject -->
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter newsletter subject" required>
                </div>
                
                <!-- status -->
                <div class="mb-3">
                    <label for="status" class="form-label">status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="draft" selected>Draft</option>
                        <option value="scheduled">Scheduled</option>
                    </select>
                </div>

                <!-- Scheduled Date & Time -->
                <div class="mb-3" id="scheduleContainer" style="display: none;">
                    <label for="send_at" class="form-label">Scheduled Date & Time</label>
                    <input 
                        type="datetime-local" 
                        class="form-control" 
                        id="send_at" 
                        name="send_at"
                        min="{{ now()->format('Y-m-d\TH:i') }}"
                    >

                    <small class="text-muted">
                        Choose a future date and time for sending this newsletter.
                    </small>
                </div>

                <!-- url -->
                <div class="mb-3">
                    <label for="url" class="form-label">Url</label>
                    <input type="url" class="form-control" id="url" name="url" placeholder="Enter Mail Url">
                </div>

                <!-- Button Text -->
                <div class="mb-3">
                    <label for="Button_text" class="form-label">Button Text</label>
                    <input type="text" class="form-control" id="Button_text" name="url_text" placeholder="Enter Mail Button Text">
                </div>

                <!-- Newsletter Content -->
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea id="content" name="content" class="form-control" rows="10"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-send"></i> Publish Newsletter
                </button>
            </form>
        </div>
    </div>

</div>

<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {

    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => console.error(error));

    // Show/Hide Schedule Date field
    const statusSelect = document.getElementById('status');
    const scheduleContainer = document.getElementById('scheduleContainer');
    statusSelect.addEventListener('change', function() {
        if (this.value === 'scheduled') {
            scheduleContainer.style.display = 'block';
        } else {
            scheduleContainer.style.display = 'none';
        }
    });

});
</script>
@endsection