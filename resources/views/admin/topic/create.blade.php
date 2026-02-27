@extends('admindashboardLayout')
@section('title','Create Topic | Teqhitch ICT Academy LTD')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Create New Topic</h4>
            <p class="text-muted mb-0">Add a new seminar or project topic</p>
        </div>

        <a href="{{ route('admin.topics.index') }}" class="btn btn-sm  btn-outline-secondary">
            <i class="bx bx-arrow-back"></i> Back to Topics
        </a>
    </div>

    {{-- Card --}}
    <div class="card col-md-10 offset-md-1">
        <div class="card-body">

            <form action="{{ route('admin.topics.store') }}" method="POST">
                @csrf

                <div class="row g-3">

                    {{-- Topic Title --}}
                    <div class="col-md-12">
                        <label class="form-label">Topic Title <span class="text-danger">*</span></label>
                        <input type="text" name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}"
                               placeholder="Enter topic title" required>

                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Department Title --}}
                    <div class="col-md-12">
                        <label class="form-label">Department <span class="text-danger">*</span></label>
                        <input type="text" name="department"
                               class="form-control @error('department') is-invalid @enderror"
                               value="{{ old('title') }}"
                               placeholder="Enter Department" required>

                        @error('department')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        <textarea name="description"
                                  rows="4"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Optional description...">{{ old('description') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Academic Level --}}
                    <div class="col-md-6">
                        <label class="form-label">Academic Level <span class="text-danger">*</span></label>
                        <select name="academic_level"
                                class="form-select @error('academic_level') is-invalid @enderror" required>
                            <option value="" selected disabled>Select Level</option>
                            <option value="BSc" {{ old('academic_level') == 'BSc' ? 'selected' : '' }}>B.Sc</option>
                            <option value="MSc" {{ old('academic_level') == 'MSc' ? 'selected' : '' }}>M.Sc</option>
                            <option value="PhD" {{ old('academic_level') == 'PhD' ? 'selected' : '' }}>Ph.D</option>
                        </select>

                        @error('academic_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Paper Type --}}
                    <div class="col-md-6">
                        <label class="form-label">Paper Type <span class="text-danger">*</span></label>
                        <select name="paper_type"
                                class="form-select @error('paper_type') is-invalid @enderror" required>
                            <option value="" selected disabled>Select Type</option>
                            <option value="seminar" {{ old('paper_type') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                            <option value="project" {{ old('paper_type') == 'project' ? 'selected' : '' }}>Project</option>
                        </select>

                        @error('paper_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- Submit --}}
                <div class="mt-4 d-flex justify-content-end">
                    <button type="reset" class="btn btn-light me-2">
                        Reset
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save"></i> Save Topic
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
