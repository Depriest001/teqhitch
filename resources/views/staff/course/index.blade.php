@extends('staffdashboardLayout')
@section('title','My Courses | Teqhitch ICT Academy LTD')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">My Courses</h4>
            <p class="text-muted mb-0">Manage all the courses you are currently teaching</p>
        </div>

    </div>

    <!-- Filters -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET">

                <div class="row g-3 align-items-center">

                    <!-- Search -->
                    <div class="col-lg-4 col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bx bx-search"></i>
                            </span>
                            <input type="text"
                                name="search"
                                class="form-control"
                                value="{{ request('search') }}"
                                placeholder="Search course...">
                        </div>
                    </div>

                    <!-- Sort -->
                    <div class="col-lg-3 col-md-6">
                        <select name="sort" class="form-select">
                            <option value="" disabled {{ request('sort') ? '' : 'selected' }}>
                                Sort By
                            </option>

                            <option value="newest" {{ request('sort')=='newest' ? 'selected':'' }}>
                                Newest
                            </option>

                            <option value="oldest" {{ request('sort')=='oldest' ? 'selected':'' }}>
                                Oldest
                            </option>

                            <option value="most_students" {{ request('sort')=='most_students' ? 'selected':'' }}>
                                Most Students
                            </option>
                        </select>
                    </div>
                    
                    <!-- Apply -->
                    <div class="col-lg-2 col-md-6 text-md-end">
                        <button class="btn btn-outline-secondary w-100">
                            <i class="bx bx-filter-alt"></i> Apply Filter
                        </button>
                    </div>

                    <!-- Refresh -->
                    <div class="col-lg-2 col-md-6 text-md-end">
                        <a href="{{ route('staff.courses.index') }}" class="btn btn-outline-dark w-100">
                            <i class="bx bx-refresh me-1"></i> Refresh
                        </a>
                    </div>

                </div>

            </form>
        </div>
    </div>

    <!-- Courses List -->
    <div class="row g-3">
        @forelse($courses as $course)
        <div class="col-xl-4 col-lg-6">
            <div class="card shadow-sm border-0 h-100">

                <img src="{{ $course->thumbnail ? asset('storage/'.$course->thumbnail) : 'https://via.placeholder.com/400x200' }}"
                    class="card-img-top"
                    style="height:160px; object-fit:cover;"
                    alt="">

                <div class="card-body">
                    <span class="badge bg-success mb-2">
                        {{ ucfirst($course->status ?? 'active') }}
                    </span>

                    <h6 class="fw-bold mb-2">{{ $course->title }}</h6>

                    <p class="text-muted small mb-2">
                        {{ Str::limit(strip_tags($course->description), 120) }}
                    </p>

                    <div class="d-flex justify-content-between text-muted small mb-3">
                        <span><i class="bx bx-user"></i> {{ $course->students_count ?? 0 }} Students</span>
                        <span><i class="bx bx-time"></i> {{ $course->duration ?? '—' }}</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('staff.courses.show', $course->id) }}"
                        class="btn btn-dark btn-sm">
                            <i class="bx bx-cog me-1"></i> Manage
                        </a>
                    </div>

                </div>
            </div>
        </div>
        @empty
            <div class="text-center py-5">
                <h5 class="text-muted">No courses assigned to you yet</h5>
            </div>
        @endforelse

        </div>

        <div class="mt-4">
            {{ $courses->links() }}
        </div>

</div>

@endsection
