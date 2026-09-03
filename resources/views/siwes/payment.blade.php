<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @php
    $favicon = $globalSetting->favicon ?? null;
    $logo    = $globalSetting->site_logo ?? null;

    $expiresAt = $application->virtual_account_expires_at
        ?? optional($application->updated_at)->addMinutes(30);
  @endphp
  <link rel="icon" href="{{ $favicon ? asset('storage/'.$favicon) : asset('assets/img/favicon.jpg') }}">
  <title>Complete Payment | {{ $globalSetting->site_name ?? 'Teqhitch' }}</title>

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
      --amber:    #E8A33D;
      --danger:   #D2402C;
      --success:  #1FA968;
      --paper:    #F5F7FB;
      --surface:  #FFFFFF;
      --line:     #E2E7F0;
      --line-2:   #EDF0F6;
      --muted:    #64738C;

      /* Current ring accent — swapped between blue/amber/danger/success by JS
         as the countdown crosses its thresholds. Declared once here so both
         the SVG stroke and the digit color stay in sync from one source. */
      --ring-color: var(--blue);
    }
    *{ box-sizing:border-box; }
    body{
      font-family:'Inter',sans-serif;
      background:
        radial-gradient(1100px 460px at 10% -10%, rgba(27,111,224,.07), transparent 55%),
        var(--paper);
      color:var(--ink);
    }
    .font-display{ font-family:'Space Grotesk',sans-serif; letter-spacing:-.01em; }
    .font-mono{ font-family:'IBM Plex Mono',monospace; }

    .brand-bar{ height:4px; background:linear-gradient(90deg,var(--blue),var(--cyan),var(--success)); }

    /* --- Progress tracker (mirrors the step-tick device from the
       application form, so this page reads as the same flow continuing) --- */
    .track-tick{ color:#A8B2C4; }
    .track-tick.is-done{ color:var(--ink); }
    .track-tick.is-current{ color:var(--ink); font-weight:600; }
    .track-tick .dot{ width:6px; height:6px; border-radius:9999px; background:#C7D2E3; }
    .track-tick.is-done .dot{ background:var(--success); }
    .track-tick.is-current .dot{ background:var(--ring-color); transition:background-color .4s ease; }

    /* --- Countdown ring --- */
    .ring-wrap{ position:relative; width:112px; height:112px; margin:0 auto; }
    .ring-wrap svg{ width:100%; height:100%; }
    .ring-track{ stroke:var(--line); fill:none; }
    .ring-fill{
      stroke:var(--ring-color); fill:none; stroke-linecap:round;
      transform:rotate(-90deg); transform-origin:50% 50%;
      transition: stroke-dashoffset 1s linear, stroke .4s ease;
    }
    .ring-center{ position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; }
    .ring-time{ font-variant-numeric:tabular-nums; color:var(--ring-color); transition:color .4s ease; }

    @media (prefers-reduced-motion: reduce){
      .ring-fill{ transition:stroke .4s ease; }
      .pulse-dot{ animation:none !important; }
    }
    .pulse-dot{ animation: pulse 1.6s ease-in-out infinite; }
    @keyframes pulse{ 0%,100%{ opacity:1; } 50%{ opacity:.35; } }

    .kv-row{ display:flex; justify-content:space-between; align-items:center; gap:1rem; }
    .kv-label{ font-size:.82rem; color:var(--muted); }
    .kv-value{ font-family:'IBM Plex Mono',monospace; color:var(--ink); text-align:right; }

    .btn-outline{
      background:transparent; border:1.5px solid var(--ink); color:var(--ink);
    }
    .btn-outline:hover{ background:var(--ink); color:#fff; }
    .btn-outline:disabled{ opacity:.4; cursor:not-allowed; border-color:var(--line); color:var(--muted); background:transparent; }
    .btn-primary{ background:linear-gradient(135deg, var(--blue), var(--cyan)); color:#fff; }
    .btn-primary:hover{ filter:brightness(.95); }

    .copy-flash{ animation:flash .6s ease; }
    @keyframes flash{ 0%{ background:rgba(27,111,224,.16); } 100%{ background:transparent; } }

    .card-dim{ opacity:.55; filter:grayscale(.3); pointer-events:none; }

    .status-pill{ display:flex; align-items:center; gap:.6rem; border-radius:.9rem; padding:.7rem 1rem; font-size:.9rem; }
  </style>
</head>
<body class="min-h-screen">

<div class="brand-bar"></div>

<div class="max-w-lg mx-auto px-5 py-10 md:py-14">

  <header class="mb-7 flex items-center gap-3">
    <img src="{{ $logo ? asset('uploads/'.$logo) : asset('assets/img/logo.png') }}" alt="" class="w-10 h-10 rounded-full shrink-0" style="box-shadow:0 1px 2px rgba(11,35,64,.10)">
    <div>
      <p class="font-mono text-xs" style="color:var(--muted)">{{ $globalSetting->site_name ?? 'Teqhitch ICT Academy' }}</p>
      <h1 class="font-display text-xl md:text-2xl font-semibold" style="color:var(--ink)">Complete your payment</h1>
    </div>
  </header>

  <div class="flex items-center gap-6 mb-8 font-mono text-xs" id="tracker">
    <div class="track-tick is-done flex items-center gap-2"><span class="dot"></span>Submitted</div>
    <div class="track-tick is-current flex items-center gap-2" id="trackCurrent"><span class="dot"></span>Awaiting payment</div>
    <div class="track-tick flex items-center gap-2"><span class="dot"></span>Confirmed</div>
  </div>

  <!-- Countdown -->
  <div class="mb-7">
    <div class="ring-wrap" role="img" aria-label="Time remaining before this account expires">
      <svg viewBox="0 0 112 112">
        <circle class="ring-track" cx="56" cy="56" r="49" stroke-width="7"/>
        <circle class="ring-fill" id="ringFill" cx="56" cy="56" r="49" stroke-width="7"
                stroke-dasharray="307.88" stroke-dashoffset="0"/>
      </svg>
      <div class="ring-center">
        <span class="font-display text-xl font-semibold ring-time" id="ringTime">30:00</span>
        <span class="text-[10px] mt-0.5" style="color:var(--muted)" id="ringSub">left to pay</span>
      </div>
    </div>
    <p class="sr-only" aria-live="polite" id="countdownAnnouncer"></p>
  </div>

  <div class="bg-[var(--surface)] rounded-2xl p-6 shadow-sm border space-y-5" style="border-color:var(--line-2)" id="paymentCard">

    <div class="status-pill" id="statusRow" style="background:rgba(232,163,61,.10)">
      <span class="w-2.5 h-2.5 rounded-full pulse-dot" id="statusDot" style="background:var(--amber)"></span>
      <span class="font-medium" id="statusText" style="color:var(--ink)">Waiting for your transfer…</span>
    </div>

    <p class="text-sm leading-relaxed" style="color:var(--muted)">
      Transfer exactly <strong style="color:var(--ink)">₦{{ number_format($application->amount, 2) }}</strong>
      to the account below. Your placement is confirmed automatically the moment the transfer lands — this page updates on its own.
    </p>

    <div class="rounded-xl border p-5 space-y-3" style="border-color:var(--line-2); background:var(--paper)" id="acctDetails">
      <div class="kv-row">
        <span class="kv-label">Bank</span>
        <span class="kv-value">{{ $application->virtual_account_bank ?? 'Generating…' }}</span>
      </div>
      <div class="kv-row">
        <span class="kv-label">Account number</span>
        <span class="kv-value text-lg font-semibold" id="acctNumber">{{ $application->virtual_account_number ?? 'Generating…' }}</span>
      </div>
      <div class="kv-row">
        <span class="kv-label">Account name</span>
        <span class="kv-value">{{ $application->virtual_account_name ?? $application->full_name }}</span>
      </div>
      <div class="kv-row border-t pt-3" style="border-color:var(--line-2)">
        <span class="kv-label">Amount</span>
        <span class="kv-value text-base font-semibold" style="color:var(--ink)">₦{{ number_format($application->amount, 2) }}</span>
      </div>
    </div>

    <button type="button" id="copyBtn" class="w-full py-2.5 rounded-xl text-sm font-semibold btn-outline transition">
      Copy account number
    </button>
  </div>

  <!-- Expired state — hidden until the countdown reaches zero -->
  <div class="mt-4 rounded-2xl p-5 border text-sm hidden" id="expiredNotice" style="border-color:#F3C7BF; background:#FCF0EE; color:var(--danger)">
    <p class="font-semibold mb-1">This account has expired.</p>
    <p class="mb-3" style="color:var(--ink)">Dynamic accounts are only valid for 30 minutes. If you didn't complete your transfer in time, request a new account below — your application details are already saved.</p>
    @if (\Illuminate\Support\Facades\Route::has('siwes.payment.regenerate'))
      <a href="{{ route('siwes.payment.regenerate', $application->reference) }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold btn-primary">Get a new account</a>
    @else
      <p class="font-mono text-xs" style="color:var(--muted)">Contact the academy with your reference number below to get a new payment account.</p>
    @endif
  </div>

  <div class="border-t mt-6 pt-4 text-sm space-y-1" style="border-color:var(--line-2); color:var(--muted)">
    <p>Application reference: <span class="font-mono" style="color:var(--ink)">{{ $application->reference }}</span></p>
    <p>Track: <span style="color:var(--ink)">{{ $application->trackLabel() }}</span></p>
  </div>

  <p class="text-center text-xs mt-6" style="color:#A8B2C4">Keep your reference number safe — you'll need it if you contact the academy about this application.</p>
</div>

<script>
(function(){
  const statusEl   = document.getElementById('statusText');
  const statusRow  = document.getElementById('statusRow');
  const dotEl      = document.getElementById('statusDot');
  const trackCurrent = document.getElementById('trackCurrent');
  const statusUrl  = "{{ route('siwes.payment.status', $application->reference) }}";
  const successUrl = "{{ route('siwes.payment.success', $application->reference) }}";

  const expiresAtRaw = @json(optional($expiresAt)->toIso8601String());
  const expiresAt = expiresAtRaw ? new Date(expiresAtRaw).getTime() : null;

  const ringFill = document.getElementById('ringFill');
  const ringTime = document.getElementById('ringTime');
  const ringSub  = document.getElementById('ringSub');
  const announcer = document.getElementById('countdownAnnouncer');
  const paymentCard = document.getElementById('paymentCard');
  const expiredNotice = document.getElementById('expiredNotice');
  const copyBtn = document.getElementById('copyBtn');

  const CIRC = 2 * Math.PI * 49; // matches r=49 on the ring
  const TOTAL_MS = 30 * 60 * 1000;
  let announced5min = false, announced1min = false;
  let expired = false;
  let paid = false;

  function setRingColor(varName){
    document.documentElement.style.setProperty('--ring-color', 'var(' + varName + ')');
  }

  function formatTime(ms){
    const totalSeconds = Math.max(0, Math.ceil(ms / 1000));
    const m = Math.floor(totalSeconds / 60);
    const s = totalSeconds % 60;
    return m + ':' + String(s).padStart(2, '0');
  }

  function tickCountdown(){
    if (paid || expired || !expiresAt) return;

    const remaining = expiresAt - Date.now();

    if (remaining <= 0) {
      expired = true;
      ringFill.style.strokeDashoffset = CIRC;
      ringTime.textContent = '0:00';
      ringSub.textContent = 'expired';
      setRingColor('--danger');
      statusRow.style.background = 'rgba(210,64,44,.08)';
      dotEl.style.background = 'var(--danger)';
      dotEl.classList.remove('pulse-dot');
      statusEl.textContent = 'This account has expired';
      trackCurrent.querySelector('.dot').style.background = 'var(--danger)';
      paymentCard.classList.add('card-dim');
      copyBtn.disabled = true;
      expiredNotice.classList.remove('hidden');
      announcer.setAttribute('aria-live', 'assertive');
      announcer.textContent = 'This payment account has expired.';
      clearInterval(countdownTimer);
      clearInterval(statusTimer);
      return;
    }

    const fraction = remaining / TOTAL_MS;
    ringFill.style.strokeDashoffset = String(CIRC * (1 - fraction));
    ringTime.textContent = formatTime(remaining);

    if (remaining <= 60 * 1000) {
      setRingColor('--danger');
      if (!announced1min) { announced1min = true; announcer.textContent = 'Less than 1 minute left to pay.'; }
    } else if (remaining <= 5 * 60 * 1000) {
      setRingColor('--amber');
      if (!announced5min) { announced5min = true; announcer.textContent = '5 minutes left to pay.'; }
    } else {
      setRingColor('--blue');
    }
  }

  async function pollStatus(){
    if (expired || paid) return;
    try {
      const res = await fetch(statusUrl, { headers: { 'Accept': 'application/json' } });
      const data = await res.json();
      if (data.status === 'paid') {
        paid = true;
        ringSub.textContent = 'confirmed';
        setRingColor('--success');
        statusEl.textContent = 'Payment received — redirecting…';
        statusRow.style.background = 'rgba(31,169,104,.10)';
        dotEl.classList.remove('pulse-dot');
        dotEl.style.background = 'var(--success)';
        trackCurrent.classList.remove('is-current');
        trackCurrent.classList.add('is-done');
        trackCurrent.querySelector('.dot').style.background = 'var(--success)';
        announcer.setAttribute('aria-live', 'assertive');
        announcer.textContent = 'Payment received. Redirecting.';
        clearInterval(countdownTimer);
        clearInterval(statusTimer);
        setTimeout(() => { window.location.href = successUrl; }, 1200);
      }
    } catch (e) { /* silent retry */ }
  }

  tickCountdown();
  const countdownTimer = setInterval(tickCountdown, 1000);
  const statusTimer = setInterval(pollStatus, 5000);
  pollStatus();

  copyBtn.addEventListener('click', () => {
    if (copyBtn.disabled) return;
    const acct = document.getElementById('acctNumber').textContent.trim();
    navigator.clipboard.writeText(acct).then(() => {
      const original = copyBtn.textContent;
      copyBtn.textContent = 'Copied!';
      copyBtn.classList.add('copy-flash');
      setTimeout(() => { copyBtn.textContent = original; copyBtn.classList.remove('copy-flash'); }, 1500);
    });
  });
})();
</script>
</body>
</html>