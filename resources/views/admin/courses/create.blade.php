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
        <h4 class="fw-bold">Create a New Course</h4>

        <a href="{{ route('admin.courses.index')}}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card col-md-11 mx-auto shadow-sm p-4">

        <form action="{{ route('admin.courses.store') }}" method="POST"
              enctype="multipart/form-data" class="row">
            @csrf

            {{-- Title --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Course Title *</label>
                <input type="text" name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}"
                        placeholder="Enter course title">

                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Subtitle --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Subtitle</label>
                <input type="text" name="subtitle"
                        class="form-control @error('subtitle') is-invalid @enderror"
                        value="{{ old('subtitle') }}"
                        placeholder="Enter subtitle (optional)">

                @error('subtitle')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Price --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Price (₦)</label>
                <input type="number" step="0.01" name="price"
                        class="form-control @error('price') is-invalid @enderror"
                        value="{{ old('price') }}"
                        placeholder="Enter price">

                @error('price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Duration --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Course Duration *</label>
                <input type="text" name="duration"
                        class="form-control @error('duration') is-invalid @enderror"
                        value="{{ old('duration') }}"
                        placeholder="e.g. 4 Months">

                @error('duration')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Instructor --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Instructor *</label>
                <select name="instructor_id"
                        class="form-select @error('instructor_id') is-invalid @enderror">
                    <option disabled selected>-- Select Instructor --</option>

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

            {{-- Icon --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Course Icon *</label>
                <input type="text" name="icon"
                        class="form-control @error('icon') is-invalid @enderror"
                        value="{{ old('icon') }}"
                        placeholder="e.g. fas fa-code">

                @error('icon')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Category --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Category *</label>
                <input type="text" name="category"
                        class="form-control @error('category') is-invalid @enderror"
                        value="{{ old('category') }}"
                        placeholder="e.g. Web Development">

                @error('category')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Level --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Level *</label>
                <select name="level" class="form-select @error('level') is-invalid @enderror">
                    <option disabled selected>-- Select Level --</option>
                    <option value="Beginner" {{ old('level') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                    <option value="Intermediate" {{ old('level') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option value="Advanced" {{ old('level') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                </select>
                @error('level')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Thumbnail --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Upload Thumbnail *</label>
                <input type="file" name="thumbnail" id="thumbnailInput"
                    class="form-control @error('thumbnail') is-invalid @enderror" required>

                <small class="text-muted">
                    Supported: PNG, JPG, JPEG, WEBP | Max: 2MB
                </small>

                @error('thumbnail')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-3 text-center">
                <div style="max-height:200px;max-width:200px;" class="mx-auto">
                    <img id="previewImage" src="#" alt=""
                         style="display:none; width:100%; height:100%;
                         object-fit:cover; border-radius:10px;">
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>

                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <hr>
            <h5 class="mt-4">Course Curriculum</h5>

            <div id="outcomesWrapper"></div>

            <div class="mb-3">
                <button type="button" class="btn btn-sm btn-outline-success"
                        onclick="addOutcome()">+ Add Curriculum</button>
            </div>

            {{-- Submit --}}
            <div class="col-md-5 mx-auto mt-4">
                <button class="btn btn-primary w-100">
                    <i class="bx bx-save"></i> Create Course
                </button>
            </div>

        </form>
    </div>
</div>

{{-- Thumbnail Preview --}}
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

{{-- Dynamic Features & Outcomes --}}
<script>
let outcomeIndex = 0;

function addOutcome() {
    let html = `
        <div class="row mb-3">
            <div class="col-md-12">
                <input type="text" name="outcomes[${outcomeIndex}][content]" class="form-control" placeholder="Outcome description">
            </div>
        </div>`;
    document.getElementById('outcomesWrapper').insertAdjacentHTML('beforeend', html);
    outcomeIndex++;
}
</script>

@endsection