<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @php
    $favicon = $globalSetting->favicon ?? null;
    $logo    = $globalSetting->site_logo ?? null;
  @endphp
  <link rel="icon" href="{{ $favicon ? asset('storage/'.$favicon) : asset('assets/img/favicon.jpg') }}">
  <title>SIWES / IT Placement Application — {{ $globalSetting->site_name ?? 'Teqhitch' }}</title>

  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    :root{
      /* --- Token system, drawn from the Teqhitch mark: a spiral of four overlapping bands, deep blue at the core opening out to leaf green --- */
      --ink:      #0B2340;   /* deep navy — primary text, dark surfaces */
      --ink-2:    #123258;   /* secondary navy */
      --blue:     #1B6FE0;   /* band 1 */
      --cyan:     #2FC2E8;   /* band 2 */
      --teal:     #1FB8A6;   /* band 3 */
      --leaf:     #56C56A;   /* band 4 */
      --amber:    #E8A33D;   /* single warm note — reserved for the fee/payment moment only */
      --paper:    #F5F7FB;   /* page background */
      --surface:  #FFFFFF;   /* card surface */
      --line:     #E2E7F0;   /* hairlines, borders */
      --line-2:   #EDF0F6;
      --muted:    #64738C;   /* secondary text */
      --danger:   #D2402C;
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

    /* --- Signature: orbit progress ring, echoing the four bands of the mark --- */
    .ring-wrap{ position:relative; width:112px; height:112px; flex-shrink:0; }
    .ring-wrap svg{ width:100%; height:100%; transform:rotate(0deg); }
    .ring-track{ stroke:var(--line); }
    .ring-seg{ stroke:var(--line); }
    .ring-seg.lit[data-seg="1"]{ stroke:var(--blue); }
    .ring-seg.lit[data-seg="2"]{ stroke:var(--cyan); }
    .ring-seg.lit[data-seg="3"]{ stroke:var(--teal); }
    .ring-seg.lit[data-seg="4"]{ stroke:var(--leaf); }
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
    .btn-ghost{ background:var(--ink); color:#fff; }
    .btn-ghost:hover{ background:var(--ink-2); }
  </style>
</head>
<body class="min-h-screen">

<div class="brand-bar"></div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-14">

  <!-- Header -->
  <header class="flex items-start justify-between gap-6 mb-8 sm:mb-10">
    <div class="flex items-center gap-3 min-w-0">
      <img src="{{$logo ? asset('uploads/'.$logo) : asset('assets/img/logo.png') }}" alt="Teqhitch ICT Academy" class="w-10 h-10 sm:w-11 sm:h-11 rounded-full shrink-0" style="box-shadow:0 1px 2px rgba(11,35,64,.10)">
      <div class="min-w-0">
        <p class="field-label" style="color:var(--teal)">{{ $globalSetting->site_name ?? 'Teqhitch' }}</p>
        <h1 class="font-display text-xl sm:text-2xl font-semibold leading-tight" style="color:var(--ink)">SIWES / IT&nbsp;Placement<br class="sm:hidden"> Application</h1>
      </div>
    </div>

    <!-- Orbit progress ring -->
    <div class="ring-wrap hidden sm:block" aria-hidden="true">
      <svg viewBox="0 0 120 120">
        <circle class="ring-track" cx="60" cy="60" r="50" fill="none" stroke-width="8"/>
        <circle class="ring-seg" data-seg="1" cx="60" cy="60" r="50" fill="none" stroke-width="8" stroke-linecap="butt" stroke-dasharray="78.54 235.62" transform="rotate(-90 60 60)"/>
        <circle class="ring-seg" data-seg="2" cx="60" cy="60" r="50" fill="none" stroke-width="8" stroke-linecap="butt" stroke-dasharray="78.54 235.62" transform="rotate(0 60 60)"/>
        <circle class="ring-seg" data-seg="3" cx="60" cy="60" r="50" fill="none" stroke-width="8" stroke-linecap="butt" stroke-dasharray="78.54 235.62" transform="rotate(90 60 60)"/>
        <circle class="ring-seg" data-seg="4" cx="60" cy="60" r="50" fill="none" stroke-width="8" stroke-linecap="butt" stroke-dasharray="78.54 235.62" transform="rotate(180 60 60)"/>
      </svg>
      <div class="ring-badge">
        <img src="{{$logo ? asset('uploads/'.$logo) : asset('assets/img/logo.png') }}" alt="">
      </div>
    </div>
  </header>

  <!-- Step ticks -->
  <div class="flex items-center justify-between sm:justify-start sm:gap-8 mb-8 sm:mb-10 font-mono text-xs" id="stepper">
    @foreach(['Personal','Academic','Placement','Review'] as $i => $label)
      <div class="step-tick flex items-center gap-2" data-tick="{{ $i + 1 }}">
        <span class="dot"></span>
        <span class="hidden xs:inline sm:inline">{{ $label }}</span>
      </div>
    @endforeach
  </div>

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

    <!-- STEP 1 — Personal Information -->
    <section class="step-panel active" data-step="1">
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
            <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
            <p class="err-msg">Enter a valid email address.</p>
          </div>
        </div>

        <div>
          <label class="field-label">Home address</label>
          <input type="text" name="address" value="{{ old('address') }}" placeholder="Street, city" required>
          <p class="err-msg">Enter your home address.</p>
        </div>

      </div>
    </section>

    <!-- STEP 2 — Academic Information -->
    <section class="step-panel" data-step="2">
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
    <section class="step-panel" data-step="3">
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
    <section class="step-panel" data-step="4">
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
  const steps = Array.from(document.querySelectorAll('.step-panel'));
  const ticks = Array.from(document.querySelectorAll('[data-tick]'));
  const ringSegs = Array.from(document.querySelectorAll('.ring-seg'));
  const stepCounter = document.getElementById('stepCounter');
  const stepLabels = ['Personal information','Academic information','Placement preference','Review & payment'];
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const submitBtn = document.getElementById('submitBtn');
  const form = document.getElementById('siwesForm');
  const trackSelect = document.getElementById('trackSelect');
  const amountInput = document.getElementById('amountInput');
  const trackFeeLabel = document.getElementById('trackFeeLabel');
  const MIN_AMOUNT = 10000;
  let current = 1;

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

    // Only auto-fill if the user hasn't typed a custom amount yet
    if (!amountInput.dataset.touched) {
      amountInput.value = Math.max(price, MIN_AMOUNT);
    }
  }

  function validateStep(n){
    let valid = true;
    fieldsForStep(n).forEach(el => {
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
      ['Email', data.get('email')],
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
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  nextBtn.addEventListener('click', () => {
    if (!validateStep(current)) return;
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
    const step3Valid = validateStep(3);
    const step4Valid = validateStep(4);
    if (!step3Valid || !step4Valid) {
      e.preventDefault();
      current = !step3Valid ? 3 : 4;
      showStep(current);
    }
  });

  showStep(1);
})();
</script>
</body>
</html>