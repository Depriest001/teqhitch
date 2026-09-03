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
  <title>SIWES / IT Placement — {{ $globalSetting->site_name ?? 'Teqhitch' }}</title>

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

    .brand-bar{ height:4px; background:linear-gradient(90deg,var(--blue),var(--cyan),var(--teal),var(--leaf)); }

    .btn-primary{ background:linear-gradient(135deg, #1657FF 0%, #17B4D9 55%, #2BD480 100%); color:#fff; }
    .btn-primary:hover{ background:linear-gradient(135deg, #1657FFBF 0%, #17B4D9BF 55%, #2BD480BF 100%); }
    .btn-ghost{ background:var(--ink); color:#fff; }
    .btn-ghost:hover{ background:var(--ink-2); }

    .card{ background:var(--surface); border:1.5px solid var(--line-2); border-radius:1rem; }

    .step-num{
      width:2rem; height:2rem; border-radius:9999px; display:flex; align-items:center; justify-content:center;
      font-family:'IBM Plex Mono',monospace; font-weight:600; font-size:.85rem; flex-shrink:0;
      background:rgba(27,111,224,.10); color:var(--blue);
    }

    @media (prefers-reduced-motion: no-preference){
      .float-badge{ animation: floaty 5s ease-in-out infinite; }
    }
    @keyframes floaty{ 0%,100%{ transform:translateY(0); } 50%{ transform:translateY(-8px); } }
  </style>
</head>
<body class="min-h-screen">

<div class="brand-bar"></div>

<!-- Header -->
<header class="max-w-5xl mx-auto px-4 sm:px-6 pt-8 sm:pt-10 flex items-center justify-between">
  <div class="flex items-center gap-3 min-w-0">
    <img src="{{ $logo ? asset('uploads/'.$logo) : asset('assets/img/logo.png') }}" alt="{{ $globalSetting->site_name ?? 'Teqhitch' }}" class="w-10 h-10 sm:w-11 sm:h-11 rounded-full shrink-0" style="box-shadow:0 1px 2px rgba(11,35,64,.10)">
    <p class="font-display text-base sm:text-lg font-semibold" style="color:var(--ink)">{{ $globalSetting->site_name ?? 'Teqhitch' }}</p>
  </div>
  <a href="{{ route('siwes.create') }}" class="hidden sm:inline-block px-5 py-2.5 rounded-xl text-sm font-semibold btn-primary">Apply now</a>
</header>

<!-- Hero -->
<section class="max-w-5xl mx-auto px-4 sm:px-6 pt-12 sm:pt-16 pb-12 sm:pb-16 text-center">
  <p class="font-mono text-xs uppercase tracking-wide mb-4" style="color:var(--teal)">SIWES · Industrial Training Placement</p>
  <h1 class="font-display text-3xl sm:text-5xl font-semibold leading-tight mb-5" style="color:var(--ink)">
    Get placed. Get trained.<br>Get certified.
  </h1>
  <p class="max-w-xl mx-auto text-sm sm:text-base mb-8" style="color:var(--muted)">
    Apply for your SIWES / IT placement in minutes. Pick a track, submit your details,
    and pay your placement fee straight into a dedicated account — no card required.
  </p>
  <a href="{{ route('siwes.create') }}" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl text-sm sm:text-base font-semibold btn-primary">
    Start your application
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
  </a>
  <p class="font-mono text-xs mt-4" style="color:#A8B2C4">Takes about 5 minutes · 4 short steps</p>
</section>

<!-- How it works -->
<section class="max-w-5xl mx-auto px-4 sm:px-6 pb-14 sm:pb-20">
  <h2 class="font-display text-lg sm:text-xl font-semibold text-center mb-8" style="color:var(--ink)">How it works</h2>
  <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
    @foreach([
      ['1', 'Personal info', 'Tell us who you are, exactly as it appears on your school ID.'],
      ['2', 'Academic info', 'Share your institution, course and SIWES dates.'],
      ['3', 'Choose a track', 'Pick the placement track you\'ll train in.'],
      ['4', 'Review & pay', 'Confirm your details and pay into a dedicated account.'],
    ] as [$n, $title, $desc])
      <div class="card p-5">
        <div class="step-num mb-3">{{ $n }}</div>
        <p class="font-semibold text-sm mb-1" style="color:var(--ink)">{{ $title }}</p>
        <p class="text-xs" style="color:var(--muted)">{{ $desc }}</p>
      </div>
    @endforeach
  </div>
</section>

<!-- Tracks (optional — only renders if $tracks was passed to this view) -->
@isset($tracks)
  @if($tracks->count())
    <section class="max-w-5xl mx-auto px-4 sm:px-6 pb-14 sm:pb-20">
      <h2 class="font-display text-lg sm:text-xl font-semibold text-center mb-8" style="color:var(--ink)">Available tracks</h2>
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach($tracks as $track)
          <div class="card p-5">
            <p class="font-semibold text-sm mb-1" style="color:var(--ink)">{{ $track->name }}</p>
            <p class="font-mono text-xs" style="color:var(--teal)">₦{{ number_format($track->price, 2) }}</p>
          </div>
        @endforeach
      </div>
    </section>
  @endif
@endisset

<!-- Final CTA -->
<section class="max-w-5xl mx-auto px-4 sm:px-6 pb-16 sm:pb-24">
  <div class="card p-8 sm:p-10 text-center" style="background:linear-gradient(135deg, rgba(27,111,224,.06), rgba(47,194,232,.06), rgba(86,197,106,.06))">
    <h2 class="font-display text-xl sm:text-2xl font-semibold mb-2" style="color:var(--ink)">Ready to begin?</h2>
    <p class="text-sm mb-6" style="color:var(--muted)">Your application is saved as you go — you can pick up where you left off.</p>
    <a href="{{ route('siwes.create') }}" class="inline-block px-7 py-3.5 rounded-xl text-sm sm:text-base font-semibold btn-primary">Apply for SIWES placement</a>
  </div>
</section>

<footer class="pt-2 pb-10 text-center">
  <p class="font-mono text-xs" style="color:#A8B2C4">{{ $globalSetting->site_name ?? 'Teqhitch' }} · SIWES / IT Placement Programme</p>
</footer>

</body>
</html>