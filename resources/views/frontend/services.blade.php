@extends('frontLayout')
@section('title','Courses - Teqhitch ICT Academy LTD')

@section('content')

{{-- ============ HERO / CATALOG HEADER ============ --}}
<div class="container-fluid pt-5 hero-header">
    <div class="container pt-5 pb-4">
        <div class="d-flex align-items-center justify-content-center gap-2 mb-3 animated slideInUp">
            <span class="btn btn-sm border rounded-pill">Catalog</span>
        </div>
        <div class="col-md-8 offset-md-2 text-center mb-4">
            <h1 class="text-white mb-3 animated slideInUp">
                Course Catalog
            </h1>
            <p class="text-white pb-2 animated slideInUp">
                Explore our comprehensive tech training programs, designed to launch
                and accelerate your career in the digital economy.
            </p>
        </div>
    </div>
</div>
<!-- Hero End -->

{{-- ============ SEARCH + FILTER BAR ============ --}}
<section class="py-4 bg-white border-bottom">
    <div class="container">
        <div class="d-flex flex-column flex-lg-row gap-3 align-items-lg-center justify-content-between">

            <div class="position-relative" style="max-width: 340px; width: 100%;">
                <i class="fas fa-search catalog-search-icon"></i>
                <input type="text"
                       id="courseSearch"
                       class="form-control catalog-search-input"
                       placeholder="Search courses or tech stack...">
            </div>

            @php
                $categories = $courses->pluck('category')->filter()->unique()->values() ?? collect();
            @endphp

            @if($categories->count())
                <div class="d-flex flex-wrap gap-2" id="categoryFilters">
                    <button type="button" class="filter-chip active" data-filter="all">All</button>
                    @foreach($categories as $cat)
                        <button type="button" class="filter-chip" data-filter="{{ Str::slug($cat) }}">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</section>

{{-- ============ COURSE LIST (catalog rows) ============ --}}
<section class="py-4 bg-white">
    <div class="container">

        <div id="courseList">
            @forelse($courses as $course)
                <div class="catalog-row"
                     data-title="{{ Str::lower($course->title) }}"
                     data-category="{{ Str::slug($course->category ?? '') }}">

                    <div class="row g-4 align-items-center py-4 border-bottom catalog-row-inner">

                        @if($course->thumbnail ?? false)
                            <div class="col-md-2">
                                <div class="catalog-thumb">
                                    <img src="{{ $course->thumbnail ? asset('uploads/'.$course->thumbnail) : '' }}" alt="{{ $course->title }}">
                                </div>
                            </div>
                        @endif

                        <div class="col-md-7">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="catalog-index">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <i class="{{ $course->icon ?? 'fas fa-graduation-cap' }} catalog-icon"></i>
                                @if($course->level ?? false)
                                    <span class="catalog-level">{{ $course->level }}</span>
                                @endif
                            </div>

                            <h4 class="fw-bold mb-2">{{ $course->title }}</h4>

                            <p class="text-muted mb-3">
                                {{ Str::limit(strip_tags($course->description), 140) }}
                            </p>

                            @if(!empty($course->outcomes))
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($course->outcomes as $outcome)
                                        <span class="catalog-tag">{{ $outcome->content }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="col-md-2 text-md-end">
                            @if($course->price ?? false)
                                <div class="catalog-price">₦{{ number_format($course->price) }}</div>
                            @endif

                            @if($course->duration ?? false)
                                <div class="catalog-duration justify-content-md-end">
                                    <i class="far fa-clock"></i> {{ $course->duration }}
                                </div>
                            @endif

                            <a href="{{ route('enroll') }}"
                               class="btn btn-primary btn-sm mt-2">
                                Enroll Now <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <p class="text-muted text-center py-5">No courses available at the moment.</p>
            @endforelse
        </div>

        <p id="noResults" class="text-muted text-center py-5" style="display:none;">
            No courses match your search.
        </p>

    </div>
</section>

{{-- ============ WHY CHOOSE US ============ --}}
<section class="py-4 feature">
    <div class="container py-4">
        <div class="row g-5 align-items-start">

            <div class="col-lg-5">
                <div class="btn btn-sm border rounded-pill text-primary px-3 mb-3">Why Teqhitch</div>
                <h2 class="fw-bold mb-3" style="color:#fff !important;">
                    Built for people starting from zero — and people leveling up.
                </h2>
                <p class="mb-4" style="color: rgba(255,255,255,.65);">
                    No prior tech background required. Every track pairs
                    structured lessons with real project work, so what you
                    learn on Monday is what you're shipping by Friday.
                </p>
            </div>

            <div class="col-lg-7">
                <div class="feature-visual">
                    <div class="feature-visual-glow"></div>

                    <div class="feature-chip-grid">
                        <div class="feature-chip">
                            <i class="fa fa-check"></i>
                            <span>Industry-built curriculum, updated every cohort</span>
                        </div>
                        <div class="feature-chip">
                            <i class="fa fa-check"></i>
                            <span>Instructors who still ship code professionally</span>
                        </div>
                        <div class="feature-chip">
                            <i class="fa fa-check"></i>
                            <span>Hands-on projects, not just theory</span>
                        </div>
                        <!-- <div class="feature-chip">
                            <i class="fa fa-check"></i>
                            <span>Internship placement support</span>
                        </div> -->
                        <div class="feature-chip">
                            <i class="fa fa-check"></i>
                            <span>Mentorship that continues after graduation</span>
                        </div>
                        <div class="feature-chip">
                            <i class="fa fa-check"></i>
                            <span>Small cohorts, real feedback</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ============ DIGITAL SOLUTIONS ============ --}}
