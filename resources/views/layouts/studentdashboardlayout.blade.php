<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  @php
    $favicon = $globalSetting->favicon ?? null;
    $logo    = $globalSetting->site_logo ?? null;
  @endphp

  <title>@yield('title', 'Student Hub')  · {{ $globalSetting->site_name ?? 'Teqhitch' }}</title>
  <link rel="icon"
    href="{{ $favicon ? asset('uploads/'.$favicon) : asset('assets/img/favicon.jpg') }}">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
  
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
      --red:#E1443A;
    }
    html{scroll-behavior:smooth;}
    body{background:var(--canvas); color:var(--ink); font-family:'Inter',sans-serif;}
    .font-display{font-family:'Space Grotesk',sans-serif;}
    .font-mono{font-family:'JetBrains Mono',monospace;}
    .brand-gradient{background:linear-gradient(135deg,var(--blue) 0%, var(--cyan) 55%, var(--green) 100%);}
    .text-gradient{background:linear-gradient(135deg,var(--blue), var(--cyan) 60%, var(--green));-webkit-background-clip:text;background-clip:text;color:transparent;}
    ::-webkit-scrollbar{width:8px; height:8px;}
    ::-webkit-scrollbar-track{background:transparent;}
    ::-webkit-scrollbar-thumb{background:#CBD3E1; border-radius:8px;}
    .navy-scroll::-webkit-scrollbar-thumb{background:#2A3457;}

    .heat-cell{width:13px; height:13px; border-radius:3px; background:var(--surface-alt);}
    .heat-0{background:#EEF1F8;} .heat-1{background:#CDEBE0;} .heat-2{background:#8FDCC0;}
    .heat-3{background:#45CB9A;} .heat-4{background:#0FA36F;}
    .heat-cell:hover{outline:1.5px solid var(--ink); outline-offset:1px; cursor:pointer;}

    .ring-progress{transform:rotate(-90deg); transform-origin:50% 50%;}
    .badge-soon{background:repeating-linear-gradient(135deg, transparent, transparent 6px, rgba(22,87,255,0.06) 6px, rgba(22,87,255,0.06) 12px);}
    .dash-border{border:1.5px dashed #B9C2D6;}
    [data-nav]{transition:background .15s ease, color .15s ease;}
    .track-chip{font-family:'JetBrains Mono',monospace; font-size:11px; letter-spacing:.02em;}

    @media (prefers-reduced-motion: reduce){ *{animation:none !important; transition:none !important;} }
    .focus-ring:focus-visible{outline:2px solid var(--blue); outline-offset:2px;}

    /* Tabs */
    .tab-panel{ display:none; }
    .tab-panel.active{ display:block; animation: fadeUp .3s ease; }
    @keyframes fadeUp{ from{ opacity:0; transform:translateY(6px);} to{ opacity:1; transform:none;} }
    .status-badge{ font-family:'JetBrains Mono',monospace; font-size:11px; letter-spacing:.03em; padding:.3rem .6rem; border-radius:9999px; }
  </style>
</head>
<body class="antialiased">

<div class="flex min-h-screen">

  <!-- ============ SIDEBAR ============ -->
  <aside id="sidebar" class="fixed lg:sticky top-0 z-40 h-screen w-[264px] shrink-0 -translate-x-full lg:translate-x-0 transition-transform duration-200" style="background:var(--navy);">
    <div class="flex h-full flex-col navy-scroll overflow-y-auto">
      <div class="flex items-center gap-3 px-6 pt-7 pb-6">
        <div class="overflow-hidden rounded-full w-10 h-10 d-flex align-items-center justify-content-center">
          <img src="{{ $logo ? asset('uploads/'.$logo) : asset('assets/img/favicon.jpg') }}" alt="" class="img-fluid">
        </div>
        <div>
          <p class="font-display font-700 text-white text-[17px] leading-none tracking-tight" style="font-weight:700;">Teqhitch</p>
          <p class="text-[11px] font-mono mt-1 tracking-wide" style="color:#7B87AC;">STUDENT HUB</p>
        </div>
      </div>

      <nav class="flex-1 px-3 space-y-0.5">
        <p class="px-3 pb-2 text-[10.5px] font-mono tracking-widest" style="color:#5C6890;">MAIN</p>

        <!-- Overview -->
        <a href="{{ route('student.dashboard') }}"
          class="w-full flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium"
          style="{{ request()->routeIs('student.dashboard') ? 'background:rgba(22,87,255,0.16); color:#EAF0FF;' : 'color:#9AA4C4;' }} ">
            <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <rect x="3" y="3" width="7" height="9" rx="1.5"/>
                <rect x="14" y="3" width="7" height="5" rx="1.5"/>
                <rect x="14" y="12" width="7" height="9" rx="1.5"/>
                <rect x="3" y="16" width="7" height="5" rx="1.5"/>
            </svg>
            Overview
        </a>

        <!-- Payment History -->
        <a href="{{ route('student.payments.index') }}"
          class="w-full flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium"
          style="{{ request()->routeIs('student.payments.*') ? 'background:rgba(22,87,255,0.16); color:#EAF0FF;' : 'color:#9AA4C4;' }} ">
            <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <rect x="2" y="5" width="20" height="14" rx="2"/>
                <path d="M2 10h20"/>
            </svg>
            Payment History
        </a>

        <!-- Enroll in Programs -->
        <a href="{{ route('student.programs.index') }}"
          class="w-full flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium"
          style="{{ request()->routeIs('student.programs.*') ? 'background:rgba(22,87,255,0.16); color:#EAF0FF;' : 'color:#9AA4C4;' }} ">
            <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
            </svg>
            Enroll in Programs
        </a>

        <p class="px-3 pt-5 pb-2 text-[10.5px] font-mono tracking-widest" style="color:#5C6890;">MORE</p>

        <!-- Certificate -->
        <a href="#"
          class="w-full flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium"
          style="{{ request()->routeIs('student.certificate') ? 'background:rgba(22,87,255,0.16); color:#EAF0FF;' : 'color:#9AA4C4;' }} ">
            <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M4 4h16v16H4z"/>
                <path d="M8 8h8"/>
                <path d="M8 12h5"/>
                <path d="M8 16h4"/>
            </svg>
            Certificate
        </a>

        <div class="w-full flex items-center justify-between gap-3 rounded-lg px-3 py-2.5 text-sm font-medium cursor-pointer" style="color:#9AA4C4;">
          <span class="flex items-center gap-3">
            <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="4" width="20" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            Online Classes
          </span>
          <span class="text-[9.5px] font-mono px-1.5 py-0.5 rounded" style="background:rgba(43,212,128,0.18); color:#4FE3A3;">SOON</span>
        </div>
      </nav>

      <div class="px-3 pb-5 pt-3 space-y-0.5" style="border-top:1px solid var(--navy-line);">
        <a href="{{ route('student.profile.settings') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium"
        style="{{ request()->routeIs('student.profile.*') ? 'background:rgba(22,87,255,0.16); color:#EAF0FF;' : 'color:#9AA4C4;' }}">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1Z"/></svg>
          Settings
        </a>
        
        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
          @csrf
          <button type="submit" class="w-full flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors" style="color:#9AA4C4;" onmouseover="this.style.color='#db0404'" onmouseout="this.style.color='#9e0505'">
            <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
            Logout
          </button>
        </form>
      </div>
    </div>
  </aside>
  <div id="scrim" class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden"></div>

  <!-- ============ MAIN ============ -->
  <div class="flex-1 min-w-0">

    <header class="sticky top-0 z-20 backdrop-blur bg-white/85 border-b" style="border-color:var(--line);">
      <div class="flex items-center gap-4 px-5 lg:px-8 h-[68px]">
        <button id="menuBtn" class="lg:hidden h-9 w-9 grid place-items-center rounded-lg border focus-ring" style="border-color:var(--line);">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>

        @php
          $student = auth()->user();
          $hour = now()->hour;
          $greeting = match(true) {
              $hour < 12 => 'Good morning',
              $hour < 17 => 'Good afternoon',
              default    => 'Good evening',
          };
          $firstName = $student ? explode(' ', trim($student->full_name))[0] : 'Guest';
          $initials  = $student
              ? collect(explode(' ', trim($student->full_name)))->map(fn($n) => strtoupper($n[0] ?? ''))->take(2)->implode('')
              : '?';
        @endphp

        <div class="hidden md:block min-w-0">
          <h1 class="font-display font-700 text-[19px] leading-tight" style="font-weight:700;" id="pageTitle">
            {{ $greeting }}, {{ $firstName }} 👋
          </h1>
          <p class="text-[12.5px]" style="color:var(--ink-muted);" id="pageSubtitle">
            {{ now()->format('l, M j Y') }}
          </p>
        </div>

        <div class="ml-auto flex items-center gap-3">
          <!-- <button class="relative h-9 w-9 grid place-items-center rounded-lg border focus-ring" style="border-color:var(--line);">
            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 8a6 6 0 1 1 12 0c0 5 2 6 2 6H4s2-1 2-6"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
            <span class="absolute -top-0.5 -right-0.5 h-2.5 w-2.5 rounded-full" style="background:var(--pink); box-shadow:0 0 0 2px white;"></span>
          </button> -->

          @if($student->avatar ?? false)
            <img src="{{ asset('uploads/'.$student->avatar) }}" alt="{{ $student->full_name }}" class="h-9 w-9 rounded-full object-cover">
          @else
            <div class="h-9 w-9 rounded-full brand-gradient grid place-items-center text-white text-xs font-display font-700">
              {{ $initials }}
            </div>
          @endif
        </div>
      </div>
    </header>

    @yield('content')

  </div>
</div>

<script>
  // Mobile sidebar
  const sidebar = document.getElementById('sidebar');
  const scrim = document.getElementById('scrim');
  const menuBtn = document.getElementById('menuBtn');
  function openSidebar(){ sidebar.classList.remove('-translate-x-full'); scrim.classList.remove('hidden'); }
  function closeSidebar(){ sidebar.classList.add('-translate-x-full'); scrim.classList.add('hidden'); }
  menuBtn.addEventListener('click', openSidebar);
  scrim.addEventListener('click', closeSidebar);

  @stack('scripts')
</script>

</body>
</html>