@extends('admindashboardLayout')

@section('title','Edit Newsletter | Teqhitch ICT Academy LTD')

@section('content')
<style>
.ck-editor__editable {
    height: 300px !important;
    max-height: 400px;
    overflow-y: auto;
}
</style>
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Edit Newsletter</h4>
            <span class="text-muted">Update your newsletter details and content</span>
        </div>
        <a href="{{ route('admin.newsletter.index') }}" class="btn btn-sm btn-secondary">
            <i class="bx bx-arrow-back"></i> Back to List
        </a>
    </div>

    <!-- Edit Form -->
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.newsletter.update', $newsletter->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Subject -->
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" 
                           value="{{ old('subject', $newsletter->subject) }}" placeholder="Enter newsletter subject" required>
                </div>

                <!-- url -->
                <div class="mb-3">
                    <label for="url" class="form-label">Url</label>
                    <input type="url" class="form-control" id="url" name="url"
                        value="{{ old('url', $newsletter->url) }}" placeholder="Enter Mail Url">
                </div>

                <!-- Button Text -->
                <div class="mb-3">
                    <label for="Button_text" class="form-label">Button Text</label>
                    <input type="text" class="form-control" id="Button_text" name="url_text"
                        value="{{ old('url_text', $newsletter->url_text) }}" placeholder="Enter Mail Button Text">
                </div>
                
                <!-- status -->
                <div class="mb-3">
                    <label for="status" class="form-label">status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="draft" {{ old('status', $newsletter->status ?? '') == 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>

                        <option value="scheduled" {{ old('status', $newsletter->status ?? '') == 'scheduled' ? 'selected' : '' }}>
                            Scheduled
                        </option>

                        <option value="sending" {{ old('status', $newsletter->status ?? '') == 'sending' ? 'selected' : '' }}>
                            Sending
                        </option>

                        <option value="completed" {{ old('status', $newsletter->status ?? '') == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>
                    </select>
                </div>

                <!-- Schedule -->
                <div class="mb-3" id="scheduleContainer" 
                     style="{{ $newsletter->status == 'scheduled' ? 'display:block;' : 'display:none;' }}">
                    <label for="send_at" class="form-label">Scheduled Date & Time</label>
                    <input type="datetime-local" class="form-control" id="send_at" name="send_at"
                           value="{{ $newsletter->send_at ? $newsletter->send_at->format('Y-m-d\TH:i') : '' }}">
                </div>

                <!-- Newsletter Content -->
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea id="content" name="content" class="form-control" rows="10">{{ old('content', $newsletter->content) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-save"></i> Update Newsletter
                </button>
            </form>
        </div>
    </div>

</div>
<!-- TinyMCE CDN -->
<<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {

    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => console.error(error));

    // Show/Hide Schedule field based on status
    const statusSelect = document.getElementById('status');
    const scheduleContainer = document.getElementById('scheduleContainer');
    statusSelect.addEventListener('change', function() {
        scheduleContainer.style.display = (this.value === 'scheduled') ? 'block' : 'none';
    });

});
</script>
@endsection