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

                <span class="text-muted d-block">
                    Instructor: {{ $course->instructor->name ?? 'Not Assigned' }}
                </span>

                <div class="mt-2">
                    <span class="badge bg-light text-dark border me-1">{{ $course->category ?? 'No Category' }}</span>
                    <span class="badge bg-light text-primary border">{{ $course->level ?? 'No Level' }}</span>
                </div>

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

                        {{-- Category --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category *</label>
                            <input type="text" name="category"
                                   value="{{ old('category', $course->category) }}"
                                   class="form-control @error('category') is-invalid @enderror"
                                   placeholder="e.g. Web">
                        </div>

                        {{-- Level --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Level *</label>
                            <select name="level" class="form-select @error('level') is-invalid @enderror">
                                <option disabled>-- Select Level --</option>
                                <option value="beginner" {{ strtolower(old('level', $course->level)) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ strtolower(old('level', $course->level)) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ strtolower(old('level', $course->level)) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>

                            @error('level')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
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

                    </div>
                    <hr>

                    {{-- ================= Curriculum ================= --}}
                    <hr>
                    <h5>Course Curriculum</h5>

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

                    <button type="button" class="btn btn-sm btn-outline-success" onclick="addOutcome()">+ Add Outcome</button>

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
let outcomeIndex = {{ $course->outcomes->count() }};

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