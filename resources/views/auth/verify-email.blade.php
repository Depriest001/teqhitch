<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Email Verification | {{ $globalSetting->site_name ?? 'Teqhitch' }}</title>
    @php
      $favicon = $globalSetting->favicon ?? null;
      $logo    = $globalSetting->site_logo ?? null;
    @endphp

    <link rel="icon"
      href="{{ $favicon ? asset('uploads/'.$favicon) : asset('assets/img/favicon.jpg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap"
      rel="stylesheet" />

    <!-- Tailwind (browser build) -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>

    <style>
      :root{
        --blue:#1657FF;
        --cyan:#17B4D9;
        --green:#2BD480;
        --amber:#FFB020;
        --purple:#7C5CFA;
        --pink:#F43F7E;
        --orange:#FF7A45;
      }
      body { font-family: 'Inter', sans-serif; }
      .font-display { font-family: 'Space Grotesk', sans-serif; }
      .font-mono-tq { font-family: 'JetBrains Mono', monospace; }

      .brand-gradient{background:linear-gradient(135deg,var(--blue) 0%, var(--cyan) 55%, var(--green) 100%);}
      ::-webkit-scrollbar{width:8px;}
      ::-webkit-scrollbar-thumb{background:#CBD3E1; border-radius:8px;}

      /* Signature: spiral signal ring, echoing the Teqhitch mark's banded gradient */
      .signal-ring {
        background: conic-gradient(from 200deg, #1E3A8A, #2E7BE0, #17B6C4, #4ADE80, #17B6C4, #2E7BE0, #1E3A8A);
        animation: spin-slow 9s linear infinite;
      }
      @keyframes spin-slow { to { transform: rotate(360deg); } }

      .cursor-blink { animation: blink 1.1s steps(1) infinite; }
      @keyframes blink { 50% { opacity: 0; } }

      @media (prefers-reduced-motion: reduce) {
        .signal-ring { animation: none; }
        .cursor-blink { animation: none; }
      }
    </style>
  </head>

  <body class="min-h-screen bg-slate-50 text-slate-900">

    <!-- Toast (session feedback) -->
    @if (session('success') || session('error') || $errors->any())
    <div id="appToast"
      class="fixed top-4 right-4 z-50 w-[min(360px,90vw)] rounded-xl border shadow-lg overflow-hidden
      {{ session('success') ? 'bg-emerald-50 border-emerald-200' : (session('error') ? 'bg-rose-50 border-rose-200' : 'bg-amber-50 border-amber-200') }}">
      <div class="flex items-start gap-3 px-4 py-3">
        <span class="mt-0.5 inline-flex h-6 w-6 flex-none items-center justify-center rounded-full
          {{ session('success') ? 'bg-emerald-500' : (session('error') ? 'bg-rose-500' : 'bg-amber-500') }} text-white text-xs">
          {{ session('success') ? '✓' : (session('error') ? '!' : '·') }}
        </span>
        <div class="flex-1 text-sm leading-snug">
          <p class="font-display font-semibold
            {{ session('success') ? 'text-emerald-900' : (session('error') ? 'text-rose-900' : 'text-amber-900') }}">
            @if (session('success')) Success
            @elseif (session('error')) Error
            @else Check your details
            @endif
          </p>
          <div class="mt-0.5 text-slate-600">
            @if (session('success'))
              {{ session('success') }}
            @elseif (session('error'))
              {{ session('error') }}
            @elseif ($errors->any())
              <ul class="space-y-0.5">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            @endif
          </div>
        </div>
        <button type="button" onclick="document.getElementById('appToast').remove()"
          class="flex-none text-slate-400 hover:text-slate-600 text-lg leading-none">&times;</button>
      </div>
    </div>
    <script>
      setTimeout(() => { const t = document.getElementById('appToast'); if (t) t.remove(); }, 6000);
    </script>
    @endif

    <div class="min-h-screen flex flex-col lg:flex-row">

      <!-- Brand panel -->
      <div class="relative overflow-hidden bg-[#0B1220] text-white lg:w-[42%] flex flex-col justify-between px-8 py-10 lg:px-12 lg:py-14">
        <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full opacity-30 blur-3xl"
             style="background: conic-gradient(from 180deg, var(--cyan));"></div>
        <div class="pointer-events-none absolute -left-24 -bottom-24 h-72 w-72 rounded-full opacity-30 blur-3xl"
             style="background: conic-gradient(from 180deg, var(--green));"></div>


        <a href="{{ route('home') }}" class="relative flex items-center gap-3">
          <img src="{{ $logo ? asset('uploads/'.$logo) : asset('assets/img/logo.png') }}" alt="{{ $globalSetting->site_name ?? 'Teqhitch' }} logo" class="h-10 w-10 rounded-full">
          <span class="font-display text-lg font-semibold tracking-tight">{{ $globalSetting->site_name ?? 'Teqhitch' }}</span>
        </a>

        <div class="relative mt-16 lg:mt-0">
          <p class="font-mono-tq text-xs uppercase tracking-[0.2em] text-cyan-300/80">Account Verification</p>
          <h1 class="font-display mt-3 text-3xl lg:text-[2.35rem] font-semibold leading-tight">
            One link stands between you and your dashboard.
          </h1>
          <p class="mt-4 text-sm leading-relaxed text-slate-300 max-w-sm">
            Verified accounts get full access to every feature, faster.
            It only takes a moment.
          </p>
        </div>

        <p class="relative hidden lg:block text-xs text-slate-500 font-mono-tq">
          © {{ date('Y') }} {{ $globalSetting->site_name ?? 'Teqhitch' }}
        </p>
      </div>

      <!-- Verification card -->
      <div class="flex-1 flex items-center justify-center px-6 py-14 lg:py-10">
        <div class="w-full max-w-md">

          <div class="rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-200/60 px-7 py-9 sm:px-9">

            <!-- Signature: spiral signal ring around the envelope -->
            <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full signal-ring p-[3px]">
              <div class="flex h-full w-full items-center justify-center rounded-full bg-white">
                <svg class="h-8 w-8 text-[#1E3A8A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
              </div>
            </div>

            <h2 class="font-display text-center text-xl font-semibold text-slate-900">Confirm your email</h2>
            <p class="mt-2 text-center text-sm leading-relaxed text-slate-500">
              We sent a confirmation link to your inbox. Open it to activate your account
              and get started.
            </p>

            <!-- Status console -->
            <div class="mt-5 rounded-lg bg-slate-900 px-4 py-2.5 font-mono-tq text-[13px] text-emerald-300">
              status: awaiting confirmation<span class="cursor-blink">▍</span>
            </div>

            @if (session('message'))
            <div class="mt-4 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-center text-sm text-emerald-800">
              {{ session('message') }}
            </div>
            @endif

            <!-- Resend Verification -->
            <form method="POST" action="{{ route('verification.send') }}" class="mt-6">
              @csrf
              <button type="submit"
                class="w-full rounded-lg bg-[#1E3A8A] px-4 py-2.5 text-sm font-medium text-white
                       brand-gradient">
                Resend confirmation email
              </button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
              @csrf
              <button type="submit"
                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm
                       font-medium text-slate-600 transition hover:bg-slate-50 focus:outline-none
                       focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#17B6C4]">
                Log out
              </button>
            </form>
          </div>

          <p class="mt-6 text-center text-xs text-slate-400">
            Didn't get an email? Check spam, or resend above.
          </p>
        </div>
      </div>
    </div>
  </body>
</html>