@extends('admindashboardLayout')
@section('title','Edit Topic | Admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-4 gap-2">

        <div>
            <h4 class="fw-bold mb-1">Edit Topic</h4>
            <small class="text-muted">Update topic information and status</small>
        </div>

        {{-- Buttons Container --}}
        <div class="d-flex gap-2 mt-2 mt-md-0 ms-md-3">
            <a href="{{ route('admin.topics.show',$topic->id) }}" 
            class="btn btn-outline-secondary flex-fill flex-md-auto">
                <i class="bx bx-arrow-back"></i> Back
            </a>

            <button type="submit" form="editTopicForm"
                    class="btn btn-primary flex-fill flex-md-auto">
                <i class="bx bx-save fs-5 me-1"></i> Save Changes
            </button>
        </div>

    </div>

    {{-- Form Card --}}
    <div class="card shadow-sm col-md-10 offset-md-1">
        <div class="card-body">

            <form id="editTopicForm" 
                  action="{{ route('admin.topics.update', $topic->id) }}" 
                  method="POST">
                @csrf
                @method('PUT')

                {{-- Title --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Topic Title</label>
                    <input type="text" 
                           name="title" 
                           class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title', $topic->title) }}" 
                           required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Department --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Department</label>
                    <input type="text" 
                           name="department" 
                           class="form-control @error('department') is-invalid @enderror" 
                           value="{{ old('department', $topic->department) }}" 
                           required>
                    @error('department')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" 
                              class="form-control @error('description') is-invalid @enderror" 
                              rows="4">{{ old('description', $topic->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Academic Level --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Academic Level</label>
                    <select name="academic_level" 
                            class="form-select @error('academic_level') is-invalid @enderror" 
                            required>
                        <option value="BSc" {{ $topic->academic_level == 'BSc' ? 'selected' : '' }}>B.Sc</option>
                        <option value="MSc" {{ $topic->academic_level == 'MSc' ? 'selected' : '' }}>M.Sc</option>
                        <option value="PhD" {{ $topic->academic_level == 'PhD' ? 'selected' : '' }}>Ph.D</option>
                    </select>
                    @error('academic_level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Paper Type --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Type</label>
                    <select name="paper_type" 
                            class="form-select @error('paper_type') is-invalid @enderror" 
                            required>
                        <option value="seminar" {{ $topic->paper_type == 'seminar' ? 'selected' : '' }}>Seminar</option>
                        <option value="project" {{ $topic->paper_type == 'project' ? 'selected' : '' }}>Project (Software)</option>
                    </select>
                    @error('paper_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="active" {{ $topic->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $topic->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
