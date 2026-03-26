@extends('userdashboardLayout')
@section('title','View Certificate | Teqhitch ICT Academy LTD')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1">Certificate of Completion</h4>
            <p class="text-muted mb-0">Review and download your earned certificate</p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('user.certificate.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back"></i> Back to Certificates
            </a>

            <a href="{{ route('user.certificate.download', $certificate->certificate_code) }}" 
                class="btn btn-success">
                <i class="bx bx-download me-1"></i> Download PDF
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Certificate Preview -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body text-center p-2">
                    <div class="certificate-wrapper border rounded-3 p-1 bg-light">
                        <img 
                            src="{{ $certificate->thumbnail 
                                ? asset('uploads/' . $certificate->thumbnail)
                                : 'https://dummyimage.com/900x600/f0f0f0/000&text=' . urlencode($certificate->enrollment->course->title)
                            }}"
                            class="img-fluid rounded-2 w-100"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body">
                    <h5 class="fw-semibold mb-3">Certificate Information</h5>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Certificate ID:</span>
                        <span class="fw-semibold">{{ $certificate->certificate_code }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Student Name:</span>
                        <span class="fw-semibold">{{ $certificate->enrollment->student->name }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Course Title:</span>
                        <span class="fw-semibold text-end ms-2">
                            {{ $certificate->enrollment->course->title }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Issued Date:</span>
                        <span class="fw-semibold">
                            {{ $certificate->issued_at->format('d M, Y') }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Status:</span>
                        <span class="badge bg-success rounded-pill px-3 py-2">Verified</span>
                    </div>

                    <hr>

                    <h6 class="fw-semibold mb-2">Verification Link</h6>
                    <p class="text-muted small mb-3">
                        This certificate can be verified online using this link.
                    </p>

                    <div class="input-group">
                        <input type="text" readonly
                               class="form-control"
                               value="https://teqhitch.com/verify/{{ $certificate->certificate_code}}">
                        <button id="copy" class="btn btn-outline-primary">
                            <i class="bx bx-copy"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<script>
document.querySelector('#copy')?.addEventListener('click', function () {
    const input = this.closest('.input-group').querySelector('input');
    input.select();
    document.execCommand('copy');
});
</script>
@endsection
