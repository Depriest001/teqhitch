<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  @php
    $favicon = $globalSetting->favicon ?? null;
    $logo    = $globalSetting->site_logo ?? null;
  @endphp

  <link rel="icon" href="{{ $favicon ? asset('uploads/'.$favicon) : asset('assets/img/favicon.jpg') }}">
  <title>@yield('title', 'Sign in') | {{ $globalSetting->site_name ?? 'Teqhitch' }}</title>

  <!-- Tailwind CSS v4 Browser Compiler CDN -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    :root{
      --canvas:#F5F7FB;
      --surface:#FFFFFF;
      --surface-alt:#EEF1F8;
      --ink:#0E1526;
      --ink-muted:#5C6478;
      --line:#E3E7F0;
      --navy:#0B1224;
      --navy-soft:#141B31;
      --navy-line:#232C48;
      --blue:#1657FF;
      --cyan:#17B4D9;
      --green:#2BD480;
      --amber:#FFB020;
      --purple:#7C5CFA;
      --pink:#F43F7E;
      --orange:#FF7A45;
    }
    html{scroll-behavior:smooth;}
    body{background:var(--surface); color:var(--ink); font-family:'Inter',sans-serif;}
    .font-display{font-family:'Space Grotesk',sans-serif;}
    .font-mono{font-family:'JetBrains Mono',monospace;}
    .brand-gradient{background:linear-gradient(135deg, var(--blue) 0%, var(--cyan) 55%, var(--green) 100%);}
    ::-webkit-scrollbar{width:8px;}
    ::-webkit-scrollbar-thumb{background:#CBD3E1; border-radius:8px;}

    .input-field{
      width:100%; background:var(--surface-alt); border:1.5px solid transparent;
      border-radius:10px; padding:11px 14px; font-size:14px; color:var(--ink);
      transition:border-color .15s ease, background .15s ease;
    }
    .input-field:focus{outline:none; border-color:var(--blue); background:#fff;}
    .input-field.field-error{border-color:var(--pink); background:#fff;}
    .field-label{font-size:12.5px; font-weight:600; margin-bottom:6px; display:block;}
    .err-msg{font-size:12px; color:var(--pink); margin-top:5px;}

    .focus-ring:focus-visible{outline:2px solid var(--blue); outline-offset:2px;}

    .seg-btn{transition:background .15s ease, color .15s ease;}

    /* decorative dot grid echoing the dashboard heatmap */
    .dot-grid{
      background-image:radial-gradient(circle, rgba(255,255,255,0.16) 1.4px, transparent 1.4px);
      background-size:16px 16px;
    }
    .blob{position:absolute; border-radius:9999px; filter:blur(60px); opacity:.55;}

    @media (prefers-reduced-motion: reduce){ *{animation:none !important; transition:none !important;} }

    @stack('styles')
  </style>
</head>
<body class="antialiased">

<div class="min-h-screen lg:h-screen lg:grid lg:grid-cols-2 lg:overflow-hidden">

  <!-- ============ LEFT / BRAND PANEL ============ -->
  <aside class="relative hidden lg:flex lg:h-full flex-col justify-between overflow-hidden p-12 xl:p-16" style="background:var(--navy);">
    <div class="blob w-[420px] h-[420px] -top-32 -left-24" style="background:var(--blue);"></div>
    <div class="blob w-[380px] h-[380px] bottom-[-140px] right-[-100px]" style="background:var(--green);"></div>
    <div class="absolute inset-0 dot-grid opacity-40"></div>

    <!-- Logo -->
    <div class="relative flex items-center gap-3">
      <img src="{{$logo ? asset('uploads/'.$logo) : asset('assets/img/logo.png') }}" alt="Logo" width="50" class="rounded-lg">
      <span class="font-display font-700 text-white text-[19px]" style="font-weight:700;">{{ $globalSetting->site_name ?? 'Teqhitch' }}</span>
    </div>

    <!-- Headline -->
    <div class="relative max-w-md">
      <h1 class="font-display font-700 text-white text-[34px] xl:text-[38px] leading-[1.15]" style="font-weight:700;">
        Learn to code.<br/>Build your future.
      </h1>
      <p class="mt-4 text-[15px] leading-relaxed" style="color:#AEB6D4;">
        Your courses, progress and mentor feedback — all in one hub built for {{ $globalSetting->site_name ?? 'Teqhitch' }} students.
      </p>

      <ul class="mt-8 space-y-3.5">
        <li class="flex items-center gap-3 text-[13.5px]" style="color:#DDE2F2;">
          <span class="h-8 w-8 rounded-lg grid place-items-center shrink-0" style="background:rgba(22,87,255,0.18);">
            <svg class="h-4 w-4" style="color:#6E9BFF;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V2H6.5A2.5 2.5 0 0 0 4 4.5v15Z"/><path d="M4 19.5A2.5 2.5 0 0 0 6.5 22H20v-3"/></svg>
          </span>
          Hands-on courses taught by industry mentors
        </li>
        <li class="flex items-center gap-3 text-[13.5px]" style="color:#DDE2F2;">
          <span class="h-8 w-8 rounded-lg grid place-items-center shrink-0" style="background:rgba(43,212,128,0.16);">
            <svg class="h-4 w-4" style="color:#4FE3A3;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 20V10M12 20V4M20 20v-7"/></svg>
          </span>
          Track your progress across every track
        </li>
        <li class="flex items-center gap-3 text-[13.5px]" style="color:#DDE2F2;">
          <span class="h-8 w-8 rounded-lg grid place-items-center shrink-0" style="background:rgba(23,180,217,0.18);">
            <svg class="h-4 w-4" style="color:#5FD3EE;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
          </span>
          Certificates & career-ready projects
          <span class="text-[9.5px] font-mono px-1.5 py-0.5 rounded" style="background:rgba(43,212,128,0.18); color:#4FE3A3;">NEW</span>
        </li>
      </ul>
    </div>

    <!-- Bottom stat -->
    <div class="relative flex items-center gap-6 pt-8" style="border-top:1px solid var(--navy-line);">
      <div>
        <p class="font-mono font-600 text-white text-xl" style="font-weight:600;">500+</p>
        <p class="text-[11.5px]" style="color:#7B87AC;">students trained</p>
      </div>
      <div>
        <p class="font-mono font-600 text-white text-xl" style="font-weight:600;">13</p>
        <p class="text-[11.5px]" style="color:#7B87AC;">technology tracks</p>
      </div>
      <div>
        <p class="font-mono font-600 text-white text-xl" style="font-weight:600;">92%</p>
        <p class="text-[11.5px]" style="color:#7B87AC;">avg. attendance rate</p>
      </div>
    </div>
  </aside>

  <!-- ============ RIGHT / FORM PANEL ============ -->
  <div class="flex flex-col min-h-screen lg:h-full lg:overflow-y-auto">
    <div class="flex-1 flex items-center justify-center px-6 py-10">
      <div class="w-full max-w-[400px]">

        <!-- Mobile logo -->
        <div class="flex lg:hidden items-center gap-2.5 mb-8">
          <img src="{{ $logo ? asset('uploads/'.$logo) : asset('assets/img/logo.jpg') }}" alt="Logo" width="34" class="rounded-lg">
          <span class="font-display font-700 text-[17px]" style="font-weight:700;">{{ $globalSetting->site_name ?? 'Teqhitch' }}</span>
        </div>

        @yield('content')

        <p class="text-center text-[12px] mt-10" style="color:var(--ink-muted);">{{ $globalSetting->site_name ?? 'Teqhitch' }} &middot; Student Hub</p>
      </div>
    </div>
  </div>
</div>

<script>
  // Password visibility toggles (shared across login / register / reset forms)
  document.querySelectorAll('.pw-toggle').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      const input = btn.previousElementSibling;
      const open = btn.querySelector('.eye-open');
      const closed = btn.querySelector('.eye-closed');
      const show = input.type === 'password';
      input.type = show ? 'text' : 'password';
      open.classList.toggle('hidden', show);
      closed.classList.toggle('hidden', !show);
    });
  });
</script>

@stack('scripts')
</body>
</html>