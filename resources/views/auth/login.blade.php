@extends('layouts.auth')
@section('title', 'Sign in')

@section('content')
<div>
  <h1 class="font-display font-700 text-[26px]" style="font-weight:700;">Welcome back</h1>
  <p class="text-[13.5px] mt-1.5" style="color:var(--ink-muted);">Sign in to view your attendance, scores and schedule.</p>

  <!-- segmented switch -->
  <div class="flex items-center gap-1 rounded-lg p-1 mt-6" style="background:var(--surface-alt);">
    <a href="{{ route('login') }}" class="seg-btn flex-1 text-center text-[13px] font-semibold py-2 rounded-md" style="background:#fff; color:var(--ink); box-shadow:0 1px 2px rgba(16,24,40,0.06);">Sign in</a>
    <a href="{{ route('register') }}" class="seg-btn flex-1 text-center text-[13px] font-semibold py-2 rounded-md" style="color:var(--ink-muted);">Create account</a>
  </div>

  @if (session('status'))
    <div class="mt-4 text-[13px] font-medium px-3.5 py-2.5 rounded-lg" style="background:rgba(43,212,128,0.12); color:#0FA36F;">
      {{ session('status') }}
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
    @csrf

    <div>
      <label class="field-label" for="email">Email address</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
             class="input-field focus-ring @error('email') field-error @enderror" autofocus required />
      @error('email') <p class="err-msg">{{ $message }}</p> @enderror
    </div>

    <div>
      <div class="flex items-center justify-between">
        <label class="field-label" for="password">Password</label>
        <a href="{{ route('forgot.password') }}" class="text-[12.5px] font-semibold" style="color:var(--blue);">Forgot password?</a>
      </div>
      <div class="relative">
        <input id="password" type="password" name="password" placeholder="Enter your password"
               class="input-field focus-ring pr-10 @error('password') field-error @enderror" required />
        <button type="button" class="pw-toggle absolute right-3 top-1/2 -translate-y-1/2" style="color:var(--ink-muted);">
          <svg class="h-[18px] w-[18px] eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>
          <svg class="h-[18px] w-[18px] eye-closed hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17.9 17.9A10.4 10.4 0 0 1 12 20c-7 0-11-8-11-8a18.6 18.6 0 0 1 5-5.9M9.9 4.2A9.7 9.7 0 0 1 12 4c7 0 11 8 11 8a18.6 18.6 0 0 1-2.2 3.2M14.1 14.1a3 3 0 1 1-4.2-4.2"/><path d="M1 1l22 22"/></svg>
        </button>
      </div>
      @error('password') <p class="err-msg">{{ $message }}</p> @enderror
    </div>

    <label class="flex items-center gap-2 text-[13px] cursor-pointer" style="color:var(--ink-muted);">
      <input type="checkbox" name="remember" class="h-4 w-4 rounded focus-ring" style="accent-color:var(--blue);">
      Remember me
    </label>

    <button type="submit" class="w-full text-white text-[14px] font-semibold py-3 rounded-lg brand-gradient focus-ring flex items-center justify-center gap-2">
      Sign in
    </button>

    <div class="flex items-center gap-3 py-1">
      <span class="flex-1 h-px" style="background:var(--line);"></span>
      <span class="text-[11.5px]" style="color:var(--ink-muted);">or continue with</span>
      <span class="flex-1 h-px" style="background:var(--line);"></span>
    </div>

    <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center gap-2.5 text-[13.5px] font-semibold py-2.5 rounded-lg border focus-ring" style="border-color:var(--line);">
      <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24"><path fill="#4285F4" d="M23.5 12.27c0-.85-.08-1.67-.22-2.45H12v4.63h6.46a5.53 5.53 0 0 1-2.4 3.63v3h3.87c2.27-2.09 3.57-5.17 3.57-8.81Z"/><path fill="#34A853" d="M12 24c3.24 0 5.96-1.07 7.95-2.92l-3.87-3c-1.08.72-2.45 1.15-4.08 1.15-3.14 0-5.8-2.12-6.75-4.96H1.24v3.09A12 12 0 0 0 12 24Z"/><path fill="#FBBC05" d="M5.25 14.27a7.2 7.2 0 0 1 0-4.54v-3.1H1.24a12 12 0 0 0 0 10.73l4.01-3.09Z"/><path fill="#EA4335" d="M12 4.75c1.76 0 3.34.6 4.59 1.8l3.44-3.44C17.95 1.19 15.24 0 12 0A12 12 0 0 0 1.24 6.63l4.01 3.1c.95-2.84 3.61-4.98 6.75-4.98Z"/></svg>
      Continue with Google
    </a>
  </form>

  <p class="text-center text-[13px] mt-6" style="color:var(--ink-muted);">
    Don't have an account?
    <a href="{{ route('register') }}" class="font-semibold" style="color:var(--blue);">Create one</a>
  </p>
</div>
@endsection