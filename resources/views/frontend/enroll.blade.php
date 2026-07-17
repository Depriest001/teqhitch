@extends('frontLayout')
@section('title','Enrollment - Teqhitch ICT Academy LTD')
@section('content')
<style>
    .enrollment *{
        font-size: 14px;
    }
    .enrollment h2{
        font-size: 24px;
    }
    /*** Enrollment — brand-specific overrides only ***/
    .enroll-step-circle {
        width: 30px;
        height: 30px;
        color: var(--ink-faint);
        border-color: var(--line) !important;
        transition: .25s;
    }
    .enroll-step.active .enroll-step-circle {
        border-color: var(--primary) !important;
        color: var(--primary);
        background: rgba(18, 63, 186, .08);
    }
    .enroll-step.completed .enroll-step-circle {
        background: var(--brand-gradient);
        border-color: transparent !important;
        color: #fff;
        font-size: 0;
    }
    .enroll-step.completed .enroll-step-circle::before {
        content: "\f00c";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        font-size: 12px;
    }
    .enroll-step.active span.font-mono { color: var(--ink); }
</style>

<div class="container py-5 enrollment">
    <div class="mx-auto" style="max-width: 720px;">

        {{-- Success Notification --}}
        @if(session('success'))
            <div class="alert alert-success border-0 p-4 mb-4 rounded-3 shadow-sm" 
                style="background-color: rgba(25, 135, 84, 0.08); color: #198754;" role="alert">
                <div class="d-flex align-items-start gap-3">
                    <i class="fas fa-check-circle fs-4 mt-1 flex-shrink-0"></i>
                    <div class="w-100">
                        <!-- Main Message -->
                        <h5 class="fw-bold mb-1" style="color: #146c43;">Application Received!</h5>
                        <p class="font-mono small mb-3 text-dark">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
                <!-- Action Required Box -->
                <div class="p-3 rounded-3 border" style="background-color: rgba(25, 135, 84, 0.05); border-color: rgba(25, 135, 84, 0.2) !important;">
                    <div class="d-flex gap-2 align-items-center mb-1">
                        <i class="fas fa-building small"></i>
                        <span class="font-mono small text-uppercase fw-bold text-dark">Next Step: Complete Registration</span>
                    </div>
                    <p class="mb-0 text-muted small" style="font-size: 13px; line-height: 1.5;">
                        Please visit our **Head Office** to finalize your documentation, verify your learning track requirements, and complete your physical onboarding.
                    </p>
                </div>
            </div>
        @endif

        {{-- Error & Duplicate Application Notification --}}
        @if(session('error') || $errors->any())
            <div class="alert alert-danger border-0 p-3 mb-4 rounded-3 shadow-sm" 
                style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545;" role="alert">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="d-flex align-items-start gap-2">
                        <i class="fas fa-exclamation-circle fs-5 mt-1 flex-shrink-0"></i>
                        <div class="font-mono small">
                            @if(session('error'))
                                <div>{{ session('error') }}</div>
                            @endif
                            
                            @if($errors->any())
                                <ul class="list-unstyled mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <button type="button" class="btn-close small ms-2" data-bs-dismiss="alert" aria-label="Close" style="filter: invert(24%) sepia(86%) saturate(2912%) hue-rotate(345deg) brightness(91%) contrast(88%);"></button>
                </div>
            </div>
        @endif

        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="font-mono text-primary text-uppercase">[Enrollment Form]</span>
            <div class="tech-line flex-grow-0" style="width:48px;"></div>
        </div>

        <h2 class="fw-bold mb-1">Enrollment</h2>
        <p class="text-muted mb-5">Complete the form below to begin your journey.</p>

        <!-- Stepper -->
        <div class="d-flex align-items-center mb-5" id="enrollStepper">
            <div class="d-flex align-items-center gap-2 enroll-step active" data-step="1">
                <span class="enroll-step-circle rounded-circle border d-flex align-items-center justify-content-center font-mono">1</span>
                <span class="font-mono text-uppercase d-none d-sm-inline">Personal Info</span>
            </div>
            <div class="flex-grow-1 border-top mx-2"></div>
            <div class="d-flex align-items-center gap-2 enroll-step" data-step="2">
                <span class="enroll-step-circle rounded-circle border d-flex align-items-center justify-content-center font-mono">2</span>
                <span class="font-mono text-uppercase d-none d-sm-inline">Program Selection</span>
            </div>
            <div class="flex-grow-1 border-top mx-2"></div>
            <div class="d-flex align-items-center gap-2 enroll-step" data-step="3">
                <span class="enroll-step-circle rounded-circle border d-flex align-items-center justify-content-center font-mono">3</span>
                <span class="font-mono text-uppercase d-none d-sm-inline">Confirmation</span>
            </div>
        </div>

        <!-- Card -->
        <div class="card border rounded-3 p-4 p-md-5">
            <form action="{{ route('enroll.store') }}" method="POST" id="enrollForm">
                @csrf

                <!-- STEP 1 -->
                <div class="enroll-panel" data-panel="1">
                    <p class="font-mono text-uppercase text-muted mb-4">Personal Information</p>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label font-mono text-uppercase text-muted">First Name</label>
                            <input type="text" name="first_name" class="form-control form-control-lg font-mono"
                                placeholder="First name" value="{{ old('first_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-mono text-uppercase text-muted">Last Name</label>
                            <input type="text" name="last_name" class="form-control form-control-lg font-mono"
                                placeholder="Last name" value="{{ old('last_name') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label font-mono text-uppercase text-muted">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-lg font-mono"
                                placeholder="you@email.com" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label font-mono text-uppercase text-muted">Phone Number</label>
                            <input type="text" name="phone" class="form-control form-control-lg font-mono"
                                placeholder="+234 ..." value="{{ old('phone') }}" required>
                        </div>
                    </div>
                </div>

                <!-- STEP 2 -->
                <div class="enroll-panel d-none" data-panel="2">
                    <p class="font-mono text-uppercase text-muted mb-4">Program Selection</p>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="course_select" class="form-label font-mono text-muted small">Select a Program</label>
                            <select name="course_id" id="course_select" class="form-select form-select-md" required>
                                <option value="" selected disabled>Choose your course...</option>
                                @forelse($courses ?? [] as $course)
                                    <option value="{{ $course->id }}">
                                        {{ $course->title }}
                                    </option>
                                @empty
                                    <option value="" disabled>No programs available right now.</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="mode_select" class="form-label font-mono text-muted small">Preferred Mode</label>
                            <select name="mode" id="mode_select" class="form-select form-select-md" required>
                                <option value="" selected disabled>Choose learning mode...</option>
                                <option value="onsite">Onsite (Physical Classes)</option>
                                <option value="online" disabled>Online (Unavailable / Coming Soon)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- STEP 3 -->
                <div class="enroll-panel d-none" data-panel="3">
                    <p class="font-mono small text-uppercase text-muted mb-4">Review &amp; Confirm</p>

                    <ul class="list-group list-group-flush border rounded-3 mb-4">
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="font-mono small text-muted">Full Name</span>
                            <span class="fw-medium text-end" id="reviewName">—</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="font-mono small text-muted">Email</span>
                            <span class="fw-medium" id="reviewEmail">—</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="font-mono small text-muted">Phone</span>
                            <span class="fw-medium" id="reviewPhone">—</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="font-mono small text-muted">Program</span>
                            <span class="fw-medium text-end" id="reviewProgram">—</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="font-mono small text-muted">Learning Mode</span>
                            <span class="fw-medium text-end" id="reviewMode">—</span>
                        </li>
                    </ul>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="terms" id="termsCheck" required>
                        <label class="form-check-label small text-muted" for="termsCheck">
                            I confirm the information above is accurate and I agree to the academy's enrollment terms.
                        </label>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="d-flex justify-content-between mt-5">
                    <button type="button" class="btn btn-outline-secondary btn-lg font-mono" id="enrollBack" disabled>
                        <i class="fas fa-arrow-left me-2"></i> Back
                    </button>
                    <button type="button" class="btn btn-primary btn-lg font-mono" id="enrollNext">
                        Next <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                    <button type="submit" class="btn btn-primary btn-lg font-mono d-none" id="enrollSubmit">
                        Submit Application <i class="fas fa-check ms-2"></i>
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentStep = 1;
    const totalSteps = 3;

    const panels = document.querySelectorAll('.enroll-panel');
    const steps = document.querySelectorAll('.enroll-step');
    const backBtn = document.getElementById('enrollBack');
    const nextBtn = document.getElementById('enrollNext');
    const submitBtn = document.getElementById('enrollSubmit');

    function showStep(step) {
        panels.forEach(p => p.classList.toggle('d-none', parseInt(p.dataset.panel) !== step));

        steps.forEach(s => {
            const n = parseInt(s.dataset.step);
            s.classList.toggle('active', n === step);
            s.classList.toggle('completed', n < step);
        });

        backBtn.disabled = step === 1;
        nextBtn.classList.toggle('d-none', step === totalSteps);
        submitBtn.classList.toggle('d-none', step !== totalSteps);

        if (step === totalSteps) fillReview();
    }

    function validateStep(step) {
        const panel = document.querySelector(`.enroll-panel[data-panel="${step}"]`);
        const requiredFields = panel.querySelectorAll('[required]');
        let valid = true;

        requiredFields.forEach(field => {
            if (field.type === 'checkbox') {
                if (!field.checked) valid = false;
            } else if (field.tagName === 'SELECT') {
                if (!field.value || field.value === "") {
                    valid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            } else if (!field.value.trim()) {
                valid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
                }
        });

        return valid;
    }

    function fillReview() {
        const first = document.querySelector('[name="first_name"]').value;
        const last = document.querySelector('[name="last_name"]').value;
        const email = document.querySelector('[name="email"]').value;
        const phone = document.querySelector('[name="phone"]').value;
        
        // Fetch selected option elements from dropdowns
        const courseSelect = document.getElementById('course_select');
        const modeSelect = document.getElementById('mode_select');

        const programName = courseSelect.options[courseSelect.selectedIndex] ? courseSelect.options[courseSelect.selectedIndex].text : '—';
        const modeName = modeSelect.options[modeSelect.selectedIndex] ? modeSelect.options[modeSelect.selectedIndex].text : '—';

        document.getElementById('reviewName').textContent = `${first} ${last}`;
        document.getElementById('reviewEmail').textContent = email;
        document.getElementById('reviewPhone').textContent = phone;
        document.getElementById('reviewProgram').textContent = programName;
        document.getElementById('reviewMode').textContent = modeName;
    }

    nextBtn.addEventListener('click', function () {
        if (!validateStep(currentStep)) return;
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    });

    backBtn.addEventListener('click', function () {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    showStep(currentStep);
});
</script>
@endsection