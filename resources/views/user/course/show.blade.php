@extends('userdashboardLayout')
@section('title','Course Detail | Teqhitch ICT Academy LTD')
@section('content')
<style>

.list-group-item{
    border-radius: 10px;
    margin-bottom: 5px;
    cursor: pointer;
    transition: all 0.2s ease;
}
.list-group-item:hover{
    transform: translateX(5px);
    background-color: #f1f5f9;
}
.sticky-lg-top{
    top: 30px;
}
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Course Header -->
    <div class="mb-4">
        <h3 class="fw-bold">{{ $course->title }}</h3>
        <p class="text-muted">{{ strip_tags($course->description) }}</p>

        <div class="progress rounded-pill" style="height:12px;">
            <div class="progress-bar"
                style="width: {{ $progress }}%; background: linear-gradient(90deg,#0ea5e9,#2563eb);">
            </div>
        </div>
        <small class="text-muted">{{ $progress }}% Completed</small>
    </div>

    <div class="row g-4">
        <!-- Sidebar: Modules -->
        <div class="col-lg-4">
            <div class="card p-3 shadow-sm border-0 sticky-lg-top" style="top:30px;">
                <h5 class="mb-3">Course Modules</h5>
                <div class="list-group">
                @foreach ($modules as $module)

                    @php
                        $status = optional(
                            $enrollment->moduleProgress->firstWhere('module_id', $module->id)
                        )->status ?? 'pending';
                    @endphp

                     <a href="{{ route('user.courses.show', [$course->id, 'module' => $module->id]) }}"
                    class="list-group-item list-group-item-action
                    d-flex justify-content-between align-items-center
                    {{ $currentModule->id === $module->id ? 'active' : '' }}">

                        {{ $module->title }}

                        <span class="badge rounded-pill
                            {{ $status === 'completed' ? 'bg-success' :
                            ($status === 'in_progress' ? 'bg-info' : 'bg-secondary') }}">
                            {{ ucfirst(str_replace('_',' ', $status)) }}
                        </span>
                    </a>

                @endforeach
                </div>
            </div>
        </div>

        <!-- Main Content: Lesson -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 p-4">
                <!-- Tabs -->
                <ul class="nav nav-tabs mb-4 flex-wrap" id="courseTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">Overview</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="resources-tab" data-bs-toggle="tab" data-bs-target="#resources" type="button" role="tab">Resources</button>
                    </li>
                </ul>

                <div class="tab-content" id="courseTabContent">
                    <!-- Overview Tab -->
                    <div class="tab-pane fade show active" id="overview" role="tabpanel">
                        <h5>Lesson: {{ $currentModule->title }}</h5>

                        <p class="text-muted">
                            {{ $currentModule->description }}
                        </p>
                        <small class="text-info">Click the Resources Tab to view Module content</small>
                    </div>

                    <!-- Resources Tab -->
                    <div class="tab-pane fade" id="resources" role="tabpanel">
                        @switch($currentModule->file_type)

                            {{-- PDF --}}
                            @case('pdf')
                                <iframe
                                    src="{{ asset('storage/' . $currentModule->file_path) }}"
                                    width="100%"
                                    height="600"
                                    style="border:none;">
                                </iframe>
                                @break

                            {{-- DOCX & PPT --}}
                            @case('docx')
                            @case('ppt')
                                <iframe
                                    src="https://docs.google.com/gview?url={{ asset('storage/' . $currentModule->file_path) }}&embedded=true"
                                    width="100%"
                                    height="600"
                                    style="border:none;">
                                </iframe>
                                @break

                            {{-- ZIP --}}
                            @case('zip')
                                <div class="alert alert-info">
                                    <i class="bx bx-download me-2"></i>
                                    This lesson contains downloadable resources.
                                </div>

                                <a href="{{ asset('storage/' . $currentModule->file_path) }}"
                                class="btn btn-primary">
                                    Download Resources
                                </a>
                                @break

                        @endswitch
                        
                        @if (
                            optional(
                                $enrollment->moduleProgress
                                    ->firstWhere('module_id', $currentModule->id)
                            )->status !== 'completed'
                        )
                        <form method="POST"
                            action="{{ route('user.module.complete', $currentModule->id) }}">
                            @csrf
                            <button class="btn btn-primary mt-3 px-4 py-2">
                                Mark as Complete
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
