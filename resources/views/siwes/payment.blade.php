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
  <title>Complete Payment - {{ $globalSetting->site_name ?? 'Teqhitch' }}</title>

  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Manrope:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
  <style>
    :root{ --navy:#0B1E3D; --navy-2:#132A52; --gold:#D4A94D; --sky:#38BDF8; --leaf:#34D399; --paper:#F7F8FB; }
    body{ font-family:'Manrope',sans-serif; background:var(--paper); }
    .font-display{ font-family:'Fraunces',serif; }
    .font-mono{ font-family:'IBM Plex Mono',monospace; }

    .orbit-ring{ background: conic-gradient(from 210deg, var(--navy) 0deg, #1E4FA0 90deg, var(--sky) 180deg, var(--leaf) 260deg, var(--navy) 360deg); }
    .pulse-dot{ animation: pulse 1.6s ease-in-out infinite; }
    @keyframes pulse{ 0%,100%{ opacity:1; } 50%{ opacity:.35; } }

    .progress-track{ height:4px; background:#E2E8F0; border-radius:9999px; overflow:hidden; }
    .progress-fill{ height:100%; width:66%; background:linear-gradient(90deg,var(--navy),var(--sky)); border-radius:9999px; transition:width .5s ease; }

    .acct-number{ letter-spacing:.06em; }
    .copy-flash{ animation: flash .6s ease; }
    @keyframes flash{ 0%{ background:rgba(56,189,248,.18); } 100%{ background:transparent; } }
  </style>
</head>
<body class="min-h-screen">

<div class="max-w-xl mx-auto px-5 py-10 md:py-16">

  <header class="mb-6 flex items-center gap-4">
    <div class="orbit-ring w-12 h-12 rounded-full flex items-center justify-center shrink-0 p-[3px]">
      <img src="{{ $logo ? asset('uploads/'.$logo) : asset('assets/img/logo.png') }}" alt="{{ $globalSetting->site_name ?? 'Teqhitch' }}" class="w-full h-full rounded-full object-cover bg-white">
    </div>
    <div>
      <p class="font-mono text-xs uppercase tracking-widest" style="color:var(--sky)">{{ $globalSetting->site_name ?? 'Teqhitch ICT Academy' }}</p>
      <h1 class="font-display text-2xl font-semibold" style="color:var(--navy)">Complete Your Payment</h1>
    </div>
  </header>

  <div class="mb-8">
    <div class="progress-track"><div class="progress-fill"></div></div>
    <div class="flex justify-between mt-2 text-xs font-mono text-slate-400">
      <span style="color:var(--navy)">Application submitted</span>
      <span style="color:var(--sky)">Awaiting payment</span>
      <span>Confirmed</span>
    </div>
  </div>

  <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-slate-100 space-y-6">

    <div class="flex items-center gap-2 text-sm rounded-xl px-4 py-3" id="statusRow" style="background:rgba(245,158,11,.08)">
      <span class="w-2.5 h-2.5 rounded-full bg-amber-400 pulse-dot" id="statusDot"></span>
      <span class="font-medium" id="statusText" style="color:var(--navy)">Waiting for payment…</span>
    </div>

    <p class="text-sm text-slate-500 leading-relaxed">
      Transfer exactly <strong style="color:var(--navy)">₦{{ number_format($application->amount, 2) }}</strong>
      to the dedicated account below. Your placement is confirmed automatically the moment the transfer lands —
      no need to refresh this page.
    </p>

    <div class="rounded-xl border p-5 space-y-3" style="border-color:#EADFC2; background:rgba(212,169,77,.06)">
      <div class="flex justify-between items-center">
        <span class="font-mono text-xs uppercase text-slate-500">Bank</span>
        <span class="font-medium" style="color:var(--navy)">{{ $application->virtual_account_bank ?? 'Pending' }}</span>
      </div>
      <div class="flex justify-between items-center">
        <span class="font-mono text-xs uppercase text-slate-500">Account Number</span>
        <span class="font-mono text-lg font-semibold acct-number" style="color:var(--navy)" id="acctNumber">{{ $application->virtual_account_number ?? '—' }}</span>
      </div>
      <div class="flex justify-between items-center">
        <span class="font-mono text-xs uppercase text-slate-500">Account Name</span>
        <span class="font-medium" style="color:var(--navy)">{{ $application->virtual_account_name ?? $application->full_name }}</span>
      </div>
      <div class="flex justify-between items-center border-t pt-3" style="border-color:#EADFC2">
        <span class="font-mono text-xs uppercase text-slate-500">Amount</span>
        <span class="font-mono font-semibold text-base" style="color:var(--gold)">₦{{ number_format($application->amount, 2) }}</span>
      </div>
    </div>

    <button type="button" id="copyBtn" class="w-full py-2.5 rounded-xl text-sm font-semibold border transition" style="border-color:var(--navy); color:var(--navy)">
      Copy Account Number
    </button>

    <div class="border-t border-slate-100 pt-4 text-sm text-slate-500 space-y-1">
      <p>Application Reference: <span class="font-mono" style="color:var(--navy)">{{ $application->reference }}</span></p>
      <p>Track: <span style="color:var(--navy)">{{ $application->trackLabel() }}</span></p>
    </div>

  </div>

  <p class="text-center text-xs text-slate-400 mt-6">Keep your reference number safe — you'll need it if you contact the academy about this application.</p>
</div>

<script>
(function(){
  const statusEl = document.getElementById('statusText');
  const statusRow = document.getElementById('statusRow');
  const dotEl = document.getElementById('statusDot');
  const statusUrl = "{{ route('siwes.payment.status', $application->reference) }}";
  const successUrl = "{{ route('siwes.payment.success', $application->reference) }}";

  async function poll(){
    try {
      const res = await fetch(statusUrl, { headers: { 'Accept': 'application/json' } });
      const data = await res.json();
      if (data.status === 'paid') {
        statusEl.textContent = 'Payment received — redirecting…';
        statusRow.style.background = 'rgba(52,211,153,.10)';
        dotEl.classList.remove('bg-amber-400','pulse-dot');
        dotEl.classList.add('bg-emerald-500');
        clearInterval(timer);
        setTimeout(() => { window.location.href = successUrl; }, 1200);
      }
    } catch (e) { /* silent retry */ }
  }

  const timer = setInterval(poll, 5000);
  poll();

  document.getElementById('copyBtn').addEventListener('click', () => {
    const acct = document.getElementById('acctNumber').textContent.trim();
    navigator.clipboard.writeText(acct).then(() => {
      const btn = document.getElementById('copyBtn');
      const original = btn.textContent;
      btn.textContent = 'Copied!';
      btn.classList.add('copy-flash');
      setTimeout(() => { btn.textContent = original; btn.classList.remove('copy-flash'); }, 1500);
    });
  });
})();
</script>
</body>
</html>