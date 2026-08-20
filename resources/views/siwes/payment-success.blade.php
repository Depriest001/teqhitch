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
  <title>Payment Successful - {{ $globalSetting->site_name ?? 'Teqhitch' }}</title>

  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Manrope:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
  <style>
    :root{ --navy:#0B1E3D; --gold:#D4A94D; --sky:#38BDF8; --leaf:#34D399; --paper:#F7F8FB; }
    body{ font-family:'Manrope',sans-serif; background:var(--paper); }
    .font-display{ font-family:'Fraunces',serif; }
    .font-mono{ font-family:'IBM Plex Mono',monospace; }
    .orbit-ring{ background: conic-gradient(from 210deg, var(--navy) 0deg, #1E4FA0 90deg, var(--sky) 180deg, var(--leaf) 260deg, var(--navy) 360deg); }

    .check-pop{ animation: pop .5s cubic-bezier(.34,1.56,.64,1); }
    @keyframes pop{ 0%{ transform:scale(0); opacity:0; } 70%{ transform:scale(1.1); } 100%{ transform:scale(1); opacity:1; } }

    .progress-track{ height:4px; background:#E2E8F0; border-radius:9999px; overflow:hidden; }
    .progress-fill{ height:100%; width:100%; background:linear-gradient(90deg,var(--navy),var(--leaf)); border-radius:9999px; }

    .cred-value{ letter-spacing:.03em; }
    .reveal-btn{ cursor:pointer; }
  </style>
</head>
<body class="min-h-screen">

<div class="max-w-xl mx-auto px-3 py-10 md:py-16">

  <header class="mb-6 flex items-center gap-4">
    <div class="orbit-ring w-12 h-12 rounded-full flex items-center justify-center shrink-0 p-[3px]">
      <img src="{{ $logo ? asset('uploads/'.$logo) : asset('assets/img/logo.png') }}" alt="{{ $globalSetting->site_name ?? 'Teqhitch' }}" class="w-full h-full rounded-full object-cover bg-white">
    </div>
    <div>
      <p class="font-mono text-xs uppercase tracking-widest" style="color:var(--sky)">{{ $globalSetting->site_name ?? 'Teqhitch ICT Academy' }}</p>
      <h1 class="font-display text-2xl font-semibold" style="color:var(--navy)">Payment Successful</h1>
    </div>
  </header>

  <div class="mb-8">
    <div class="progress-track"><div class="progress-fill"></div></div>
    <div class="flex justify-between mt-2 text-xs font-mono text-slate-400">
      <span style="color:var(--navy)">Application submitted</span>
      <span style="color:var(--navy)">Payment received</span>
      <span style="color:var(--leaf)">Confirmed</span>
    </div>
  </div>

  <div class="bg-white rounded-2xl p-4 md:p-8 shadow-sm border border-slate-100 space-y-6">

    <div class="flex flex-col items-center text-center gap-3 py-2">
      <div class="w-16 h-16 rounded-full flex items-center justify-center check-pop" style="background:rgba(52,211,153,.12)">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M4 12.5L9.5 18L20 6" stroke="var(--leaf)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div>
        <p class="font-display text-lg font-semibold" style="color:var(--navy)">You're all set, {{ explode(' ', $application->full_name)[0] }}!</p>
        <p class="text-sm text-slate-500 mt-1">Your SIWES placement application and payment have been confirmed.</p>
      </div>
    </div>

    <div class="rounded-xl border p-5 space-y-2 text-sm" style="border-color:#EADFC2; background:rgba(212,169,77,.06)">
      <div class="flex justify-between items-center gap-2 min-w-0">
        <span class="text-slate-500 shrink-0">Reference</span>
        <span class="font-mono text-right break-all min-w-0" style="color:var(--navy)">
            {{ $application->reference }}
        </span>
      </div>
      <div class="flex justify-between"><span class="text-slate-500">Track</span><span style="color:var(--navy)">{{ $application->trackLabel() }}</span></div>
      <div class="flex justify-between"><span class="text-slate-500">Amount Paid</span><span class="font-mono font-semibold" style="color:var(--gold)">₦{{ number_format($application->amount, 2) }}</span></div>
    </div>

    <div class="rounded-xl p-5 space-y-4" style="background:rgba(56,189,248,.06); border:1px solid rgba(56,189,248,.25)">
      <div>
        <p class="font-medium text-sm" style="color:var(--navy)">Your Student Portal Login</p>
        <p class="text-xs text-slate-500 mt-0.5">Use these details to track your placement, view updates, and download documents.</p>
      </div>

      <div class="space-y-2">
        <div class="flex justify-between items-center gap-2 bg-white rounded-lg border border-slate-200 px-3 py-2.5 min-w-0">
            <span class="font-mono text-xs uppercase text-slate-400 shrink-0">Email</span>
            <span class="font-mono text-sm cred-value text-right break-all min-w-0" style="color:var(--navy)">
                {{ $application->email }}
            </span>
        </div>
        <div class="flex justify-between items-center bg-white rounded-lg border border-slate-200 px-3 py-2.5">
          <span class="font-mono text-xs uppercase text-slate-400">Password</span>
          <span class="flex items-center gap-2">
            <span class="font-mono text-sm cred-value" id="pwValue" data-value="{{ $application->phone }}" style="color:var(--navy)">••••••••••</span>
            <button type="button" id="togglePw" class="reveal-btn text-xs font-medium" style="color:var(--sky)">Show</button>
          </span>
        </div>
      </div>

      <p class="text-xs text-slate-500 leading-relaxed">
        Your password is your phone number exactly as you entered it on the application form
        (e.g. <span class="font-mono">08012345678</span>). For your own security, please log in and
        change it to something only you know as soon as possible.
      </p>

      <a href="{{ route('login') }}" class="block w-full text-center py-2.5 rounded-xl text-sm font-semibold text-white" style="background:var(--navy)">
        Log In to Student Portal
      </a>
    </div>

  </div>

  <p class="text-center text-xs text-slate-400 mt-6">Keep your reference number safe — you'll need it if you contact the academy about this application.</p>
</div>

<script>
(function(){
  const btn = document.getElementById('togglePw');
  const val = document.getElementById('pwValue');
  const real = val.dataset.value;
  let shown = false;

  btn.addEventListener('click', () => {
    shown = !shown;
    val.textContent = shown ? real : '••••••••••';
    btn.textContent = shown ? 'Hide' : 'Show';
  });
})();
</script>
</body>
</html>