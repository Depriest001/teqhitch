<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @php
    $favicon = $globalSetting->favicon ?? null;
    $logo    = $globalSetting->site_logo ?? null;
    // Server-side source of truth for "is this email already verified".
    // Passed down from SiwesController@create, e.g.:
    //   $verifiedEmail = old('email') && SiwesOtpController::isRecentlyVerified(old('email'))
    //       ? old('email') : null;
    $verifiedEmail = $verifiedEmail ?? null;
  @endphp
  <link rel="icon" href="{{ $favicon ? asset('storage/'.$favicon) : asset('assets/img/favicon.jpg') }}">
  <title>SIWES / IT Placement Application — {{ $globalSetting->site_name ?? 'Teqhitch' }}</title>

  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    :root{
      --ink:      #0B2340;
      --ink-2:    #123258;
      --blue:     #1B6FE0;
      --cyan:     #2FC2E8;
      --teal:     #1FB8A6;
      --leaf:     #56C56A;
      --amber:    #E8A33D;
      --paper:    #F5F7FB;
      --surface:  #FFFFFF;
      --line:     #E2E7F0;
      --line-2:   #EDF0F6;
      --muted:    #64738C;
      --danger:   #D2402C;
      --success:  #1FA968;
    }
    *{ box-sizing:border-box; }
    html{ scroll-behavior:smooth; }
    body{
      font-family:'Inter',sans-serif;
      background:
        radial-gradient(1200px 480px at 12% -8%, rgba(47,194,232,.10), transparent 60%),
        radial-gradient(900px 420px at 100% 0%, rgba(86,197,106,.09), transparent 55%),
        var(--paper);
      color:var(--ink);
    }
    .font-display{ font-family:'Space Grotesk',sans-serif; letter-spacing:-.01em; }
    .font-mono{ font-family:'IBM Plex Mono',monospace; }

    @media (prefers-reduced-motion: no-preference){
      .step-panel.active{ animation: rise .38s cubic-bezier(.2,.7,.2,1); }
      .track-card{ transition: border-color .15s ease, background-color .15s ease, transform .15s ease; }
      .ring-seg{ transition: stroke .45s ease; }
    }
    @keyframes rise{ from{ opacity:0; transform: translateY(10px); } to{ opacity:1; transform:none; } }

    .step-panel{ display:none; }
    .step-panel.active{ display:block; }

    .field-label{ font-family:'IBM Plex Mono',monospace; letter-spacing:.05em; font-size:.72rem; text-transform:uppercase; color:var(--muted); }

    input, select, textarea{
      border:1.5px solid var(--line); border-radius:.7rem; padding:.5rem .9rem; width:100%;
      background:#fff; font-family:'Inter',sans-serif; color:var(--ink); font-size:.95rem;
    }
    input::placeholder, textarea::placeholder{ color:#A8B2C4; }
    input:focus, select:focus, textarea:focus{
      outline:none; border-color:var(--blue); box-shadow:0 0 0 4px rgba(27,111,224,.14);
    }
    input:focus-visible, select:focus-visible, textarea:focus-visible, button:focus-visible, .track-card:focus-within{
      outline:2px solid var(--cyan); outline-offset:2px;
    }
    .invalid{ border-color:var(--danger) !important; box-shadow:0 0 0 4px rgba(210,64,44,.10) !important; }
    .err-msg{ color:var(--danger); font-size:.78rem; margin-top:.35rem; display:none; }

    .track-card{ border:1.5px solid var(--line); border-radius:.9rem; cursor:pointer; background:#fff; }
    .track-card:hover{ border-color:#C7D2E3; }
    .track-card.selected{ border-color:var(--blue); background:rgba(27,111,224,.05); box-shadow:0 0 0 3px rgba(27,111,224,.12); }

    .ring-wrap{ position:relative; width:112px; height:112px; flex-shrink:0; }
    .ring-wrap svg{ width:100%; height:100%; transform:rotate(0deg); }
    .ring-track{ stroke:var(--line); }
    .ring-seg{ stroke:var(--line); fill:none; }
    .ring-badge{
      position:absolute; inset:0; margin:auto; width:64px; height:64px; border-radius:9999px;
      display:flex; align-items:center; justify-content:center; overflow:hidden;
      box-shadow:0 1px 2px rgba(11,35,64,.08), 0 0 0 1px var(--line-2);
    }
    .ring-badge img{ width:100%; height:100%; object-fit:cover; }

    .step-tick{ color:#A8B2C4; }
    .step-tick.is-done{ color:var(--ink); }
    .step-tick.is-current{ color:var(--ink); font-weight:600; }
    .step-tick .dot{ width:6px; height:6px; border-radius:9999px; background:#C7D2E3; }
    .step-tick.is-done .dot{ background:var(--teal); }
    .step-tick.is-current .dot{ background:var(--blue); }

    .brand-bar{ height:4px; background:linear-gradient(90deg,var(--blue),var(--cyan),var(--teal),var(--leaf)); }

    .btn-primary{ background:linear-gradient(135deg, #1657FF 0%, #17B4D9 55%, #2BD480 100%); color:#fff; }
    .btn-primary:hover { background: linear-gradient(135deg, #1657FFBF 0%, #17B4D9BF 55%, #2BD480BF 100%); }
    .btn-primary:disabled{ opacity:.55; cursor:not-allowed; }
    .btn-ghost{ background:var(--ink); color:#fff; }
    .btn-ghost:hover{ background:var(--ink-2); }
    .btn-link{ background:transparent; color:var(--blue); }
    .btn-link:disabled{ color:#A8B2C4; cursor:not-allowed; text-decoration:none; }
    .btn-sm{
      display:inline-flex; align-items:center; justify-content:center;
      padding:.5rem .9rem; font-size:.78rem; width:auto; max-width:100%; white-space:nowrap;
    }

    /* Flex-basis:0 + a max-width cap means the 6 boxes always divide up
       whatever width is actually available (no fixed px width to overflow
       a narrow phone), while never growing past a comfortable size on
       larger screens. */
    .otp-row{ display:flex; gap:.4rem; width:100%; }
    .otp-box{
      flex:1 1 0; min-width:0; max-width:2.6rem; height:2.9rem;
      text-align:center; font-size:1.05rem; font-family:'IBM Plex Mono',monospace;
      padding:0;
    }

    .pill-ok{ display:inline-flex; align-items:center; gap:.35rem; font-family:'IBM Plex Mono',monospace; font-size:.72rem; color:var(--success); }
    .pill-pending{ display:inline-flex; align-items:center; gap:.35rem; font-family:'IBM Plex Mono',monospace; font-size:.72rem; color:var(--muted); }

    .restore-toast{
      position:fixed; left:0; right:0; bottom:1rem; display:flex; justify-content:center; z-index:50;
      pointer-events:none;
    }
    .restore-toast-inner{
      pointer-events:auto; background:var(--ink); color:#fff; font-size:.82rem; padding:.65rem 1rem;
      border-radius:.8rem; box-shadow:0 8px 24px rgba(11,35,64,.25); display:flex; align-items:center; gap:.75rem;
    }
    .restore-toast-inner button{ width:auto; background:transparent; border:none; color:#BFD2FF; font-family:'IBM Plex Mono',monospace; font-size:.75rem; text-decoration:underline; padding:0; cursor:pointer; }
  </style>
</head>
<body class="min-h-screen">

<div class="brand-bar"></div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-14">

  <header class="flex items-start justify-between gap-6 mb-8 sm:mb-10">
    <div class="flex items-center gap-3 min-w-0">
      <img src="{{$logo ? asset('uploads/'.$logo) : asset('assets/img/logo.png') }}" alt="Teqhitch ICT Academy" class="w-10 h-10 sm:w-11 sm:h-11 rounded-full shrink-0" style="box-shadow:0 1px 2px rgba(11,35,64,.10)">
      <div class="min-w-0">
        <p class="field-label" style="color:var(--teal)">{{ $globalSetting->site_name ?? 'Teqhitch' }}</p>
        <h1 class="font-display text-xl sm:text-2xl font-semibold leading-tight" style="color:var(--ink)">SIWES / IT&nbsp;Placement<br class="sm:hidden"> Application</h1>
      </div>
    </div>

    <div class="ring-wrap hidden sm:block" aria-hidden="true">
      <svg viewBox="0 0 120 120" id="ringSvg">
        <circle class="ring-track" cx="60" cy="60" r="50" fill="none" stroke-width="8"/>
      </svg>
      <div class="ring-badge">
        <img src="{{$logo ? asset('uploads/'.$logo) : asset('assets/img/logo.png') }}" alt="">
      </div>
    </div>
  </header>

  <div class="flex items-center justify-between sm:justify-start sm:gap-6 mb-8 sm:mb-10 font-mono text-xs overflow-x-auto" id="stepper"></div>

  <p class="font-mono text-xs mb-6" style="color:var(--muted)" id="stepCounter"></p>

  @if ($errors->any())
    <div class="mb-6 rounded-xl border px-4 py-3 text-sm" style="border-color:#F3C7BF; background:#FCF0EE; color:var(--danger)">
      <p class="font-semibold mb-1">Please fix the following:</p>
      <ul class="list-disc list-inside space-y-0.5">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('siwes.store') }}" method="POST" id="siwesForm" novalidate>
    @csrf

    <!-- STEP 1 — Personal Information (email verification happens inline, right here) -->
    <section class="step-panel active" data-step="1" data-title="Personal">
      <div class="bg-[var(--surface)] rounded-2xl p-5 sm:p-8 shadow-sm border space-y-5" style="border-color:var(--line-2)">
        <div>
          <h2 class="font-display text-lg sm:text-xl font-semibold" style="color:var(--ink)">Personal information</h2>
          <p class="text-sm mt-1" style="color:var(--muted)">Tell us who you are, exactly as it appears on your school ID.</p>
        </div>

        <div>
          <label class="field-label">Full name</label>
          <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="e.g. Chiamaka Nwosu" required>
          <p class="err-msg">Enter your full name.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="field-label">Gender</label>
            <select name="gender" required>
              <option value="" selected disabled>--Select Gender--</option>
              <option value="male" @selected(old('gender')=='male')>Male</option>
              <option value="female" @selected(old('gender')=='female')>Female</option>
            </select>
            <p class="err-msg">Select your gender.</p>
          </div>
          <div>
            <label class="field-label">Date of birth</label>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
            <p class="err-msg">Enter your date of birth.</p>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="field-label">Phone number</label>
            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="080XXXXXXXX" required>
            <p class="err-msg">Enter a valid Nigerian phone number.</p>
          </div>
          <div>
            <label class="field-label">Email</label>
            <input type="email" name="email" id="emailInput" value="{{ old('email') }}" placeholder="you@example.com" required>
            <p class="err-msg">Enter a valid email address.</p>
          </div>
        </div>

        <!-- Inline email verification -->
        <div id="emailVerifyBox" class="rounded-xl border p-4 sm:p-5 space-y-4 overflow-hidden" style="border-color:var(--line-2); background:var(--paper)">
          {{-- Seeded from the server (SiwesOtpController::isRecentlyVerified against old('email'))
               so a reload after a validation error on step 2/3/4 doesn't force
               re-verification, even if localStorage was empty/cleared. --}}
          <input type="hidden" name="email_verified" id="emailVerifiedFlag" value="{{ $verifiedEmail ? '1' : '0' }}">

          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="min-w-0">
              <p class="text-sm font-medium" style="color:var(--ink)">Verify this email</p>
              <p class="text-xs mt-0.5" id="verifyHint" style="color:var(--muted)">We'll send a 6-digit code to confirm we can reach you here.</p>
            </div>
            <button type="button" id="sendOtpBtn" class="self-start sm:self-auto rounded-lg font-semibold btn-primary btn-sm">Send code</button>
          </div>

          <div id="otpSection" class="space-y-3 hidden">
            <div class="otp-row" role="group" aria-label="6 digit verification code">
              <input class="otp-box" id="otpBox1" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="one-time-code">
              <input class="otp-box" id="otpBox2" inputmode="numeric" pattern="[0-9]*" maxlength="1">
              <input class="otp-box" id="otpBox3" inputmode="numeric" pattern="[0-9]*" maxlength="1">
              <input class="otp-box" id="otpBox4" inputmode="numeric" pattern="[0-9]*" maxlength="1">
              <input class="otp-box" id="otpBox5" inputmode="numeric" pattern="[0-9]*" maxlength="1">
              <input class="otp-box" id="otpBox6" inputmode="numeric" pattern="[0-9]*" maxlength="1">
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
              <span id="otpStatus" class="pill-pending">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                Waiting for code
              </span>
              <div class="flex items-center gap-3">
                <button type="button" id="verifyOtpBtn" class="self-start rounded-lg font-semibold btn-primary btn-sm">Confirm code</button>
                <button type="button" id="resendOtpBtn" class="text-xs font-mono font-semibold underline btn-link" style="width:auto; padding:0;">Resend code</button>
              </div>
            </div>
          </div>

          <p class="err-msg" id="otpErr">Enter the 6-digit code and confirm it before continuing.</p>
          <p class="err-msg" id="emailVerifyErr">Verify your email before continuing to the next step.</p>
        </div>

        <div>
          <label class="field-label">Home address</label>
          <input type="text" name="address" value="{{ old('address') }}" placeholder="Street, city" required>
          <p class="err-msg">Enter your home address.</p>
        </div>

      </div>
    </section>

    <!-- STEP 2 — Academic Information -->
    <section class="step-panel" data-step="2" data-title="Academic">
      <div class="bg-[var(--surface)] rounded-2xl p-5 sm:p-8 shadow-sm border space-y-5" style="border-color:var(--line-2)">
        <div>
          <h2 class="font-display text-lg sm:text-xl font-semibold" style="color:var(--ink)">Academic information</h2>
          <p class="text-sm mt-1" style="color:var(--muted)">This should match your school's introduction letter.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="field-label">Institution</label>
            <input type="text" name="institution" value="{{ old('institution') }}" placeholder="e.g. ESUT" required>
            <p class="err-msg">Enter your institution.</p>
          </div>
          <div>
            <label class="field-label">Department</label>
            <input type="text" name="department" value="{{ old('department') }}" required>
            <p class="err-msg">Enter your department.</p>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="field-label">Course of study</label>
            <input type="text" name="course_of_study" value="{{ old('course_of_study') }}" required>
            <p class="err-msg">Enter your course of study.</p>
          </div>
          <div>
            <label class="field-label">Level</label>
            <input type="text" name="level" value="{{ old('level') }}" placeholder="e.g. 300L / ND2" required>
            <p class="err-msg">Enter your current level.</p>
          </div>
        </div>

        <div>
          <label class="field-label">Matric / registration number</label>
          <input type="text" name="matric_number" value="{{ old('matric_number') }}" required>
          <p class="err-msg">Enter your matric number.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="field-label">SIWES start date</label>
            <input type="date" name="siwes_start_date" value="{{ old('siwes_start_date') }}" required>
            <p class="err-msg">Enter the SIWES start date.</p>
          </div>
          <div>
            <label class="field-label">SIWES end date</label>
            <input type="date" name="siwes_end_date" value="{{ old('siwes_end_date') }}" required>
            <p class="err-msg">End date must be after the start date.</p>
          </div>
        </div>

        <div>
          <label class="field-label">ITF / introduction letter reference <span class="normal-case font-sans" style="color:#A8B2C4">(optional)</span></label>
          <input type="text" name="letter_ref_number" value="{{ old('letter_ref_number') }}" placeholder="If your school issued a reference number">
        </div>
      </div>
    </section>

    <!-- STEP 3 — Placement Preference -->
    <section class="step-panel" data-step="3" data-title="Placement">
      <div class="bg-[var(--surface)] rounded-2xl p-5 sm:p-8 shadow-sm border space-y-5" style="border-color:var(--line-2)">
        <div>
          <h2 class="font-display text-lg sm:text-xl font-semibold" style="color:var(--ink)">Placement preference</h2>
          <p class="text-sm mt-1" style="color:var(--muted)">Choose the track you'll train in for the duration of your SIWES.</p>
        </div>

        <div>
          <label class="field-label">Track</label>
          <select name="track_id" id="trackSelect" required>
            <option value="" selected disabled>--Select a track--</option>
            @foreach($tracks as $track)
              <option
                value="{{ $track->id }}"
                data-price="{{ $track->price }}"
                @selected(old('track_id') == $track->id)
              >
                {{ $track->name }} (₦{{ number_format($track->price, 2) }})
              </option>
            @endforeach
          </select>
          <p class="err-msg" id="trackErr">Choose a placement track.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="field-label">Preferred start date</label>
            <input type="date" name="preferred_start_date" value="{{ old('preferred_start_date') }}" required>
            <p class="err-msg">Choose a start date from today onward.</p>
          </div>
          <div>
            <label class="field-label">Mode</label>
            <select name="mode" required>
              <option value="" disabled>--Preferred Learning Mode--</option>
              <option value="physical" @selected(old('mode')=='physical')>Physical (on-site)</option>
              <option value="hybrid" disabled @selected(old('mode')=='hybrid')>Hybrid</option>
            </select>
            <p class="err-msg">Select a placement mode.</p>
          </div>
        </div>
      </div>
    </section>

   <!-- STEP 4 — Review & Payment -->
    <section class="step-panel" data-step="4" data-title="Review">
      <div class="bg-[var(--surface)] rounded-2xl p-5 sm:p-8 shadow-sm border space-y-5" style="border-color:var(--line-2)">
        <div>
          <h2 class="font-display text-lg sm:text-xl font-semibold" style="color:var(--ink)">Review your application</h2>
          <p class="text-sm mt-1" style="color:var(--muted)">Check your details below. Once you submit, we'll generate a dedicated bank account for your placement fee — no card required.</p>
        </div>

        <div id="reviewBox" class="rounded-xl p-5 text-sm space-y-2.5 font-mono" style="background:var(--paper); border:1px solid var(--line-2)"></div>

        <div class="rounded-xl border p-4 sm:p-5" style="border-color:#F0DDB8; background:rgba(232,163,61,.08)">
          <div class="flex items-center gap-3 mb-3">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--amber)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <span class="text-sm font-medium" style="color:var(--ink)">SIWES placement fee</span>
          </div>

          <label class="field-label" for="amountInput">Amount to pay (₦)</label>
          <div class="relative mt-1">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-display font-semibold text-sm" style="color:var(--amber)">₦</span>
            <input
              type="number"
              name="amount"
              id="amountInput"
              min="10000"
              step="100"
              inputmode="numeric"
              class="!pl-8 font-mono [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
              placeholder="Amount(₦)"
              required
            >
          </div>
          <p class="err-msg" id="amountErr">Enter an amount of at least ₦10,000.</p>
          <p class="text-xs mt-2" style="color:var(--muted)">
            Minimum <span id="minAmountLabel">₦10,000.00</span>. Your selected track's standard fee is <span id="trackFeeLabel">₦0.00</span> — you're welcome to pay this or more.
          </p>
        </div>

        <p class="text-xs flex items-center gap-1.5" style="color:var(--muted)">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><path d="M12 2 4 5v6c0 5 3.4 9.4 8 11 4.6-1.6 8-6 8-11V5l-8-3Z"/></svg>
          Your details are encrypted and used only to process your placement.
        </p>
      </div>
    </section>

    <!-- Navigation -->
    <div class="flex items-center justify-between gap-3 mt-6">
      <button type="button" id="prevBtn" class="px-5 py-2.5 rounded-xl text-sm font-semibold btn-ghost hidden">Back</button>
      <div class="flex-1"></div>
      <button type="button" id="nextBtn" class="px-6 py-2.5 rounded-xl text-sm font-semibold btn-primary">Next</button>
      <button type="submit" id="submitBtn" class="px-6 py-2.5 rounded-xl text-sm font-semibold btn-primary hidden">Submit &amp; proceed with payment</button>
    </div>
  </form>

  <footer class="mt-10 pt-6 border-t text-center" style="border-color:var(--line-2)">
    <p class="font-mono text-xs" style="color:#A8B2C4">{{ $globalSetting->site_name ?? 'Teqhitch' }} · SIWES / IT Placement Programme</p>
  </footer>
</div>

<script>
(function(){
  const OTP_SEND_URL   = "{{ \Illuminate\Support\Facades\Route::has('siwes.otp.send')   ? route('siwes.otp.send')   : '' }}";
  const OTP_VERIFY_URL = "{{ \Illuminate\Support\Facades\Route::has('siwes.otp.verify') ? route('siwes.otp.verify') : '' }}";
  // New: lets the page ask the server "is this email still verified?" — used
  // as a fallback whenever localStorage doesn't already confirm it (private
  // browsing, cleared storage, a different device/browser, or a typed email
  // that differs from the one old('email') rendered with).
  const OTP_STATUS_URL = "{{ \Illuminate\Support\Facades\Route::has('siwes.otp.status') ? route('siwes.otp.status') : '' }}";
  const CSRF_TOKEN = "{{ csrf_token() }}";

  // Server-side verified email for the current request, if any (from
  // SiwesController@create checking SiwesOtpController::isRecentlyVerified
  // against old('email')). This is what keeps verification intact across a
  // failed submission — it does not depend on localStorage surviving.
  const SERVER_VERIFIED_EMAIL = @json($verifiedEmail);

  const STORAGE_KEY = 'teqhitch_siwes_application_v1';
  const STORAGE_TTL_MS = 60 * 60 * 1000;

  // Verified emails are tracked separately from the draft so a verification
  // survives even after the draft itself expires or is cleared. This is now
  // just an optimistic client-side cache — the server's OTP_STATUS_URL /
  // SERVER_VERIFIED_EMAIL are the actual source of truth, and store() always
  // re-checks server-side regardless of what's sent in email_verified.
  const VERIFIED_EMAIL_KEY = 'teqhitch_siwes_verified_emails_v1';
  const VERIFIED_EMAIL_TTL_MS = 24 * 60 * 60 * 1000; // hold verification for 24h per email

  function getVerifiedEmailStore(){
    try {
      const raw = localStorage.getItem(VERIFIED_EMAIL_KEY);
      return raw ? JSON.parse(raw) : {};
    } catch (err) { return {}; }
  }

  function rememberVerifiedEmail(email){
    if (!email) return;
    try {
      const store = getVerifiedEmailStore();
      store[email.toLowerCase()] = Date.now();
      localStorage.setItem(VERIFIED_EMAIL_KEY, JSON.stringify(store));
    } catch (err) {
      console.warn('SIWES form: could not save verified-email record.', err);
    }
  }

  function forgetVerifiedEmail(email){
    if (!email) return;
    try {
      const store = getVerifiedEmailStore();
      delete store[email.toLowerCase()];
      localStorage.setItem(VERIFIED_EMAIL_KEY, JSON.stringify(store));
    } catch (err) {}
  }

  function isEmailRecentlyVerified(email){
    if (!email) return false;
    const store = getVerifiedEmailStore();
    const ts = store[email.toLowerCase()];
    if (!ts) return false;
    if (Date.now() - ts > VERIFIED_EMAIL_TTL_MS) {
      delete store[email.toLowerCase()];
      try { localStorage.setItem(VERIFIED_EMAIL_KEY, JSON.stringify(store)); } catch (err) {}
      return false;
    }
    return true;
  }

  // Ask the server directly whether `email` is currently verified. Used as
  // a fallback when the local cache doesn't already say yes — e.g. right
  // after a validation-error reload, or on a browser/device that never had
  // the localStorage record in the first place.
  async function checkServerVerification(email){
    if (!email || !OTP_STATUS_URL) return false;
    try {
      const res = await fetch(OTP_STATUS_URL + '?email=' + encodeURIComponent(email), {
        method: 'GET',
        headers: { 'Accept': 'application/json' }
      });
      if (!res.ok) return false;
      const data = await res.json();
      return !!data.verified;
    } catch (err) {
      return false;
    }
  }

  const steps = Array.from(document.querySelectorAll('.step-panel'));
  const stepLabels = steps.map(s => s.dataset.title);
  const stepColors = ['--blue','--cyan','--teal','--leaf'];

  const stepperEl = document.getElementById('stepper');
  const ringSvg = document.getElementById('ringSvg');
  const stepCounter = document.getElementById('stepCounter');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const submitBtn = document.getElementById('submitBtn');
  const form = document.getElementById('siwesForm');
  const trackSelect = document.getElementById('trackSelect');
  const amountInput = document.getElementById('amountInput');
  const trackFeeLabel = document.getElementById('trackFeeLabel');
  const emailInput = document.getElementById('emailInput');
  const emailVerifiedFlag = document.getElementById('emailVerifiedFlag');
  const verifyHint = document.getElementById('verifyHint');
  const sendOtpBtn = document.getElementById('sendOtpBtn');
  const otpSection = document.getElementById('otpSection');
  const otpStatus = document.getElementById('otpStatus');
  const otpErr = document.getElementById('otpErr');
  const emailVerifyErr = document.getElementById('emailVerifyErr');
  const emailVerifyBox = document.getElementById('emailVerifyBox');
  const otpBoxes = Array.from({length:6}, (_, i) => document.getElementById('otpBox' + (i+1)));
  const verifyOtpBtn = document.getElementById('verifyOtpBtn');
  const resendOtpBtn = document.getElementById('resendOtpBtn');

  const MIN_AMOUNT = 10000;
  let current = 1;
  let otpSentForEmail = null;
  let resendCooldownTimer = null;

  stepLabels.forEach((label, i) => {
    const n = i + 1;
    const tick = document.createElement('div');
    tick.className = 'step-tick flex items-center gap-2 shrink-0';
    tick.dataset.tick = n;
    tick.innerHTML = '<span class="dot"></span><span class="hidden xs:inline sm:inline">' + label + '</span>';
    stepperEl.appendChild(tick);
  });
  const ticks = Array.from(document.querySelectorAll('[data-tick]'));

  const R = 50, CIRC = 2 * Math.PI * R, GAP = 6;
  const segLen = (CIRC / stepLabels.length) - GAP;
  const ringSegs = stepLabels.map((_, i) => {
    const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    circle.setAttribute('class', 'ring-seg');
    circle.setAttribute('data-seg', i + 1);
    circle.setAttribute('cx', 60); circle.setAttribute('cy', 60); circle.setAttribute('r', R);
    circle.setAttribute('stroke-width', 8);
    circle.setAttribute('stroke-linecap', 'butt');
    circle.setAttribute('stroke-dasharray', segLen + ' ' + (CIRC - segLen));
    circle.setAttribute('transform', 'rotate(' + (-90 + i * (360 / stepLabels.length)) + ' 60 60)');
    ringSvg.appendChild(circle);
    return circle;
  });

  function fieldsForStep(n){
    return steps[n-1].querySelectorAll('input, select, textarea');
  }

  function selectedTrackOption(){
    return trackSelect.options[trackSelect.selectedIndex] || null;
  }

  function selectedTrackPrice(){
    const opt = selectedTrackOption();
    return opt && opt.dataset.price ? parseFloat(opt.dataset.price) : 0;
  }

  function updateAmountDefaults(){
    const price = selectedTrackPrice();
    trackFeeLabel.textContent = '₦' + price.toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    if (!amountInput.dataset.touched) {
      amountInput.value = Math.max(price, MIN_AMOUNT);
    }
  }

  function resetOtpBoxesUI(){
    otpBoxes.forEach(b => { b.value=''; b.classList.remove('invalid'); });
    otpErr.style.display = 'none';
  }

  function setOtpStatus(state, text){
    otpStatus.className = state === 'verified' ? 'pill-ok' : 'pill-pending';
    otpStatus.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
      (state === 'verified'
        ? '<path d="M20 6 9 17l-5-5"/>'
        : '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>') +
      '</svg>' + text;
  }

  function startResendCooldown(seconds){
    let left = seconds;
    resendOtpBtn.disabled = true;
    if (resendCooldownTimer) clearInterval(resendCooldownTimer);
    resendOtpBtn.textContent = 'Resend code (' + left + 's)';
    resendCooldownTimer = setInterval(() => {
      left -= 1;
      if (left <= 0) {
        clearInterval(resendCooldownTimer);
        resendOtpBtn.disabled = false;
        resendOtpBtn.textContent = 'Resend code';
      } else {
        resendOtpBtn.textContent = 'Resend code (' + left + 's)';
      }
    }, 1000);
  }

  function markVerifiedUI(email){
    emailVerifiedFlag.value = '1';
    otpSentForEmail = email;
    otpSection.classList.remove('hidden');
    emailVerifyErr.style.display = 'none';
    verifyHint.textContent = email + ' is verified.';
    setOtpStatus('verified', 'Email verified');
    rememberVerifiedEmail(email); // sync server truth back into the local cache
  }

  function markUnverified(){
    emailVerifiedFlag.value = '0';
    otpSentForEmail = null;
    setOtpStatus('pending', 'Waiting for code');
  }

  async function sendOtp(email, { silent } = {}){
    if (!email) return;

    // Already verified within the last 24h locally — skip sending a new code.
    if (isEmailRecentlyVerified(email)) {
      markVerifiedUI(email);
      return;
    }

    // Local cache doesn't know, but the server might (e.g. cleared storage,
    // another device). Check before bothering to send a fresh code.
    if (await checkServerVerification(email)) {
      markVerifiedUI(email);
      return;
    }

    emailVerifyErr.style.display = 'none';
    emailVerifiedFlag.value = '0';
    resetOtpBoxesUI();
    otpSection.classList.remove('hidden');
    sendOtpBtn.disabled = true;
    verifyHint.textContent = 'Code sending to ' + email + '…';
    setOtpStatus('pending', 'Sending code…');

    if (!OTP_SEND_URL) {
      console.warn('SIWES OTP: no "siwes.otp.send" route configured on the server.');
      setOtpStatus('pending', 'Waiting for code');
      if (!silent) { otpErr.textContent = 'Verification isn\'t configured yet — contact the site admin.'; otpErr.style.display = 'block'; }
      sendOtpBtn.disabled = false;
      return;
    }

    try {
      const res = await fetch(OTP_SEND_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
        body: JSON.stringify({ email })
      });
      if (!res.ok) throw new Error('send failed');
      otpSentForEmail = email;
      verifyHint.textContent = 'Code sent to ' + email + ' — enter it below.';
      setOtpStatus('pending', 'Code sent — check your inbox');
      startResendCooldown(30);
      saveState();
    } catch (err) {
      verifyHint.textContent = "We'll send a 6-digit code to confirm we can reach you here.";
      setOtpStatus('pending', 'Waiting for code');
      otpErr.textContent = 'Couldn\'t send the code. Check your connection and try "Resend code".';
      otpErr.style.display = 'block';
    } finally {
      sendOtpBtn.disabled = false;
    }
  }

  async function verifyOtp(){
    const email = emailInput.value.trim();
    const code = otpBoxes.map(b => b.value).join('');
    otpErr.style.display = 'none';
    otpBoxes.forEach(b => b.classList.remove('invalid'));

    if (code.length !== 6) {
      otpErr.textContent = 'Enter all 6 digits of the code.';
      otpErr.style.display = 'block';
      otpBoxes.forEach(b => { if (!b.value) b.classList.add('invalid'); });
      return false;
    }

    if (!OTP_VERIFY_URL) {
      otpErr.textContent = 'Verification isn\'t configured yet — contact the site admin.';
      otpErr.style.display = 'block';
      return false;
    }

    verifyOtpBtn.disabled = true;
    verifyOtpBtn.textContent = 'Confirming…';
    try {
      const res = await fetch(OTP_VERIFY_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
        body: JSON.stringify({ email, code })
      });
      if (!res.ok) {
        otpBoxes.forEach(b => b.classList.add('invalid'));
        otpErr.textContent = 'That code doesn\'t match. Check it and try again, or resend.';
        otpErr.style.display = 'block';
        return false;
      }
      markVerifiedUI(email);
      saveState();
      return true;
    } catch (err) {
      otpErr.textContent = 'Couldn\'t reach the server. Try again.';
      otpErr.style.display = 'block';
      return false;
    } finally {
      verifyOtpBtn.disabled = false;
      verifyOtpBtn.textContent = 'Confirm code';
    }
  }

  otpBoxes.forEach((box, i) => {
    box.addEventListener('input', () => {
      box.value = box.value.replace(/[^0-9]/g, '').slice(0, 1);
      box.classList.remove('invalid');
      if (box.value && otpBoxes[i+1]) otpBoxes[i+1].focus();
    });
    box.addEventListener('keydown', (e) => {
      if (e.key === 'Backspace' && !box.value && otpBoxes[i-1]) otpBoxes[i-1].focus();
    });
    box.addEventListener('paste', (e) => {
      const text = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
      if (!text) return;
      e.preventDefault();
      text.slice(0, 6).split('').forEach((ch, idx) => { if (otpBoxes[idx]) otpBoxes[idx].value = ch; });
      const next = otpBoxes[Math.min(text.length, 5)];
      if (next) next.focus();
    });
  });

  sendOtpBtn.addEventListener('click', () => {
    emailInput.classList.remove('invalid');
    const err = emailInput.closest('div')?.querySelector('.err-msg');
    if (!emailInput.value.trim() || !emailInput.checkValidity()) {
      emailInput.classList.add('invalid');
      if (err) err.style.display = 'block';
      emailInput.focus();
      return;
    }
    sendOtp(emailInput.value.trim());
  });
  verifyOtpBtn.addEventListener('click', verifyOtp);
  resendOtpBtn.addEventListener('click', () => {
    // Manual resend should always send a fresh code, even if the email
    // was recently verified (e.g. user wants to re-confirm).
    const email = emailInput.value.trim();
    forgetVerifiedEmail(email);
    resetOtpBoxesUI();
    markUnverified();
    sendOtp(email);
  });

  emailInput.addEventListener('input', () => {
    const val = emailInput.value.trim();

    if (isEmailRecentlyVerified(val)) {
      markVerifiedUI(val);
      return;
    }

    if (emailVerifiedFlag.value === '1' || otpSentForEmail) {
      otpSection.classList.add('hidden');
      verifyHint.textContent = "We'll send a 6-digit code to confirm we can reach you here.";
      markUnverified();
    }
  });

  function validateStep(n){
    let valid = true;
    fieldsForStep(n).forEach(el => {
      if (el.id && el.id.startsWith('otpBox')) return;
      el.classList.remove('invalid');
      const err = el.closest('div')?.querySelector('.err-msg');
      if (err) err.style.display = 'none';

      if (el.hasAttribute('required')) {
        if (!el.value.trim()) {
          valid = false;
          el.classList.add('invalid');
          if (err) err.style.display = 'block';
        }
      }
    });

    if (n === 1) {
      emailVerifyErr.style.display = 'none';
      if (emailVerifiedFlag.value !== '1') {
        valid = false;
        emailVerifyErr.style.display = 'block';
        if (!otpSection.classList.contains('hidden')) {
          otpErr.textContent = 'Confirm the code sent to your email before continuing.';
          otpErr.style.display = 'block';
        }
      }
    }

    if (n === 2) {
      const start = steps[1].querySelector('[name=siwes_start_date]').value;
      const end = steps[1].querySelector('[name=siwes_end_date]').value;
      if (start && end && end <= start) {
        valid = false;
        const endEl = steps[1].querySelector('[name=siwes_end_date]');
        endEl.classList.add('invalid');
        endEl.closest('div').querySelector('.err-msg').style.display = 'block';
      }
    }

    if (n === 4) {
      const amount = parseFloat(amountInput.value);
      if (isNaN(amount) || amount < MIN_AMOUNT) {
        valid = false;
        amountInput.classList.add('invalid');
        document.getElementById('amountErr').style.display = 'block';
      }
    }

    return valid;
  }

  function updateStepper(){
    ticks.forEach(t => {
      const n = Number(t.dataset.tick);
      t.classList.toggle('is-done', n < current);
      t.classList.toggle('is-current', n === current);
    });
    ringSegs.forEach(seg => {
      const n = Number(seg.dataset.seg);
      seg.classList.toggle('lit', n <= current);
      seg.style.stroke = n <= current ? 'var(' + stepColors[n-1] + ')' : 'var(--line)';
    });
    stepCounter.textContent = 'Step ' + current + ' of ' + steps.length + ' — ' + stepLabels[current-1];
  }

  function renderReview(){
    const data = new FormData(form);
    const opt = selectedTrackOption();
    const trackLabel = opt && opt.value ? opt.textContent.trim() : '—';

    const rows = [
      ['Full name', data.get('full_name')],
      ['Phone', data.get('phone')],
      ['Email', data.get('email') + (emailVerifiedFlag.value === '1' ? ' ✓ verified' : '')],
      ['Institution', data.get('institution')],
      ['Course', (data.get('course_of_study')||'') + ' — ' + (data.get('level')||'')],
      ['SIWES period', (data.get('siwes_start_date')||'—') + '  to  ' + (data.get('siwes_end_date')||'—')],
      ['Track', trackLabel],
      ['Mode', data.get('mode') || '—'],
    ];
    document.getElementById('reviewBox').innerHTML = rows.map(r =>
      `<div class="flex justify-between gap-4"><span style="color:var(--muted)">${r[0]}</span><span style="color:var(--ink)" class="text-right">${r[1] || '—'}</span></div>`
    ).join('');

    updateAmountDefaults();
  }

  function showStep(n){
    steps.forEach(s => s.classList.toggle('active', Number(s.dataset.step) === n));
    prevBtn.classList.toggle('hidden', n === 1);
    nextBtn.classList.toggle('hidden', n === steps.length);
    submitBtn.classList.toggle('hidden', n !== steps.length);
    if (n === steps.length) renderReview();
    updateStepper();
    saveState();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  nextBtn.addEventListener('click', () => {
    if (!validateStep(current)) {
      if (current === 1 && emailVerifiedFlag.value !== '1') {
        emailVerifyBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
      return;
    }
    current = Math.min(current + 1, steps.length);
    showStep(current);
  });

  prevBtn.addEventListener('click', () => {
    current = Math.max(current - 1, 1);
    showStep(current);
  });

  trackSelect.addEventListener('change', updateAmountDefaults);

  amountInput.addEventListener('input', () => {
    amountInput.dataset.touched = '1';
  });

  form.addEventListener('submit', (e) => {
    const step1Valid = emailVerifiedFlag.value === '1';
    const step3Valid = validateStep(3);
    const step4Valid = validateStep(4);
    if (!step1Valid || !step3Valid || !step4Valid) {
      e.preventDefault();
      current = !step1Valid ? 1 : (!step3Valid ? 3 : 4);
      showStep(current);
      return;
    }
    // Only clear the local draft once client-side validation has passed —
    // note this still fires optimistically before the server confirms the
    // submission succeeded. If the server rejects it (e.g. other field
    // errors, or store() finds the verification has since expired), this
    // page will be re-rendered and SERVER_VERIFIED_EMAIL / the OTP status
    // endpoint restore verification on load regardless of the cleared draft.
    clearSavedState();
  });

  function collectableFields(){
    return Array.from(form.querySelectorAll('input[name], select[name], textarea[name]'));
  }

  function saveState(){
    try {
      const values = {};
      collectableFields().forEach(el => { values[el.name] = el.value; });
      const state = {
        savedAt: Date.now(),
        step: current,
        values,
        emailVerified: emailVerifiedFlag.value === '1',
        verifiedEmail: emailVerifiedFlag.value === '1' ? emailInput.value.trim() : null,
        otpSectionOpen: !otpSection.classList.contains('hidden'),
        amountTouched: !!amountInput.dataset.touched,
      };
      localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
    } catch (err) {
      console.warn('SIWES form: could not save local progress.', err);
    }
  }

  function clearSavedState(){
    try { localStorage.removeItem(STORAGE_KEY); } catch (err) {}
  }

  function loadState(){
    let raw;
    try { raw = localStorage.getItem(STORAGE_KEY); } catch (err) { return null; }
    if (!raw) return null;
    try {
      const state = JSON.parse(raw);
      if (!state || !state.savedAt) return null;
      if (Date.now() - state.savedAt > STORAGE_TTL_MS) {
        clearSavedState();
        return null;
      }
      return state;
    } catch (err) {
      clearSavedState();
      return null;
    }
  }

  function showRestoreToast(){
    const toast = document.createElement('div');
    toast.className = 'restore-toast';
    toast.innerHTML = '<div class="restore-toast-inner">' +
      '<span>We restored your in-progress application.</span>' +
      '<button type="button" id="discardRestoreBtn">Start over</button>' +
      '</div>';
    document.body.appendChild(toast);
    document.getElementById('discardRestoreBtn').addEventListener('click', () => {
      clearSavedState();
      window.location.reload();
    });
    setTimeout(() => toast.remove(), 8000);
  }

  // Resolve verification state for whatever email currently sits in the
  // field, checking in order: local cache -> server-rendered
  // SERVER_VERIFIED_EMAIL (from old('email')) -> a live status() call.
  // Returns true if it ended up marking the UI verified.
  async function resolveVerification(email){
    if (!email) return false;

    if (isEmailRecentlyVerified(email)) {
      markVerifiedUI(email);
      return true;
    }

    if (SERVER_VERIFIED_EMAIL && SERVER_VERIFIED_EMAIL.toLowerCase() === email.toLowerCase()) {
      markVerifiedUI(email);
      return true;
    }

    if (await checkServerVerification(email)) {
      markVerifiedUI(email);
      return true;
    }

    return false;
  }

  async function restoreState(){
    const state = loadState();
    if (!state) return false;

    collectableFields().forEach(el => {
      if (Object.prototype.hasOwnProperty.call(state.values, el.name)) {
        el.value = state.values[el.name];
      }
    });

    if (state.amountTouched) amountInput.dataset.touched = '1';

    const enteredEmail = emailInput.value.trim();
    const verified = await resolveVerification(enteredEmail);

    if (!verified) {
      if (state.otpSectionOpen && enteredEmail) {
        emailVerifiedFlag.value = '0';
        sendOtp(enteredEmail, { silent: true });
      } else {
        emailVerifiedFlag.value = '0';
      }
    }

    current = Math.min(Math.max(parseInt(state.step, 10) || 1, 1), steps.length);
    showStep(current);
    showRestoreToast();
    return true;
  }

  let saveTimer = null;
  form.addEventListener('input', () => {
    clearTimeout(saveTimer);
    saveTimer = setTimeout(saveState, 400);
  });
  form.addEventListener('change', saveState);

  (async function init(){
    const restored = await restoreState();
    if (!restored) {
      // No local draft (e.g. cleared, expired, or a fresh reload after a
      // server-side validation error on a different browser/device). Still
      // resolve verification against server truth for whatever email is
      // pre-filled via old('email') before showing step 1.
      await resolveVerification(emailInput.value.trim());
      showStep(1);
    }
  })();
})();
</script>

</body>
</html>