<section class="py-4 bg-white">
    <div class="container">

        <div class="mb-5" style="max-width: 560px;">
            <div class="btn btn-sm border rounded-pill text-primary px-3 mb-3">Solutions</div>
            <h2 class="fw-bold mb-2">Digital Solutions</h2>
            <p class="text-muted mb-0">
                The same instructors who write the curriculum also build for
                real clients. Here's what that team can do for you.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="solution-card h-100">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <span class="solution-id">SOL&nbsp;/&nbsp;01</span>
                        <i class="fas fa-laptop-code solution-icon"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Website Development</h4>
                    <p class="text-muted mb-4">
                        Custom, responsive websites built to convert visitors,
                        not just look good on a screenshot.
                    </p>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="catalog-tag">Laravel</span>
                        <span class="catalog-tag">SEO</span>
                        <span class="catalog-tag">CMS</span>
                    </div>
                    <a href="{{ route('contact') }}" class="solution-link">
                        Start a project <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="solution-card h-100">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <span class="solution-id">SOL&nbsp;/&nbsp;02</span>
                        <i class="fas fa-cogs solution-icon"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Business Software</h4>
                    <p class="text-muted mb-4">
                        Internal tools and platforms shaped around how your
                        team already works, not the other way around.
                    </p>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="catalog-tag">APIs</span>
                        <span class="catalog-tag">Automation</span>
                        <span class="catalog-tag">Dashboards</span>
                    </div>
                    <a href="{{ route('contact') }}" class="solution-link">
                        Start a project <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="solution-card h-100">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <span class="solution-id">SOL&nbsp;/&nbsp;03</span>
                        <i class="fas fa-shopping-cart solution-icon"></i>
                    </div>
                    <h4 class="fw-bold mb-2">E-commerce Development</h4>
                    <p class="text-muted mb-4">
                        Secure storefronts with payments, inventory, and
                        checkout flows that hold up on launch day.
                    </p>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="catalog-tag">Payments</span>
                        <span class="catalog-tag">Inventory</span>
                        <span class="catalog-tag">Analytics</span>
                    </div>
                    <a href="{{ route('contact') }}" class="solution-link">
                        Start a project <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ============ CTA ============ --}}
<section class="py-5" style="background: var(--brand-gradient-dark)">
    <div class="container py-4">
        <div class="row align-items-center g-4">

            <div class="col-lg-7 newsletter-text">
                <div class="btn btn-sm border rounded-pill text-white px-3 mb-3">Enroll</div>
                <h3 class="fw-bold mb-2" style="color:#fff !important;">
                    Start your tech journey today.
                </h3>
                <p class="mb-0" style="color: rgba(255,255,255,.65);">
                    Pick a track, keep your own pace, walk away with a
                    certificate that actually means something.
                </p>
            </div>

            <div class="col-lg-5 text-lg-end">
                <a href="{{ route('enroll') }}" class="btn btn-light px-4 mb-3">
                    Enroll Now <i class="fas fa-arrow-right ms-1"></i>
                </a>
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <span class="catalog-tag" style="background: rgba(255,255,255,.08); border-color: rgba(255,255,255,.2); color: rgba(255,255,255,.75);">Flexible schedule</span>
                    <span class="catalog-tag" style="background: rgba(255,255,255,.08); border-color: rgba(255,255,255,.2); color: rgba(255,255,255,.75);">Beginner friendly</span>
                    <span class="catalog-tag" style="background: rgba(255,255,255,.08); border-color: rgba(255,255,255,.2); color: rgba(255,255,255,.75);">Certificate included</span>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ============ SEARCH + FILTER LOGIC ============ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput   = document.getElementById('courseSearch');
    const filterButtons = document.querySelectorAll('.filter-chip');
    const rows           = document.querySelectorAll('.catalog-row');
    const noResults      = document.getElementById('noResults');

    let activeFilter = 'all';

    function applyFilters() {
        const term = (searchInput?.value || '').toLowerCase().trim();
        let visibleCount = 0;

        rows.forEach(row => {
            const matchesText     = row.dataset.title.includes(term);
            const matchesCategory = activeFilter === 'all' || row.dataset.category === activeFilter;
            const show = matchesText && matchesCategory;

            row.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });

        if (noResults) {
            noResults.style.display = visibleCount === 0 ? '' : 'none';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            activeFilter = this.dataset.filter;
            applyFilters();
        });
    });
});
</script>

@endsection