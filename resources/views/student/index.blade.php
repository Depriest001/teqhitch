<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  @php
    $favicon = $globalSetting->favicon ?? null;
    $logo    = $globalSetting->site_logo ?? null;
  @endphp

  <title>Student Hub · {{ $globalSetting->site_name ?? 'Teqhitch' }}</title>
  <link rel="icon"
    href="{{ $favicon ? asset('uploads/'.$favicon) : asset('assets/img/favicon.jpg') }}">
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
    body{background:var(--canvas); color:var(--ink); font-family:'Inter',sans-serif;}
    .font-display{font-family:'Space Grotesk',sans-serif;}
    .font-mono{font-family:'JetBrains Mono',monospace;}
    .brand-gradient{background:linear-gradient(135deg,var(--blue) 0%, var(--cyan) 55%, var(--green) 100%);}
    .text-gradient{background:linear-gradient(135deg,var(--blue), var(--cyan) 60%, var(--green));-webkit-background-clip:text;background-clip:text;color:transparent;}
    ::-webkit-scrollbar{width:8px; height:8px;}
    ::-webkit-scrollbar-track{background:transparent;}
    ::-webkit-scrollbar-thumb{background:#CBD3E1; border-radius:8px;}
    .navy-scroll::-webkit-scrollbar-thumb{background:#2A3457;}

    /* Heatmap */
    .heat-cell{width:13px; height:13px; border-radius:3px; background:var(--surface-alt);}
    .heat-0{background:#EEF1F8;}
    .heat-1{background:#CDEBE0;}
    .heat-2{background:#8FDCC0;}
    .heat-3{background:#45CB9A;}
    .heat-4{background:#0FA36F;}
    .heat-cell:hover{outline:1.5px solid var(--ink); outline-offset:1px; cursor:pointer;}

    /* ring */
    .ring-progress{transform:rotate(-90deg); transform-origin:50% 50%;}

    .badge-soon{
      background:repeating-linear-gradient(135deg, transparent, transparent 6px, rgba(22,87,255,0.06) 6px, rgba(22,87,255,0.06) 12px);
    }
    .dash-border{
      border:1.5px dashed #B9C2D6;
    }
    [data-nav]{transition:background .15s ease, color .15s ease;}
    .track-chip{font-family:'JetBrains Mono',monospace; font-size:11px; letter-spacing:.02em;}

    @media (prefers-reduced-motion: reduce){
      *{animation:none !important; transition:none !important;}
    }

    .focus-ring:focus-visible{outline:2px solid var(--blue); outline-offset:2px;}
  </style>
</head>
<body class="antialiased">

<div class="flex min-h-screen">

  <!-- ============ SIDEBAR ============ -->
  <aside id="sidebar" class="fixed lg:sticky top-0 z-40 h-screen w-[264px] shrink-0 -translate-x-full lg:translate-x-0 transition-transform duration-200" style="background:var(--navy);">
    <div class="flex h-full flex-col navy-scroll overflow-y-auto">
      <!-- Logo -->
      <div class="flex items-center gap-3 px-6 pt-7 pb-6">
        <svg width="38" height="38" viewBox="0 0 100 100" class="shrink-0" aria-hidden="true">
          <defs>
            <linearGradient id="logoGrad" x1="10" y1="10" x2="90" y2="90" gradientUnits="userSpaceOnUse">
              <stop offset="0%" stop-color="#1657FF"/>
              <stop offset="55%" stop-color="#17B4D9"/>
              <stop offset="100%" stop-color="#2BD480"/>
            </linearGradient>
          </defs>
          <circle cx="50" cy="50" r="48" fill="url(#logoGrad)"/>
          <path d="M30 34 H70 V44 H55 V72 H45 V44 H30 Z" fill="#FFFFFF"/>
        </svg>
        <div>
          <p class="font-display font-700 text-white text-[17px] leading-none tracking-tight" style="font-weight:700;">Teqhitch</p>
          <p class="text-[11px] font-mono mt-1 tracking-wide" style="color:#7B87AC;">STUDENT HUB</p>
        </div>
      </div>

      <!-- Student card -->
      <div class="mx-4 mb-6 rounded-xl p-3.5 flex items-center gap-3" style="background:var(--navy-soft); border:1px solid var(--navy-line);">
        <div class="h-10 w-10 rounded-full brand-gradient grid place-items-center text-white font-display font-700 text-sm">CO</div>
        <div class="min-w-0">
          <p class="text-white text-sm font-semibold truncate">Chidera Okafor</p>
          <p class="text-[11px] truncate" style="color:#8892B0;">Full-Stack Web Dev · Batch 14</p>
        </div>
      </div>

      <!-- Nav -->
      <nav class="flex-1 px-3 space-y-0.5">
        <p class="px-3 pb-2 text-[10.5px] font-mono tracking-widest" style="color:#5C6890;">MAIN</p>
        <a data-nav href="#overview" class="nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium" style="background:rgba(22,87,255,0.16); color:#EAF0FF;">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
          Overview
        </a>
        <a data-nav href="#attendance" class="nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium" style="color:#9AA4C4;">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M3 9h18M8 3v3M16 3v3"/></svg>
          Attendance
        </a>
        <a data-nav href="#schedule" class="nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium" style="color:#9AA4C4;">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
          Onsite Classes
        </a>
        <a data-nav href="#courses" class="nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium" style="color:#9AA4C4;">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg>
          Courses
        </a>
        <a data-nav href="#performance" class="nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium" style="color:#9AA4C4;">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 20V10M12 20V4M20 20v-7"/></svg>
          Performance
        </a>
        <a data-nav href="#assessments" class="nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium" style="color:#9AA4C4;">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 12l2 2 4-4"/><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
          Assessments
        </a>
        <a data-nav href="#courses" class="nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium" style="color:#9AA4C4;">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg>
          Courses
        </a>

        <p class="px-3 pt-5 pb-2 text-[10.5px] font-mono tracking-widest" style="color:#5C6890;">MORE</p>
        <a data-nav href="#leaderboard" class="nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium" style="color:#9AA4C4;">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M8 21h8M12 17v4M6 4h12l-1 6a5 5 0 0 1-10 0L6 4Z"/><path d="M6 6H4a2 2 0 0 0 2 4M18 6h2a2 2 0 0 1-2 4"/></svg>
          Leaderboard
        </a>
        <a data-nav href="#online" class="nav-link flex items-center justify-between gap-3 rounded-lg px-3 py-2.5 text-sm font-medium" style="color:#9AA4C4;">
          <span class="flex items-center gap-3">
            <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="4" width="20" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            Online Classes
          </span>
          <span class="text-[9.5px] font-mono px-1.5 py-0.5 rounded" style="background:rgba(43,212,128,0.18); color:#4FE3A3;">SOON</span>
        </a>
      </nav>

      <!-- Bottom -->
      <div class="px-3 pb-5 pt-3 space-y-0.5" style="border-top:1px solid var(--navy-line);">
        <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium" style="color:#9AA4C4;">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1Z"/></svg>
          Settings
        </a>
        <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium" style="color:#9AA4C4;">
          <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
          Log out
        </a>
      </div>
    </div>
  </aside>
  <div id="scrim" class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden"></div>

  <!-- ============ MAIN ============ -->
  <div class="flex-1 min-w-0">

    <!-- Topbar -->
    <header class="sticky top-0 z-20 backdrop-blur bg-white/85 border-b" style="border-color:var(--line);">
      <div class="flex items-center gap-4 px-5 lg:px-8 h-[68px]">
        <button id="menuBtn" class="lg:hidden h-9 w-9 grid place-items-center rounded-lg border focus-ring" style="border-color:var(--line);">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>

        <div class="hidden md:block min-w-0">
          <h1 class="font-display font-700 text-[19px] leading-tight" style="font-weight:700;">Good afternoon, Chidera 👋</h1>
          <p class="text-[12.5px] text-mono" style="color:var(--ink-muted);">Friday, Aug 9 · Aba Campus · Room 204 next at 1:00 PM</p>
        </div>

        <div class="ml-auto flex items-center gap-3">
          <div class="hidden md:flex items-center gap-2 rounded-lg px-3 py-2 w-64" style="background:var(--surface-alt);">
            <svg class="h-4 w-4 shrink-0" style="color:var(--ink-muted);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" placeholder="Search classes, topics…" class="bg-transparent text-sm outline-none w-full placeholder:text-slate-400" />
          </div>
          <button class="relative h-9 w-9 grid place-items-center rounded-lg border focus-ring" style="border-color:var(--line);">
            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 8a6 6 0 1 1 12 0c0 5 2 6 2 6H4s2-1 2-6"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
            <span class="absolute -top-0.5 -right-0.5 h-2.5 w-2.5 rounded-full" style="background:var(--pink); box-shadow:0 0 0 2px white;"></span>
          </button>
          <div class="h-9 w-9 rounded-full brand-gradient grid place-items-center text-white text-xs font-display font-700">CO</div>
        </div>
      </div>
    </header>

    <main class="px-5 lg:px-8 py-7 max-w-[1240px] mx-auto space-y-8">

      <!-- ===== STAT CARDS ===== -->
      <section id="overview" class="grid grid-cols-2 lg:grid-cols-4 gap-4 scroll-mt-24">

        <!-- Attendance ring -->
        <div class="rounded-2xl bg-white p-5 border" style="border-color:var(--line);">
          <p class="text-[12px] font-medium" style="color:var(--ink-muted);">Onsite Attendance</p>
          <div class="flex items-center gap-4 mt-2">
            <svg width="64" height="64" viewBox="0 0 64 64">
              <circle cx="32" cy="32" r="27" fill="none" stroke="#EEF1F8" stroke-width="7"/>
              <circle class="ring-progress" cx="32" cy="32" r="27" fill="none" stroke="url(#ringGrad)" stroke-width="7" stroke-linecap="round" stroke-dasharray="169.6" stroke-dashoffset="13.5"/>
              <defs><linearGradient id="ringGrad" x1="0" y1="0" x2="64" y2="64"><stop offset="0%" stop-color="#1657FF"/><stop offset="100%" stop-color="#2BD480"/></linearGradient></defs>
            </svg>
            <div>
              <p class="font-mono font-600 text-2xl" style="font-weight:600;">92%</p>
              <p class="text-[11.5px]" style="color:var(--ink-muted);">this month</p>
            </div>
          </div>
        </div>

        <!-- Streak -->
        <div class="rounded-2xl bg-white p-5 border" style="border-color:var(--line);">
          <p class="text-[12px] font-medium" style="color:var(--ink-muted);">Check-in Streak</p>
          <p class="font-mono font-600 text-3xl mt-3" style="font-weight:600; color:var(--ink);">14<span class="text-base font-normal" style="color:var(--ink-muted);"> days</span></p>
          <p class="text-[11.5px] mt-1 flex items-center gap-1" style="color:#0FA36F;">
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 15l7-7 7 7"/></svg>
            Best streak this term
          </p>
        </div>

        <!-- Score -->
        <div class="rounded-2xl bg-white p-5 border" style="border-color:var(--line);">
          <p class="text-[12px] font-medium" style="color:var(--ink-muted);">Average Score</p>
          <p class="font-mono font-600 text-3xl mt-3" style="font-weight:600;">84<span class="text-base font-normal" style="color:var(--ink-muted);">/100</span></p>
          <p class="text-[11.5px] mt-1" style="color:var(--ink-muted);">Across 4 assessments</p>
        </div>

        <!-- Track progress -->
        <div class="rounded-2xl bg-white p-5 border" style="border-color:var(--line);">
          <p class="text-[12px] font-medium" style="color:var(--ink-muted);">Track Progress</p>
          <p class="font-mono font-600 text-3xl mt-3" style="font-weight:600;">68%</p>
          <div class="h-1.5 rounded-full mt-2.5" style="background:var(--surface-alt);">
            <div class="h-1.5 rounded-full brand-gradient" style="width:68%;"></div>
          </div>
          <p class="text-[11.5px] mt-1.5" style="color:var(--ink-muted);">Full-Stack Web Dev</p>
        </div>
      </section>

      <!-- ===== SIGNATURE: ATTENDANCE HEATMAP ===== -->
      <section id="attendance" class="rounded-2xl bg-white p-6 border scroll-mt-24" style="border-color:var(--line);">
        <div class="flex flex-wrap items-end justify-between gap-3 mb-5">
          <div>
            <h2 class="font-display font-700 text-lg" style="font-weight:700;">Onsite check-in history</h2>
            <p class="text-[13px] mt-0.5" style="color:var(--ink-muted);">Every square is one scheduled class day — darker means fuller participation.</p>
          </div>
          <div class="flex items-center gap-1.5 text-[11px] font-mono" style="color:var(--ink-muted);">
            Less
            <span class="heat-cell heat-0"></span>
            <span class="heat-cell heat-1"></span>
            <span class="heat-cell heat-2"></span>
            <span class="heat-cell heat-3"></span>
            <span class="heat-cell heat-4"></span>
            More
          </div>
        </div>

        <div class="overflow-x-auto">
          <div id="heatmap" class="inline-grid gap-[3px]" style="grid-template-rows:repeat(5,13px); grid-auto-flow:column;"></div>
        </div>
        <p id="heatSummary" class="text-[12.5px] mt-4 font-mono" style="color:var(--ink-muted);">Hover a square to see that class day.</p>
      </section>

      <!-- ===== SCHEDULE + PERFORMANCE (left) / SIDEBAR CARDS (right) ===== -->
      <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">

          <!-- Schedule -->
          <div id="schedule" class="rounded-2xl bg-white p-6 border scroll-mt-24" style="border-color:var(--line);">
            <div class="flex items-center justify-between mb-4">
              <h2 class="font-display font-700 text-lg" style="font-weight:700;">This week · Onsite classes</h2>
              <span class="text-[12px] font-mono" style="color:var(--ink-muted);">Aba Campus</span>
            </div>

            <div class="divide-y" style="border-color:var(--line);">
              <!-- Mon -->
              <div class="flex items-center gap-4 py-3.5">
                <div class="w-12 shrink-0 text-center">
                  <p class="text-[10.5px] font-mono" style="color:var(--ink-muted);">MON</p>
                  <p class="font-display font-700 text-sm">05</p>
                </div>
                <div class="min-w-0 flex-1">
                  <p class="text-sm font-semibold truncate">Advanced JavaScript &amp; DOM</p>
                  <p class="text-[12px] mt-0.5" style="color:var(--ink-muted);">Room 204 · 9:00–11:00 · Mr. Tobenna</p>
                </div>
                <span class="track-chip px-2 py-1 rounded-md" style="background:rgba(22,87,255,0.09); color:var(--blue);">WEBDEV</span>
                <span class="text-[11.5px] font-mono px-2.5 py-1.5 rounded-lg" style="background:rgba(43,212,128,0.12); color:#0FA36F;">Present</span>
              </div>
              <!-- Tue -->
              <div class="flex items-center gap-4 py-3.5">
                <div class="w-12 shrink-0 text-center">
                  <p class="text-[10.5px] font-mono" style="color:var(--ink-muted);">TUE</p>
                  <p class="font-display font-700 text-sm">06</p>
                </div>
                <div class="min-w-0 flex-1">
                  <p class="text-sm font-semibold truncate">Database Design (SQL)</p>
                  <p class="text-[12px] mt-0.5" style="color:var(--ink-muted);">Room 108 · 9:00–11:00 · Ms. Adaeze</p>
                </div>
                <span class="track-chip px-2 py-1 rounded-md" style="background:rgba(23,180,217,0.1); color:var(--cyan);">DATA</span>
                <span class="text-[11.5px] font-mono px-2.5 py-1.5 rounded-lg" style="background:rgba(43,212,128,0.12); color:#0FA36F;">Present</span>
              </div>
              <!-- Wed - Today -->
              <div class="flex items-center gap-4 py-3.5 -mx-3 px-3 rounded-xl" style="background:rgba(22,87,255,0.045);">
                <div class="w-12 shrink-0 text-center">
                  <p class="text-[10.5px] font-mono" style="color:var(--blue);">WED</p>
                  <p class="font-display font-700 text-sm" style="color:var(--blue);">07</p>
                </div>
                <div class="min-w-0 flex-1">
                  <p class="text-sm font-semibold truncate">React Fundamentals</p>
                  <p class="text-[12px] mt-0.5" style="color:var(--ink-muted);">Room 204 · 9:00–11:00 · Mr. Tobenna</p>
                </div>
                <span class="track-chip px-2 py-1 rounded-md" style="background:rgba(22,87,255,0.09); color:var(--blue);">WEBDEV</span>
                <button id="checkinBtn" class="text-[12px] font-semibold px-3 py-1.5 rounded-lg text-white brand-gradient focus-ring">Check in</button>
              </div>
              <!-- Thu -->
              <div class="flex items-center gap-4 py-3.5">
                <div class="w-12 shrink-0 text-center">
                  <p class="text-[10.5px] font-mono" style="color:var(--ink-muted);">THU</p>
                  <p class="font-display font-700 text-sm">08</p>
                </div>
                <div class="min-w-0 flex-1">
                  <p class="text-sm font-semibold truncate">Networking Basics (Elective)</p>
                  <p class="text-[12px] mt-0.5" style="color:var(--ink-muted);">Lab 3 · 1:00–3:00 · Mr. Kelechi</p>
                </div>
                <span class="track-chip px-2 py-1 rounded-md" style="background:rgba(124,92,250,0.1); color:var(--purple);">NET</span>
                <span class="text-[11.5px] font-mono px-2.5 py-1.5 rounded-lg" style="background:var(--surface-alt); color:var(--ink-muted);">Upcoming</span>
              </div>
              <!-- Fri -->
              <div class="flex items-center gap-4 py-3.5">
                <div class="w-12 shrink-0 text-center">
                  <p class="text-[10.5px] font-mono" style="color:var(--ink-muted);">FRI</p>
                  <p class="font-display font-700 text-sm">09</p>
                </div>
                <div class="min-w-0 flex-1">
                  <p class="text-sm font-semibold truncate">Project Clinic &amp; Code Review</p>
                  <p class="text-[12px] mt-0.5" style="color:var(--ink-muted);">Room 204 · 9:00–12:00 · Mr. Tobenna</p>
                </div>
                <span class="track-chip px-2 py-1 rounded-md" style="background:rgba(22,87,255,0.09); color:var(--blue);">WEBDEV</span>
                <span class="text-[11.5px] font-mono px-2.5 py-1.5 rounded-lg" style="background:var(--surface-alt); color:var(--ink-muted);">Upcoming</span>
              </div>
            </div>
          </div>

          <!-- Performance by track -->
          <div id="performance" class="rounded-2xl bg-white p-6 border scroll-mt-24" style="border-color:var(--line);">
            <h2 class="font-display font-700 text-lg mb-1" style="font-weight:700;">Performance by track</h2>
            <p class="text-[13px] mb-5" style="color:var(--ink-muted);">Score average across every graded activity this term.</p>

            <div class="space-y-4">
              <div>
                <div class="flex justify-between text-[13px] mb-1.5"><span class="font-medium">Web Development</span><span class="font-mono" style="color:var(--ink-muted);">88%</span></div>
                <div class="h-2 rounded-full" style="background:var(--surface-alt);"><div class="h-2 rounded-full" style="width:88%; background:var(--blue);"></div></div>
              </div>
              <div>
                <div class="flex justify-between text-[13px] mb-1.5"><span class="font-medium">Data Science</span><span class="font-mono" style="color:var(--ink-muted);">76%</span></div>
                <div class="h-2 rounded-full" style="background:var(--surface-alt);"><div class="h-2 rounded-full" style="width:76%; background:var(--green);"></div></div>
              </div>
              <div>
                <div class="flex justify-between text-[13px] mb-1.5"><span class="font-medium">Cybersecurity</span><span class="font-mono" style="color:var(--ink-muted);">71%</span></div>
                <div class="h-2 rounded-full" style="background:var(--surface-alt);"><div class="h-2 rounded-full" style="width:71%; background:var(--pink);"></div></div>
              </div>
              <div>
                <div class="flex justify-between text-[13px] mb-1.5"><span class="font-medium">Networking</span><span class="font-mono" style="color:var(--ink-muted);">64%</span></div>
                <div class="h-2 rounded-full" style="background:var(--surface-alt);"><div class="h-2 rounded-full" style="width:64%; background:var(--purple);"></div></div>
              </div>
              <div>
                <div class="flex justify-between text-[13px] mb-1.5"><span class="font-medium">IoT &amp; Robotics</span><span class="font-mono" style="color:var(--ink-muted);">58%</span></div>
                <div class="h-2 rounded-full" style="background:var(--surface-alt);"><div class="h-2 rounded-full" style="width:58%; background:var(--orange);"></div></div>
              </div>
            </div>
          </div>

          <!-- Assessments -->
          <div id="assessments" class="rounded-2xl bg-white p-6 border scroll-mt-24" style="border-color:var(--line);">
            <h2 class="font-display font-700 text-lg mb-4" style="font-weight:700;">Recent assessments</h2>
            <div class="overflow-x-auto -mx-1">
              <table class="w-full text-sm min-w-[560px]">
                <thead>
                  <tr class="text-left text-[11px] font-mono" style="color:var(--ink-muted);">
                    <th class="px-1 pb-2 font-medium">ASSESSMENT</th>
                    <th class="px-1 pb-2 font-medium">TRACK</th>
                    <th class="px-1 pb-2 font-medium">SCORE</th>
                    <th class="px-1 pb-2 font-medium">DATE</th>
                    <th class="px-1 pb-2 font-medium">FEEDBACK</th>
                  </tr>
                </thead>
                <tbody class="divide-y" style="border-color:var(--line);">
                  <tr>
                    <td class="px-1 py-3 font-medium">React State Management Quiz</td>
                    <td class="px-1 py-3"><span class="track-chip px-2 py-1 rounded-md" style="background:rgba(22,87,255,0.09); color:var(--blue);">WEBDEV</span></td>
                    <td class="px-1 py-3 font-mono">90/100</td>
                    <td class="px-1 py-3 font-mono" style="color:var(--ink-muted);">Aug 5</td>
                    <td class="px-1 py-3" style="color:var(--ink-muted);">Excellent grasp of hooks</td>
                  </tr>
                  <tr>
                    <td class="px-1 py-3 font-medium">SQL Joins Practical</td>
                    <td class="px-1 py-3"><span class="track-chip px-2 py-1 rounded-md" style="background:rgba(23,180,217,0.1); color:var(--cyan);">DATA</span></td>
                    <td class="px-1 py-3 font-mono">82/100</td>
                    <td class="px-1 py-3 font-mono" style="color:var(--ink-muted);">Aug 1</td>
                    <td class="px-1 py-3" style="color:var(--ink-muted);">Solid — review indexing</td>
                  </tr>
                  <tr>
                    <td class="px-1 py-3 font-medium">Network Topology Test</td>
                    <td class="px-1 py-3"><span class="track-chip px-2 py-1 rounded-md" style="background:rgba(124,92,250,0.1); color:var(--purple);">NET</span></td>
                    <td class="px-1 py-3 font-mono">74/100</td>
                    <td class="px-1 py-3 font-mono" style="color:var(--ink-muted);">Jul 28</td>
                    <td class="px-1 py-3" style="color:var(--ink-muted);">Needs more practice</td>
                  </tr>
                  <tr>
                    <td class="px-1 py-3 font-medium">Git &amp; Version Control Lab</td>
                    <td class="px-1 py-3"><span class="track-chip px-2 py-1 rounded-md" style="background:rgba(22,87,255,0.09); color:var(--blue);">WEBDEV</span></td>
                    <td class="px-1 py-3 font-mono">95/100</td>
                    <td class="px-1 py-3 font-mono" style="color:var(--ink-muted);">Jul 24</td>
                    <td class="px-1 py-3" style="color:var(--ink-muted);">Great workflow discipline</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div class="space-y-6">

          <!-- Online classes — future upgrade -->
          <div id="online" class="rounded-2xl p-6 badge-soon dash-border scroll-mt-24">
            <div class="flex items-start justify-between gap-2 mb-3">
              <div class="h-9 w-9 rounded-lg grid place-items-center" style="background:rgba(22,87,255,0.1);">
                <svg class="h-[18px] w-[18px]" style="color:var(--blue);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="4" width="20" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
              </div>
              <span class="text-[10px] font-mono px-2 py-1 rounded-full" style="background:var(--surface-alt); color:var(--ink-muted);">COMING SOON</span>
            </div>
            <h3 class="font-display font-700 text-[15px]" style="font-weight:700;">Online Classes</h3>
            <p class="text-[13px] mt-1.5 leading-relaxed" style="color:var(--ink-muted);">A hybrid mode is on the way — live-streamed sessions synced to your onsite curriculum, replays, and remote check-in, all tracked right here alongside your campus attendance.</p>
            <ul class="mt-4 space-y-2 text-[13px]">
              <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full shrink-0" style="background:var(--blue);"></span>Live-streamed sessions</li>
              <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full shrink-0" style="background:var(--cyan);"></span>Recorded replays &amp; notes</li>
              <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full shrink-0" style="background:var(--green);"></span>Remote attendance tracking</li>
            </ul>
            <label class="mt-5 flex items-center gap-2.5 text-[13px] font-medium cursor-pointer">
              <input id="notifyToggle" type="checkbox" class="h-4 w-4 rounded focus-ring" style="accent-color:var(--blue);">
              Notify me when this launches
            </label>
            <p id="notifyMsg" class="text-[12px] mt-2 hidden" style="color:#0FA36F;">You're on the list — we'll email you first.</p>
          </div>

          <!-- Leaderboard -->
          <div id="leaderboard" class="rounded-2xl bg-white p-6 border scroll-mt-24" style="border-color:var(--line);">
            <h2 class="font-display font-700 text-[15px] mb-4" style="font-weight:700;">Cohort leaderboard</h2>
            <ol class="space-y-3">
              <li class="flex items-center gap-3">
                <span class="font-mono text-[12px] w-4" style="color:var(--ink-muted);">1</span>
                <div class="h-8 w-8 rounded-full grid place-items-center text-white text-[11px] font-display font-700" style="background:var(--amber);">NA</div>
                <div class="flex-1 min-w-0"><p class="text-[13.5px] font-medium truncate">Ngozi A.</p></div>
                <span class="font-mono text-[13px]" style="color:var(--ink-muted);">94</span>
              </li>
              <li class="flex items-center gap-3">
                <span class="font-mono text-[12px] w-4" style="color:var(--ink-muted);">2</span>
                <div class="h-8 w-8 rounded-full grid place-items-center text-white text-[11px] font-display font-700" style="background:#9AA4C4;">EU</div>
                <div class="flex-1 min-w-0"><p class="text-[13.5px] font-medium truncate">Emeka U.</p></div>
                <span class="font-mono text-[13px]" style="color:var(--ink-muted);">91</span>
              </li>
              <li class="flex items-center gap-3 rounded-lg -mx-2 px-2 py-1.5" style="background:rgba(22,87,255,0.06);">
                <span class="font-mono text-[12px] w-4" style="color:var(--blue);">3</span>
                <div class="h-8 w-8 rounded-full brand-gradient grid place-items-center text-white text-[11px] font-display font-700">CO</div>
                <div class="flex-1 min-w-0"><p class="text-[13.5px] font-semibold truncate" style="color:var(--blue);">You</p></div>
                <span class="font-mono text-[13px] font-semibold" style="color:var(--blue);">84</span>
              </li>
              <li class="flex items-center gap-3">
                <span class="font-mono text-[12px] w-4" style="color:var(--ink-muted);">4</span>
                <div class="h-8 w-8 rounded-full grid place-items-center text-white text-[11px] font-display font-700" style="background:var(--purple);">IK</div>
                <div class="flex-1 min-w-0"><p class="text-[13.5px] font-medium truncate">Ifeoma K.</p></div>
                <span class="font-mono text-[13px]" style="color:var(--ink-muted);">81</span>
              </li>
              <li class="flex items-center gap-3">
                <span class="font-mono text-[12px] w-4" style="color:var(--ink-muted);">5</span>
                <div class="h-8 w-8 rounded-full grid place-items-center text-white text-[11px] font-display font-700" style="background:var(--pink);">TB</div>
                <div class="flex-1 min-w-0"><p class="text-[13.5px] font-medium truncate">Tunde B.</p></div>
                <span class="font-mono text-[13px]" style="color:var(--ink-muted);">79</span>
              </li>
            </ol>
          </div>

          <!-- Instructor notes -->
          <div class="rounded-2xl bg-white p-6 border" style="border-color:var(--line);">
            <h2 class="font-display font-700 text-[15px] mb-4" style="font-weight:700;">Instructor notes</h2>
            <div class="space-y-4">
              <div class="flex gap-3">
                <div class="h-7 w-7 rounded-full shrink-0 grid place-items-center text-white text-[10px] font-display font-700" style="background:var(--blue);">MT</div>
                <div>
                  <p class="text-[13px]"><span class="font-semibold">Mr. Tobenna</span> <span style="color:var(--ink-muted);">· 2 days ago</span></p>
                  <p class="text-[13px] mt-0.5" style="color:var(--ink-muted);">Great improvement in async JS this week — keep practicing error handling.</p>
                </div>
              </div>
              <div class="flex gap-3">
                <div class="h-7 w-7 rounded-full shrink-0 grid place-items-center text-white text-[10px] font-display font-700" style="background:var(--cyan);">MA</div>
                <div>
                  <p class="text-[13px]"><span class="font-semibold">Ms. Adaeze</span> <span style="color:var(--ink-muted);">· 4 days ago</span></p>
                  <p class="text-[13px] mt-0.5" style="color:var(--ink-muted);">Please review normalization before Friday's practical.</p>
                </div>
              </div>
            </div>
          </div>

        </div>
      </section>

      <!-- ===== OTHER COURSES ===== -->
      <section id="courses" class="scroll-mt-24">
        <div class="flex flex-wrap items-end justify-between gap-3 mb-5">
          <div>
            <h2 class="font-display font-700 text-lg" style="font-weight:700;">Explore other courses</h2>
            <p class="text-[13px] mt-0.5" style="color:var(--ink-muted);">Add a track, switch specialization, or just see what else Teqhitch teaches.</p>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">

          <!-- Web Development — enrolled -->
          <article class="rounded-2xl bg-white p-5 border flex flex-col" style="border-color:var(--line);">
            <div class="flex items-start justify-between">
              <div class="h-10 w-10 rounded-lg grid place-items-center" style="background:rgba(22,87,255,0.1);">
                <svg class="h-5 w-5" style="color:var(--blue);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m8 8-4 4 4 4M16 8l4 4-4 4M13 5l-2 14"/></svg>
              </div>
              <span class="text-[10px] font-mono px-2 py-1 rounded-full" style="background:rgba(43,212,128,0.14); color:#0FA36F;">ENROLLED</span>
            </div>
            <h3 class="font-display font-700 text-[15px] mt-3.5" style="font-weight:700;">Full-Stack Web Development</h3>
            <p class="text-[13px] mt-1.5 leading-relaxed flex-1" style="color:var(--ink-muted);">Build modern, responsive web apps — from semantic HTML to React and backend fundamentals.</p>
            <div class="flex items-center gap-2 mt-4 text-[11px] font-mono" style="color:var(--ink-muted);">
              <span class="px-2 py-1 rounded-md" style="background:var(--surface-alt);">12 weeks</span>
              <span class="px-2 py-1 rounded-md" style="background:var(--surface-alt);">Intermediate</span>
            </div>
            <button class="mt-4 w-full text-[13px] font-semibold py-2.5 rounded-lg text-white brand-gradient focus-ring">Continue track</button>
          </article>

          <!-- Cybersecurity -->
          <article class="rounded-2xl bg-white p-5 border flex flex-col" style="border-color:var(--line);">
            <div class="h-10 w-10 rounded-lg grid place-items-center" style="background:rgba(244,63,126,0.1);">
              <svg class="h-5 w-5" style="color:var(--pink);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2 4 5v6c0 5 3.4 8.9 8 11 4.6-2.1 8-6 8-11V5l-8-3Z"/><path d="m9.5 12 1.8 1.8L15 10"/></svg>
            </div>
            <h3 class="font-display font-700 text-[15px] mt-3.5" style="font-weight:700;">Cybersecurity Fundamentals</h3>
            <p class="text-[13px] mt-1.5 leading-relaxed flex-1" style="color:var(--ink-muted);">Learn to secure systems, spot threats early, and protect sensitive data end to end.</p>
            <div class="flex items-center gap-2 mt-4 text-[11px] font-mono" style="color:var(--ink-muted);">
              <span class="px-2 py-1 rounded-md" style="background:var(--surface-alt);">10 weeks</span>
              <span class="px-2 py-1 rounded-md" style="background:var(--surface-alt);">Beginner</span>
            </div>
            <button class="mt-4 w-full text-[13px] font-semibold py-2.5 rounded-lg border focus-ring hover:bg-slate-50" style="border-color:var(--line); color:var(--ink);">Explore track</button>
          </article>

          <!-- Networking -->
          <article class="rounded-2xl bg-white p-5 border flex flex-col" style="border-color:var(--line);">
            <div class="h-10 w-10 rounded-lg grid place-items-center" style="background:rgba(124,92,250,0.1);">
              <svg class="h-5 w-5" style="color:var(--purple);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="5" cy="6" r="2"/><circle cx="19" cy="6" r="2"/><circle cx="12" cy="18" r="2"/><path d="M5 8v3a2 2 0 0 0 2 2h3M19 8v3a2 2 0 0 1-2 2h-3M12 13v3"/></svg>
            </div>
            <h3 class="font-display font-700 text-[15px] mt-3.5" style="font-weight:700;">Networking &amp; Infrastructure</h3>
            <p class="text-[13px] mt-1.5 leading-relaxed flex-1" style="color:var(--ink-muted);">Design, deploy and manage robust network architecture across platforms and environments.</p>
            <div class="flex items-center gap-2 mt-4 text-[11px] font-mono" style="color:var(--ink-muted);">
              <span class="px-2 py-1 rounded-md" style="background:var(--surface-alt);">8 weeks</span>
              <span class="px-2 py-1 rounded-md" style="background:var(--surface-alt);">Intermediate</span>
            </div>
            <button class="mt-4 w-full text-[13px] font-semibold py-2.5 rounded-lg border focus-ring hover:bg-slate-50" style="border-color:var(--line); color:var(--ink);">Explore track</button>
          </article>

          <!-- Data Science -->
          <article class="rounded-2xl bg-white p-5 border flex flex-col" style="border-color:var(--line);">
            <div class="h-10 w-10 rounded-lg grid place-items-center" style="background:rgba(23,180,217,0.1);">
              <svg class="h-5 w-5" style="color:var(--cyan);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 20V10M12 20V4M20 20v-7"/></svg>
            </div>
            <h3 class="font-display font-700 text-[15px] mt-3.5" style="font-weight:700;">Data Science &amp; Analytics</h3>
            <p class="text-[13px] mt-1.5 leading-relaxed flex-1" style="color:var(--ink-muted);">Turn raw data into real insight using statistics, Python and visualization tooling.</p>
            <div class="flex items-center gap-2 mt-4 text-[11px] font-mono" style="color:var(--ink-muted);">
              <span class="px-2 py-1 rounded-md" style="background:var(--surface-alt);">14 weeks</span>
              <span class="px-2 py-1 rounded-md" style="background:var(--surface-alt);">Intermediate</span>
            </div>
            <button class="mt-4 w-full text-[13px] font-semibold py-2.5 rounded-lg border focus-ring hover:bg-slate-50" style="border-color:var(--line); color:var(--ink);">Explore track</button>
          </article>

          <!-- IoT -->
          <article class="rounded-2xl bg-white p-5 border flex flex-col" style="border-color:var(--line);">
            <div class="h-10 w-10 rounded-lg grid place-items-center" style="background:rgba(255,122,69,0.12);">
              <svg class="h-5 w-5" style="color:var(--orange);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="2.5"/><path d="M7.5 7.5a6.5 6.5 0 0 0 0 9M16.5 7.5a6.5 6.5 0 0 1 0 9M4.5 4.5a11 11 0 0 0 0 15M19.5 4.5a11 11 0 0 1 0 15"/></svg>
            </div>
            <h3 class="font-display font-700 text-[15px] mt-3.5" style="font-weight:700;">IoT Systems</h3>
            <p class="text-[13px] mt-1.5 leading-relaxed flex-1" style="color:var(--ink-muted);">Connect devices and sensors to build smart, data-driven products from the ground up.</p>
            <div class="flex items-center gap-2 mt-4 text-[11px] font-mono" style="color:var(--ink-muted);">
              <span class="px-2 py-1 rounded-md" style="background:var(--surface-alt);">10 weeks</span>
              <span class="px-2 py-1 rounded-md" style="background:var(--surface-alt);">Advanced</span>
            </div>
            <button class="mt-4 w-full text-[13px] font-semibold py-2.5 rounded-lg border focus-ring hover:bg-slate-50" style="border-color:var(--line); color:var(--ink);">Explore track</button>
          </article>

          <!-- Robotics -->
          <article class="rounded-2xl bg-white p-5 border flex flex-col" style="border-color:var(--line);">
            <div class="h-10 w-10 rounded-lg grid place-items-center" style="background:rgba(43,212,128,0.12);">
              <svg class="h-5 w-5" style="color:var(--green);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="5" y="9" width="14" height="10" rx="2"/><path d="M12 9V5M9 5h6M9 14h.01M15 14h.01"/></svg>
            </div>
            <h3 class="font-display font-700 text-[15px] mt-3.5" style="font-weight:700;">Robotics Engineering</h3>
            <p class="text-[13px] mt-1.5 leading-relaxed flex-1" style="color:var(--ink-muted);">Design and program robots — from circuitry and sensors to real-world control logic.</p>
            <div class="flex items-center gap-2 mt-4 text-[11px] font-mono" style="color:var(--ink-muted);">
              <span class="px-2 py-1 rounded-md" style="background:var(--surface-alt);">12 weeks</span>
              <span class="px-2 py-1 rounded-md" style="background:var(--surface-alt);">Advanced</span>
            </div>
            <button class="mt-4 w-full text-[13px] font-semibold py-2.5 rounded-lg border focus-ring hover:bg-slate-50" style="border-color:var(--line); color:var(--ink);">Explore track</button>
          </article>

        </div>
      </section>

      <!-- ===== EXPLORE COURSES ===== -->
      <section id="courses" class="scroll-mt-24">
        <div class="flex flex-wrap items-end justify-between gap-3 mb-5">
          <div>
            <h2 class="font-display font-700 text-lg" style="font-weight:700;">Explore other courses</h2>
            <p class="text-[13px] mt-0.5" style="color:var(--ink-muted);">Add a track alongside Web Development, or plan what's next after this cohort.</p>
          </div>
          <span class="text-[11px] font-mono px-2.5 py-1 rounded-full" style="background:var(--surface-alt); color:var(--ink-muted);">All tracks · Aba Campus · Onsite</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">

          <!-- Web Dev - enrolled -->
          <article class="rounded-2xl bg-white p-5 border flex flex-col" style="border-color:var(--line);">
            <div class="flex items-start justify-between">
              <div class="h-11 w-11 rounded-xl grid place-items-center" style="background:rgba(22,87,255,0.1);">
                <svg class="h-5 w-5" style="color:var(--blue);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
              </div>
              <span class="track-chip px-2 py-1 rounded-md" style="background:rgba(22,87,255,0.09); color:var(--blue);">WEBDEV</span>
            </div>
            <h3 class="font-display font-700 text-[15px] mt-3.5" style="font-weight:700;">Full-Stack Web Development</h3>
            <p class="text-[13px] mt-1.5 leading-relaxed flex-1" style="color:var(--ink-muted);">HTML, CSS, JavaScript, React and backend APIs — build and ship real, deployable products.</p>
            <div class="flex items-center gap-3 text-[12px] mt-4" style="color:var(--ink-muted);">
              <span class="flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>16 weeks</span>
              <span class="flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20V10M18 20V4M6 20v-4"/></svg>Beginner–Advanced</span>
            </div>
            <div class="flex items-center justify-between mt-4 pt-4" style="border-top:1px solid var(--line);">
              <span class="font-mono text-[13.5px] font-semibold">₦180,000</span>
              <span class="text-[12px] font-semibold px-3 py-1.5 rounded-lg flex items-center gap-1.5" style="background:rgba(43,212,128,0.12); color:#0FA36F;">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6 9 17l-5-5"/></svg>
                Enrolled
              </span>
            </div>
          </article>

          <!-- Cybersecurity -->
          <article class="rounded-2xl bg-white p-5 border flex flex-col" style="border-color:var(--line);">
            <div class="flex items-start justify-between">
              <div class="h-11 w-11 rounded-xl grid place-items-center" style="background:rgba(244,63,126,0.1);">
                <svg class="h-5 w-5" style="color:var(--pink);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2 4 5v6c0 5 3.4 8.7 8 11 4.6-2.3 8-6 8-11V5l-8-3Z"/></svg>
              </div>
              <span class="track-chip px-2 py-1 rounded-md" style="background:rgba(244,63,126,0.1); color:var(--pink);">CYBER</span>
            </div>
            <h3 class="font-display font-700 text-[15px] mt-3.5" style="font-weight:700;">Cybersecurity Fundamentals</h3>
            <p class="text-[13px] mt-1.5 leading-relaxed flex-1" style="color:var(--ink-muted);">Threat detection, ethical hacking basics and how to secure real infrastructure and data.</p>
            <div class="flex items-center gap-3 text-[12px] mt-4" style="color:var(--ink-muted);">
              <span class="flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>12 weeks</span>
              <span class="flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20V10M18 20V4M6 20v-4"/></svg>Intermediate</span>
            </div>
            <div class="flex items-center justify-between mt-4 pt-4" style="border-top:1px solid var(--line);">
              <span class="font-mono text-[13.5px] font-semibold">₦150,000</span>
              <button data-enroll class="text-[12px] font-semibold px-3.5 py-1.5 rounded-lg text-white brand-gradient focus-ring">Enroll</button>
            </div>
          </article>

          <!-- Networking -->
          <article class="rounded-2xl bg-white p-5 border flex flex-col" style="border-color:var(--line);">
            <div class="flex items-start justify-between">
              <div class="h-11 w-11 rounded-xl grid place-items-center" style="background:rgba(124,92,250,0.1);">
                <svg class="h-5 w-5" style="color:var(--purple);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="5" cy="6" r="2"/><circle cx="19" cy="6" r="2"/><circle cx="12" cy="18" r="2"/><path d="M5 8v3a2 2 0 0 0 2 2h3M19 8v3a2 2 0 0 1-2 2h-3M12 13v3"/></svg>
              </div>
              <span class="track-chip px-2 py-1 rounded-md" style="background:rgba(124,92,250,0.1); color:var(--purple);">NET</span>
            </div>
            <h3 class="font-display font-700 text-[15px] mt-3.5" style="font-weight:700;">Networking &amp; Infrastructure</h3>
            <p class="text-[13px] mt-1.5 leading-relaxed flex-1" style="color:var(--ink-muted);">Design, configure and troubleshoot the networks that keep organizations connected.</p>
            <div class="flex items-center gap-3 text-[12px] mt-4" style="color:var(--ink-muted);">
              <span class="flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>10 weeks</span>
              <span class="flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20V10M18 20V4M6 20v-4"/></svg>Beginner–Intermediate</span>
            </div>
            <div class="flex items-center justify-between mt-4 pt-4" style="border-top:1px solid var(--line);">
              <span class="font-mono text-[13.5px] font-semibold">₦130,000</span>
              <button data-enroll class="text-[12px] font-semibold px-3.5 py-1.5 rounded-lg text-white brand-gradient focus-ring">Enroll</button>
            </div>
          </article>

          <!-- Data Science -->
          <article class="rounded-2xl bg-white p-5 border flex flex-col" style="border-color:var(--line);">
            <div class="flex items-start justify-between">
              <div class="h-11 w-11 rounded-xl grid place-items-center" style="background:rgba(23,180,217,0.1);">
                <svg class="h-5 w-5" style="color:var(--cyan);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19h16M7 19V9M12 19V5M17 19v-7"/></svg>
              </div>
              <span class="track-chip px-2 py-1 rounded-md" style="background:rgba(23,180,217,0.1); color:var(--cyan);">DATA</span>
            </div>
            <h3 class="font-display font-700 text-[15px] mt-3.5" style="font-weight:700;">Data Science &amp; Analytics</h3>
            <p class="text-[13px] mt-1.5 leading-relaxed flex-1" style="color:var(--ink-muted);">Python, SQL and statistics — turn raw data into decisions organizations can act on.</p>
            <div class="flex items-center gap-3 text-[12px] mt-4" style="color:var(--ink-muted);">
              <span class="flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>14 weeks</span>
              <span class="flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20V10M18 20V4M6 20v-4"/></svg>Intermediate</span>
            </div>
            <div class="flex items-center justify-between mt-4 pt-4" style="border-top:1px solid var(--line);">
              <span class="font-mono text-[13.5px] font-semibold">₦170,000</span>
              <button data-enroll class="text-[12px] font-semibold px-3.5 py-1.5 rounded-lg text-white brand-gradient focus-ring">Enroll</button>
            </div>
          </article>

          <!-- IoT -->
          <article class="rounded-2xl bg-white p-5 border flex flex-col" style="border-color:var(--line);">
            <div class="flex items-start justify-between">
              <div class="h-11 w-11 rounded-xl grid place-items-center" style="background:rgba(255,122,69,0.12);">
                <svg class="h-5 w-5" style="color:var(--orange);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="2.5"/><path d="M12 5V2M12 22v-3M5 12H2M22 12h-3M6.3 6.3 4.5 4.5M17.7 6.3l1.8-1.8M6.3 17.7l-1.8 1.8M17.7 17.7l1.8 1.8"/></svg>
              </div>
              <span class="track-chip px-2 py-1 rounded-md" style="background:rgba(255,122,69,0.12); color:var(--orange);">IOT</span>
            </div>
            <h3 class="font-display font-700 text-[15px] mt-3.5" style="font-weight:700;">IoT &amp; Embedded Systems</h3>
            <p class="text-[13px] mt-1.5 leading-relaxed flex-1" style="color:var(--ink-muted);">Arduino, Raspberry Pi and sensors — build connected devices from circuit to cloud.</p>
            <div class="flex items-center gap-3 text-[12px] mt-4" style="color:var(--ink-muted);">
              <span class="flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>12 weeks</span>
              <span class="flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20V10M18 20V4M6 20v-4"/></svg>Beginner–Intermediate</span>
            </div>
            <div class="flex items-center justify-between mt-4 pt-4" style="border-top:1px solid var(--line);">
              <span class="font-mono text-[13.5px] font-semibold">₦160,000</span>
              <button data-enroll class="text-[12px] font-semibold px-3.5 py-1.5 rounded-lg text-white brand-gradient focus-ring">Enroll</button>
            </div>
          </article>

          <!-- Robotics -->
          <article class="rounded-2xl bg-white p-5 border flex flex-col" style="border-color:var(--line);">
            <div class="flex items-start justify-between">
              <div class="h-11 w-11 rounded-xl grid place-items-center" style="background:rgba(255,176,32,0.14);">
                <svg class="h-5 w-5" style="color:var(--amber);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="5" y="9" width="14" height="10" rx="2"/><path d="M9 9V6a3 3 0 0 1 6 0v3M9 14h.01M15 14h.01"/></svg>
              </div>
              <span class="track-chip px-2 py-1 rounded-md" style="background:rgba(255,176,32,0.14); color:#B87700;">ROBOTICS</span>
            </div>
            <h3 class="font-display font-700 text-[15px] mt-3.5" style="font-weight:700;">Robotics &amp; Automation</h3>
            <p class="text-[13px] mt-1.5 leading-relaxed flex-1" style="color:var(--ink-muted);">Design and program robots, from motor control to real automation projects.</p>
            <div class="flex items-center gap-3 text-[12px] mt-4" style="color:var(--ink-muted);">
              <span class="flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>10 weeks</span>
              <span class="flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20V10M18 20V4M6 20v-4"/></svg>Intermediate</span>
            </div>
            <div class="flex items-center justify-between mt-4 pt-4" style="border-top:1px solid var(--line);">
              <span class="font-mono text-[13.5px] font-semibold">₦165,000</span>
              <button data-enroll class="text-[12px] font-semibold px-3.5 py-1.5 rounded-lg text-white brand-gradient focus-ring">Enroll</button>
            </div>
          </article>

        </div>
      </section>

      <footer class="text-center text-[12px] pb-4 pt-2" style="color:var(--ink-muted);">
        Teqhitch ICT Academy · Student Hub
      </footer>

    </main>
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

  // Nav active state
  document.querySelectorAll('[data-nav]').forEach(link=>{
    link.addEventListener('click', (e)=>{
      document.querySelectorAll('[data-nav]').forEach(l=>{
        l.style.background='transparent'; l.style.color='#9AA4C4';
      });
      link.style.background='rgba(22,87,255,0.16)'; link.style.color='#EAF0FF';
      if(window.innerWidth < 1024) closeSidebar();
    });
  });

  // Check-in button
  const checkinBtn = document.getElementById('checkinBtn');
  checkinBtn.addEventListener('click', ()=>{
    checkinBtn.outerHTML = '<span class="text-[11.5px] font-mono px-2.5 py-1.5 rounded-lg" style="background:rgba(43,212,128,0.12); color:#0FA36F;">Checked in ✓</span>';
  });

  // Course enroll buttons
  document.querySelectorAll('[data-enroll]').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      btn.outerHTML = '<span class="text-[12px] font-semibold px-3 py-1.5 rounded-lg flex items-center gap-1.5" style="background:rgba(43,212,128,0.12); color:#0FA36F;"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6 9 17l-5-5"/></svg>Enrolled</span>';
    });
  });

  // Notify toggle
  const notifyToggle = document.getElementById('notifyToggle');
  const notifyMsg = document.getElementById('notifyMsg');
  notifyToggle.addEventListener('change', ()=>{
    notifyMsg.classList.toggle('hidden', !notifyToggle.checked);
  });

  // Heatmap — 18 weeks x 5 weekdays, seeded pseudo-random attendance intensity
  const heatmap = document.getElementById('heatmap');
  const heatSummary = document.getElementById('heatSummary');
  const weeks = 18, days = 5;
  const dayNames = ['Mon','Tue','Wed','Thu','Fri'];
  let seed = 42;
  function rand(){ seed = (seed*9301+49297)%233280; return seed/233280; }

  const today = new Date(2026, 7, 9); // Aug 9 2026, a Sunday reference point
  for(let w=0; w<weeks; w++){
    for(let d=0; d<days; d++){
      const cell = document.createElement('div');
      const r = rand();
      let level;
      if (w > weeks-2) level = -1; // future, blank
      else if (r < 0.06) level = 0;
      else if (r < 0.18) level = 1;
      else if (r < 0.42) level = 2;
      else if (r < 0.72) level = 3;
      else level = 4;

      cell.className = 'heat-cell ' + (level === -1 ? '' : 'heat-'+level);
      if(level === -1){ cell.style.background = 'transparent'; }

      const weeksAgo = weeks - w;
      const dateGuess = new Date(today);
      dateGuess.setDate(today.getDate() - (weeksAgo*7) + d - 2);
      const dateStr = dateGuess.toLocaleDateString('en-US', {month:'short', day:'numeric'});

      if(level >= 0){
        cell.addEventListener('mouseenter', ()=>{
          const labels = ['Absent','Late arrival','Checked in','Active participation','Full marks + participation'];
          heatSummary.textContent = `${dayNames[d]}, ${dateStr} — ${labels[level]}`;
        });
      }
      heatmap.appendChild(cell);
    }
  }
</script>

</body>
</html>