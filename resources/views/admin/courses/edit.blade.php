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

                <img src="{{ $course->thumbnail ? asset('storage/'.$course->thumbnail) : '' }}"
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
                    <p><i class="bx bx-user"></i> Enrolled Students: {{ $course->students_count ?? 0 }}</p>
                    <p><i class="bx bx-calendar"></i> Created: {{ $course->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>


        {{-- ================= Edit Form ================= --}}
        <div class="col-md-8">
            <div class="card shadow-sm p-3">
                <h5 class="fw-bold mb-3">Edit Course Details</h5>

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

                        {{-- Instructor --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Instructor</label>
                            <select name="instructor_id" class="form-select">
                                <option value="">Select Instructor</option>

                                @foreach($instructors as $instructor)
                                <option value="{{ $instructor->id }}"
                                    {{ $course->instructor_id == $instructor->id ? 'selected' : '' }}>
                                    {{ $instructor->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Price --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price</label>
                            <input type="number"
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
                                <option value="draft" {{ $course->status=='draft' ? 'selected':'' }}>Draft</option>
                                <option value="published" {{ $course->status=='published' ? 'selected':'' }}>Published</option>
                            </select>
                        </div>

                        {{-- Thumbnail --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Thumbnail (Optional)</label>
                            <input type="file" class="form-control" id="thumbnailInput" name="thumbnail">
                        </div>

                        {{-- Preview --}}
                        <div class="mx-auto" style="max-height:150px;max-width:150px;">
                            <img id="previewImage"
                                 src="{{ $course->thumbnail ? asset('storage/'.$course->thumbnail) : '' }}"
                                 style="{{ $course->thumbnail ? 'display:block' : 'display:none' }};
                                     width:100%; height:100%; object-fit:cover; border-radius:10px;">
                        </div>

                        {{-- Description --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Course Description</label>
                            <textarea class="form-control" name="description" rows="5" id="editor">
                                {!! old('description', $course->description) !!}
                            </textarea>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2">

                        <button type="reset" class="btn btn-secondary">
                            <i class="bx bx-reset"></i> Reset
                        </button>

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
ClassicEditor.create(document.querySelector('#editor')).catch(error => console.error(error));
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

@endsection
