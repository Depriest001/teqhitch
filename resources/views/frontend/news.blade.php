@extends('frontLayout')
@section('title','News - Teqhitch ICT Academy LTD')

@section('content')

{{-- ============ HERO / News HEADER ============ --}}
<div class="container-fluid pt-5 hero-header">
    <div class="container pt-5 pb-4">
        <div class="d-flex align-items-center justify-content-center gap-2 mb-3 animated slideInUp">
            <span class="btn btn-sm border rounded-pill text-white">News & Updates</span>
        </div>
        <div class="col-md-8 offset-md-2 text-center mb-4">
            <h1 class="text-white mb-3 animated slideInUp">
                Latest News & Insights
            </h1>
            <p class="text-white pb-2 animated slideInUp">
                Stay up to date with the latest tech trends, academy announcements, 
                success stories, and industry insights from Teqhitch ICT Academy.
            </p>
        </div>
    </div>
</div>
<!-- Hero End -->

<!-- News Start -->
<section class="news-section py-3">
    <div class="container py-4">
        
        <div class="wow fadeIn" data-wow-delay="0.1s">            
            <div class="btn btn-sm border rounded-pill text-white px-3 mb-3">Latest Updates</div>
            <h3 class="fw-bold">Latest News &amp; Insights</h3>
        </div>

        
        <div class="row g-4 wow slideInUp" data-wow-delay="0.1s">
            @forelse($news as $item)
                <div class="col-sm-6 col-lg-4">
                    <a href="{{ route('news.detail', $item->slug) }}" class="news-card">
                        <div class="news-card-top">
                            <div class="news-card-icon">
                                <i class="{{ $item->icon ?? 'fas fa-newspaper' }}"></i>
                            </div>
                            @isset($item->category)
                                <span class="news-tag font-mono {{ $item->tag_class }}">{{ Str::upper($item->category) }}</span>
                            @endisset
                        </div>
                        <div class="news-card-body">
                            <h4 class="news-card-title">{{ $item->title }}</h4>
                            <p class="news-card-excerpt">{{ Str::limit($item->excerpt, 110) }}</p>
                        </div>
                        <div class="news-card-footer">
                            <span class="font-mono news-card-date">{{ $item->published_at->format('M d, Y') }}</span>
                            <span class="news-card-link font-mono">
                                Read more <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted mb-0">No news posted yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
<!-- News End -->

@endsection