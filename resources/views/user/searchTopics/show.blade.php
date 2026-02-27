@extends('userdashboardLayout')
@section('title', 'Topic Details')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Page Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Topic Details</h4>
            <small class="text-muted">Complete information about this topic</small>
        </div>

        <a href="{{ route('user.searchTopics.index') }}" 
           class="btn btn-outline-secondary btn-sm">
            <i class="bx bx-arrow-back me-1"></i> Back
        </a>
    </div>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-semibold">Topic Information</h6>

            <!-- Status Badge -->
            @if($topic->status === 'approved')
                <span class="badge bg-success">Finished</span>
            @elseif($topic->status === 'rejected')
                <span class="badge bg-danger">Rejected</span>
            @else
                <span class="badge bg-warning text-dark">{{ $topic->status }}</span>
            @endif
        </div>

        <div class="card-body">

            <div class="row g-4">

                <!-- Topic Title -->
                <div class="col-md-6">
                    <label class="form-label text-muted">Topic Title</label>
                    <p class="fw-semibold mb-0">
                        {{ $topic->topic?->title ?? 'N/A' }}
                    </p>
                </div>

                <!-- Paper Type -->
                <div class="col-md-6">
                    <label class="form-label text-muted">Paper Type</label>
                    <p class="mb-0">
                        {{ ucfirst($topic->topic?->paper_type ?? 'N/A') }}
                    </p>
                </div>

                <!-- Academic Level -->
                <div class="col-md-6">
                    <label class="form-label text-muted">Academic Level</label>
                    <p class="mb-0">
                        {{ $topic->topic?->academic_level ?? 'N/A' }}
                    </p>
                </div>

                <!-- Submission Date -->
                <div class="col-md-6">
                    <label class="form-label text-muted">Submitted On</label>
                    <p class="mb-0">
                        {{ optional($topic->created_at)->format('d M Y, h:i A') }}
                    </p>
                </div>

            </div>

        </div>
        
        @if($topic->topic->paper)

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">

                    <div>
                        <h6 class="mb-1 fw-semibold">Paper Available</h6>

                        @if($topic->payment_status == 1)
                            <span class="badge bg-success">
                                Payment Completed
                            </span>
                        @else
                            <span class="badge bg-warning text-dark">
                                Payment Required
                            </span>
                        @endif
                    </div>

                    <div class="text-center">

                        @if($topic->payment_status == 1 && $topic->topic && $topic->topic->paper)
                            @if($topic->topic->paper->paper_url)
                                <a href="{{ $topic->topic->paper->paper_url }}"
                                class="btn btn-success mb-3 mb-md-0">
                                    <i class="bx bx-download me-1"></i>
                                    Download Paper
                                </a>
                            @endif

                            @if($topic->topic->paper->software_url)
                                <a href="{{ $topic->topic->paper->software_url }}"
                                class="btn btn-info ms-2">
                                    <i class="bx bx-download me-1"></i>
                                    Download Software
                                </a>
                            @endif
                        @else

                            <!-- PAY BUTTON -->
                            <a href="{{ route('user.payment.show', [
                                'slug' => $paymentSetting->slug,
                                'user_topic_id' => $topic->id
                            ]) }}"
                            class="btn btn-primary">
                                    <i class="bx bx-credit-card me-1"></i>
                                    Pay to Download
                            </a>
                        @endif

                    </div>

                </div>
            </div>

        @endif

    </div>

</div>

@endsection