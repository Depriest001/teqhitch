@extends('admindashboardLayout')
@section('title','Edit Course | Teqhitch ICT Academy LTD')

@section('content')

<style>
.ck-editor__editable {
    height: 300px !important;
    max-height: 400px;
    overflow-y: auto;
}
</style>
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
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold">Edit Course</h4>
            <span class="text-muted">Update course details and settings</span>
        </div>

        <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="row g-4">

        {{-- ================= Preview Card ================= --}}
        <div class="col-md-4">
            <div class="card shadow-sm p-3 text-center">

                <img src="{{ $course->thumbnail ? asset('uploads/'.$course->thumbnail) : '' }}"
                     class="card-img-top"
                     style="height:160px; object-fit:cover;" alt="">

                <h5 class="mb-0 mt-2">{{ $course->title }}</h5>

                <span class="text-muted">
                    Instructor: {{ $course->instructor->name ?? 'Not Assigned' }}
                </span>

                <div class="mt-3">
                    <span class="badge 
                        @if($course->status === 'published') bg-success
                        @elseif($course->status === 'draft') bg-warning
                        @else bg-secondary
                        @endif px-3">
                        {{ ucfirst($course->status) }}
                    </span>
                </div>

                <hr>

                <div class="text-start">
                    <p><i class="bx bx-calendar"></i> Created: {{ $course->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        {{-- ================= Edit Form ================= --}}
        <div class="col-md-8">
            <div class="card shadow-sm p-3">

                <form method="POST"
                      action="{{ route('admin.courses.update', $course->id) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- Title --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Course Title</label>
                            <input type="text"
                                   name="title"
                                   value="{{ old('title', $course->title) }}"
                                   class="form-control">
                        </div>

                        {{-- Subtitle --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Subtitle</label>
                            <input type="text"
                                   name="subtitle"
                                   value="{{ old('subtitle', $course->subtitle) }}"
                                   class="form-control">
                        </div>

                        {{-- Instructor --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Instructor</label>
                            <select name="instructor_id" class="form-select">
                                @foreach($instructors as $instructor)
                                    <option value="{{ $instructor->id }}"
                                        {{ old('instructor_id', $course->instructor_id) == $instructor->id ? 'selected' : '' }}>
                                        {{ $instructor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Price --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price</label>
                            <input type="number"
                                   step="0.01"
                                   name="price"
                                   value="{{ old('price', $course->price) }}"
                                   class="form-control">
                        </div>

                        {{-- Duration --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Course Duration</label>
                            <input type="text"
                                   name="duration"
                                   value="{{ old('duration', $course->duration) }}"
                                   class="form-control">
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="draft" {{ old('status',$course->status)=='draft'?'selected':'' }}>Draft</option>
                                <option value="published" {{ old('status',$course->status)=='published'?'selected':'' }}>Published</option>
                            </select>
                        </div>

                        {{-- Icon and Thumbnail --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icon</label>
                            <input type="text" class="form-control" name="icon" value="{{ old('icon', $course->icon) }}">

                            <label class="form-label">Thumbnail</label>
                            <input type="file" class="form-control" id="thumbnailInput" name="thumbnail">
                        </div>

                        {{-- Image Preview --}}
                        <div class="col-md-6 text-center mb-3">
                            <img id="previewImage"
                                 src="{{ $course->thumbnail ? asset('uploads/'.$course->thumbnail) : '' }}"
                                 style="{{ $course->thumbnail ? 'display:block' : 'display:none' }};
                                 width:150px;height:150px;object-fit:cover;border-radius:10px;">
                        </div>

                        {{-- Description --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="4" class="form-control">{{ old('description', $course->description) }}</textarea>
                        </div>

                        {{-- Overview --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Overview</label>
                            <textarea name="overview" class="form-control" id="editor">
                                {{ old('overview', $course->overview) }}
                            </textarea>
                        </div>

                    </div>

                    {{-- ================= Features ================= --}}
                    <hr>
                    <h5>Course Features</h5>

                    <div id="featuresWrapper">
                        @foreach($course->features as $index => $feature)
                            <div class="row mb-3">
                                <input type="hidden" name="features[{{ $index }}][id]" value="{{ $feature->id }}">
                                <div class="col-md-4">
                                    <input type="text"
                                           name="features[{{ $index }}][title]"
                                           value="{{ $feature->title }}"
                                           class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <input type="text"
                                           name="features[{{ $index }}][description]"
                                           value="{{ $feature->description }}"
                                           class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <input type="text"
                                           name="features[{{ $index }}][icon]"
                                           value="{{ $feature->icon }}"
                                           class="form-control">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-primary mb-3" onclick="addFeature()">+ Add Feature</button>

                    {{-- ================= Outcomes ================= --}}
                    <hr>
                    <h5>Course Outcomes</h5>

                    <div id="outcomesWrapper">
                        @foreach($course->outcomes as $index => $outcome)
                            <div class="row mb-3">
                                <input type="hidden" name="outcomes[{{ $index }}][id]" value="{{ $outcome->id }}">
                                <div class="col-md-12">
                                    <input type="text"
                                           name="outcomes[{{ $index }}][content]"
                                           value="{{ $outcome->content }}"
                                           class="form-control">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-success mb-3" onclick="addOutcome()">+ Add Outcome</button>

                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-primary">
                            <i class="bx bx-save"></i> Update Course
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#editor'));
</script>

{{-- Image Preview --}}
<script>
document.getElementById('thumbnailInput').addEventListener('change', function (event) {
    const image = document.getElementById('previewImage');
    const file = event.target.files[0];
    if (file) {
        image.src = URL.createObjectURL(file);
        image.style.display = 'block';
    }
});
</script>

{{-- Dynamic Add --}}
<script>
let featureIndex = {{ $course->Features->count() }};
let outcomeIndex = {{ $course->outcomes->count() }};

function addFeature() {
    let html = `
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="features[${featureIndex}][title]" class="form-control" placeholder="Feature Title">
            </div>
            <div class="col-md-4">
                <input type="text" name="features[${featureIndex}][description]" class="form-control" placeholder="Feature Description">
            </div>
            <div class="col-md-3">
                <input type="text" name="features[${featureIndex}][icon]" class="form-control" placeholder="Icon">
            </div>
        </div>`;
    document.getElementById('featuresWrapper').insertAdjacentHTML('beforeend', html);
    featureIndex++;
}

function addOutcome() {
    let html = `
        <div class="row mb-3">
            <div class="col-md-12">
                <input type="text" name="outcomes[${outcomeIndex}][content]" class="form-control" placeholder="Outcome">
            </div>
        </div>`;
    document.getElementById('outcomesWrapper').insertAdjacentHTML('beforeend', html);
    outcomeIndex++;
}
</script>

@endsection