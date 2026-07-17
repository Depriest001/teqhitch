@extends('frontLayout')
@section('title','News Details - Teqhitch ICT Academy LTD')
@section('content')

    <!-- Hero Header Start -->
    <div class="container-fluid hero-header py-5 mb-3">
        <div class="container py-5 animated slideInUp">
            <div class="news-detail-eyebrow font-mono">
                <span>{{ Str::upper($news->category) }}</span>
            </div>            
            <h1 class="mb-3">{{ $news->title }}</h1>
            <div class="news-detail-meta">
                <span><i class="far fa-calendar"></i> {{ $news->published_at->format('M d, Y') }}</span>
                <span><i class="far fa-user"></i> {{ $news->author ?? 'Teqhitch Team' }}</span>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 mt-3">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('news') }}">News</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $news->slug }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Hero Header End -->

    <!-- Article Start -->
    <div class="container-fluid py-3">
        <div class="container py-5">
            <div class="row g-5">

                <!-- Main Article -->
                <div class="col-lg-8">
                    <div class="news-detail-cover mb-4 animated slideInUp">
                        <img src="{{ $news->image_url }}" class="img-fluid" alt="{{ $news->title }}" class="img-fluid">
                    </div>
                    <article class="news-detail-body wow fadeIn" data-wow-delay="0.1s">
                        {!! $news->body !!}
                    </article>

                    <!-- Tags -->
                    <div class="news-detail-tags wow fadeIn" data-wow-delay="0.1s">
                        @php
                            // 1. Split title into words, clean them, and filter out short filler words
                            $tags = collect(explode(' ', $news->title))
                                ->map(fn($word) => trim(preg_replace('/[^A-Za-z0-9]/', '', $word))) // Remove punctuation
                                ->filter(fn($word) => strlen($word) > 3) // Exclude short words like "the", "and", "is"
                                ->unique() // Remove duplicate words if any exist in the title
                                ->take(5); // Limit to a maximum of 5 tags
                        @endphp

                        @foreach($tags as $tag)
                            <span class="tech-tag font-mono">{{ ucwords(strtolower($tag)) }}</span>
                        @endforeach
                        <span class="tech-tag font-mono">{{ $news->category }}</span>
                    </div>

                    <!-- Share -->
                    <div class="news-detail-share">
                        <span class="font-mono wow fadeIn" data-wow-delay="0.1s">SHARE THIS ARTICLE</span>
                        <div class="d-flex wow bounceIn" data-wow-delay="0.1s">
                            @php
                                $shareUrl = urlencode(route('news.detail', $news->slug));
                                $shareTitle = urlencode($news->title);
                                $shareMessage = urlencode("Check out this article from Teqhitch ICT Academy: \"{$news->title}\"");
                                $whatsappMessage = urlencode("Check out this article from Teqhitch ICT Academy:\n\n\"{$news->title}\"\n\n{$news->excerpt}\n\nRead more here:");
                            @endphp

                            <a class="btn btn-square btn-primary m-1"
                            href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}&quote={{ $shareMessage }}"
                            target="_blank" rel="noopener noreferrer" title="Share on Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>

                            <a class="btn btn-square btn-primary m-1"
                            href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareMessage }}"
                            target="_blank" rel="noopener noreferrer" title="Share on Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>

                            <a class="btn btn-square btn-primary m-1"
                            href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}"
                            target="_blank" rel="noopener noreferrer" title="Share on LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>

                            <a class="btn btn-square btn-primary m-1"
                            href="https://wa.me/?text={{ $whatsappMessage }}%20{{ $shareUrl }}"
                            target="_blank" rel="noopener noreferrer" title="Share on WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>

                            <button type="button" class="btn btn-square btn-outline-primary m-1" id="copyLinkBtn" title="Copy link">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>
                    </div>

                    <!-- CTA -->
                    <div class="news-detail-cta wow bounceIn" data-wow-delay="0.1s">
                        <div>
                            <h5 class="mb-1">Ready to start your tech journey?</h5>
                            <p class="mb-0">Registration for the Cybersecurity Engineering cohort closes soon.</p>
                        </div>
                        <a href="{{ route('register') }}" class="btn btn-primary rounded-pill px-4">Register Now</a>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="news-sidebar-block wow fadeIn" data-wow-delay="0.1s">
                        <h6 class="news-sidebar-title font-mono">RECENT POSTS</h6>

                        @forelse($recents as $recent)
                            <a href="{{ route('news.detail', $item->slug) }}" class="news-sidebar-item">
                                <div class="news-sidebar-icon"><i class="fas fa-trophy"></i></div>
                                <div>
                                    <p class="mb-1">{{ $item->title }}</p>
                                    <span class="font-mono">{{ $item->published_at->format('M d, Y') }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="col-12 text-center py-3">
                                <p class="text-muted mb-0">No recent news posted yet.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="news-sidebar-block news-sidebar-cta wow fadeIn" data-wow-delay="0.1s">
                        <div class="news-sidebar-cta-icon"><i class="fa fa-envelope-open-text"></i></div>
                        <h6 class="mb-2">Stay Updated</h6>
                        <p class="mb-3">Get the latest program updates and tech insights straight to your inbox.</p>
                        <a href="#newsletter" class="btn btn-primary rounded-pill w-100">Subscribe</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Article End -->

    <!-- Related News Start -->
    <section class="news-section py-3">
        <div class="container py-4">
            <div class="curriculum-header wow fadeIn" data-wow-delay="0.1s">
                <h3 class="fw-bold">Related News</h3>
                <a href="{{ route('news') }}" class="view-all-link">
                    View all news
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="row g-4">
                @forelse($relateds as $related)
                    <div class="col-sm-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                        <a href="{{ route('news.detail', $related->slug) }}" class="news-card">
                            <div class="news-card-top">
                                <div class="news-card-icon">
                                    <i class="{{ $related->icon ?? 'fas fa-newspaper' }}"></i>
                                </div>
                                @isset($related->category)
                                    <span class="news-tag font-mono {{ $related->tag_class }}">{{ Str::upper($related->category) }}</span>
                                @endisset
                            </div>
                            <div class="news-card-body">
                                <h4 class="news-card-title">{{ $related->title }}</h4>
                                <p class="news-card-excerpt">{{ Str::limit($related->excerpt, 110) }}</p>
                            </div>
                            <div class="news-card-footer">
                                <span class="font-mono news-card-date">{{ $related->published_at->format('M d, Y') }}</span>
                                <span class="news-card-link font-mono">
                                    Read more <i class="fas fa-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-3">
                        <p class="text-muted mb-0">No news posted yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- Related News End -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const copyBtn = document.getElementById('copyLinkBtn');
        if (!copyBtn) return;

        copyBtn.addEventListener('click', function () {
            const url = "{{ route('news.detail', $news->slug) }}";
            const message = "Check out this article from Teqhitch ICT Academy: \"{{ $news->title }}\"\n\n" + url;

            navigator.clipboard.writeText(message).then(function () {
                const icon = copyBtn.querySelector('i');
                icon.classList.remove('fa-link');
                icon.classList.add('fa-check');
                copyBtn.classList.remove('btn-outline-primary');
                copyBtn.classList.add('btn-success');

                setTimeout(function () {
                    icon.classList.remove('fa-check');
                    icon.classList.add('fa-link');
                    copyBtn.classList.remove('btn-success');
                    copyBtn.classList.add('btn-outline-primary');
                }, 2000);
            }).catch(function () {
                alert('Could not copy link. Please copy manually: ' + url);
            });
        });
    });
</script>
@endsection