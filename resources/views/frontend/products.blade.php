@extends('frontLayout')
@section('title','Products - Teqhitch ICT Academy LTD')
@section('content')
    
    <!-- Hero Start -->
    <div class="container-fluid pt-5 hero-header">
        <div class="container pt-5">
            <div class="row g-5 pt-5">
                <div class="col-lg-6 align-self-center text-center text-lg-start mb-lg-5" >
                    <h2 class="text-white mb-3 animated slideInUp">Products</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center justify-content-lg-start mb-2 animated slideInUp">
                            <li class="breadcrumb-item"><a class="text-white" href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Products</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->
        
    <!-- Products Start -->
    <div class="container-fluid py-3">
        <div class="container py-3">
            <h3 class="fw-bold wow slideInUp" data-wow-delay="0.1s">Software We've Built &amp; Sites We've Delivered</h3>

            <div class="row g-4 wow slideInUp" data-wow-delay="0.1s">
                @forelse($products as $product)
                    <div class="col-sm-6 col-lg-4">
                        <div class="news-card h-100">
                            <div class="news-card-top">
                                <div class="news-card-icon">
                                    <i class="{{ $product->type === 'software' ? 'fas fa-laptop-code' : 'fas fa-globe-america' }}"></i>
                                </div>
                                <span class="news-tag font-mono">
                                    {{ strtoupper($product->type) }}
                                </span>
                            </div>
                            <div class="news-card-body">
                                @if($product->thumbnail)
                                    <img src="{{ asset('uploads/'.$product->thumbnail) }}"
                                        class="img-fluid rounded mb-3" alt="{{ $product->title }}">
                                @endif
                                <h4 class="news-card-title">{{ $product->title }}</h4>
                                <p class="news-card-excerpt">{{ Str::limit($product->description, 110) }}</p>
                            </div>
                            <div class="news-card-footer">
                                @if($product->link)
                                    <a href="{{ $product->link }}" target="_blank" class="news-card-link font-mono">
                                        View Project <i class="fas fa-arrow-right"></i>
                                    </a>
                                @else
                                    <span class="text-muted font-mono small">Private / Internal</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted mb-0">No products to showcase yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Products End -->

@endsection