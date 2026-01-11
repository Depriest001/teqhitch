@extends('admindashboardLayout')
@section('title','Create a New Course | Teqhitch ICT Academy LTD')

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
        <h4 class="fw-bold">Create a New Course</h4>

        <a href="{{ route('admin.courses.index')}}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card col-md-10 mx-auto shadow-sm p-4">

        <form action="{{ route('admin.courses.store') }}" method="POST"
              enctype="multipart/form-data" class="row">
            @csrf

            {{-- Title --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Course Title</label>
                <input type="text" name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}"
                        placeholder="Enter course title">

                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Price --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Price (₦)</label>
                <input type="number" name="price"
                        class="form-control @error('price') is-invalid @enderror"
                        value="{{ old('price') }}"
                        placeholder="Enter price">

                @error('price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            
            {{-- Duration --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Course Duration</label>
                <input type="text" name="duration"
                        class="form-control @error('duration') is-invalid @enderror"
                        value="{{ old('duration') }}"
                        placeholder="Enter course duration">

                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Instructor --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Instructor</label>
                <select name="instructor_id"
                        class="form-select @error('instructor_id') is-invalid @enderror">
                    <option selected disabled>-- Select Instructor --</option>

                    @foreach($instructors as $instructor)
                        <option value="{{ $instructor->id }}"
                            {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                            {{ $instructor->name }}
                        </option>
                    @endforeach
                </select>

                @error('instructor_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Thumbnail --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Upload Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnailInput"
                    class="form-control @error('thumbnail') is-invalid @enderror">

                <small class="text-muted">
                    Supported: PNG, JPG, JPEG, WEBP | Max: 2MB
                </small>

                @error('thumbnail')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mx-auto" style="max-height:200px;max-width:200px;">
                <img id="previewImage" src="#" alt="" style="display:none; width:100%; height:100%; object-fit:cover; border-radius:10px;">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>

                <textarea name="description" id="editor"
                    class="form-control @error('description') is-invalid @enderror">
                    {{ old('description') }}
                </textarea>

                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- SUBMIT --}}
            <div class="col-md-5 mx-auto">
                <button class="btn btn-primary w-100">
                    <i class="bx bx-save"></i> Create Course
                </button>
            </div>
        </form>

    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => console.error(error));
</script>
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
