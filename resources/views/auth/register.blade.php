@extends('layouts.auth')
@section('title', 'Create account')

@section('content')
<div>
  <h1 class="font-display font-700 text-[26px]" style="font-weight:700;">Create your account</h1>
  <p class="text-[13.5px] mt-1.5" style="color:var(--ink-muted);">Join a track and start tracking your onsite progress.</p>

  <div class="flex items-center gap-1 rounded-lg p-1 mt-6" style="background:var(--surface-alt);">
    <a href="{{ route('login') }}" class="seg-btn flex-1 text-center text-[13px] font-semibold py-2 rounded-md" style="color:var(--ink-muted);">Sign in</a>
    <a href="{{ route('register') }}" class="seg-btn flex-1 text-center text-[13px] font-semibold py-2 rounded-md" style="background:#fff; color:var(--ink); box-shadow:0 1px 2px rgba(16,24,40,0.06);">Create account</a>
  </div>

  <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
    @csrf

    <div>
      <label class="field-label" for="name">Full name</label>
      <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Chidera Okafor"
             class="input-field focus-ring @error('name') field-error @enderror" autofocus required />
      @error('name') <p class="err-msg">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="field-label" for="email">Email address</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
             class="input-field focus-ring @error('email') field-error @enderror" required />
      @error('email') <p class="err-msg">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="field-label" for="phone">Phone number</label>
      <input id="phone" type="tel" name="phone" required value="{{ old('phone') }}" placeholder="+234 900 000 0000"
             class="input-field focus-ring @error('phone') field-error @enderror" />
      @error('phone') <p class="err-msg">{{ $message }}</p> @enderror
    </div>

    <!-- <div>
      <label class="field-label" for="type">Student type</label>
      <select id="type" name="studen_type" required class="input-field focus-ring @error('studen_type') field-error @enderror">
        <option value="" selected disabled>--- Select student type ---</option>
        <option value="SIWES" @selected(old('studen_type') === 'SIWES')>SIWES Student</option>
        <option value="Regular" @selected(old('studen_type') === 'Regular')>Regular Student</option>
      </select>
      @error('studen_type') <p class="err-msg">{{ $message }}</p> @enderror
    </div> -->

    <div>
      <label class="field-label" for="password">Password</label>
      <div class="relative">
        <input id="password" type="password" name="password" placeholder="Create a password"
               class="input-field focus-ring pr-10 @error('password') field-error @enderror" required />
        <button type="button" class="pw-toggle absolute right-3 top-1/2 -translate-y-1/2" style="color:var(--ink-muted);">
          <svg class="h-[18px] w-[18px] eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>
          <svg class="h-[18px] w-[18px] eye-closed hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17.9 17.9A10.4 10.4 0 0 1 12 20c-7 0-11-8-11-8a18.6 18.6 0 0 1 5-5.9M9.9 4.2A9.7 9.7 0 0 1 12 4c7 0 11 8 11 8a18.6 18.6 0 0 1-2.2 3.2M14.1 14.1a3 3 0 1 1-4.2-4.2"/><path d="M1 1l22 22"/></svg>
        </button>
      </div>
      @error('password') <p class="err-msg">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="field-label" for="password_confirmation">Confirm password</label>
      <div class="relative">
        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Repeat your password"
               class="input-field focus-ring pr-10" required />
        <button type="button" class="pw-toggle absolute right-3 top-1/2 -translate-y-1/2" style="color:var(--ink-muted);">
          <svg class="h-[18px] w-[18px] eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>
          <svg class="h-[18px] w-[18px] eye-closed hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17.9 17.9A10.4 10.4 0 0 1 12 20c-7 0-11-8-11-8a18.6 18.6 0 0 1 5-5.9M9.9 4.2A9.7 9.7 0 0 1 12 4c7 0 11 8 11 8a18.6 18.6 0 0 1-2.2 3.2M14.1 14.1a3 3 0 1 1-4.2-4.2"/><path d="M1 1l22 22"/></svg>
        </button>
      </div>
    </div>

    <label class="flex items-start gap-2.5 text-[12.5px] cursor-pointer @error('terms') text-[--pink] @enderror" style="color:var(--ink-muted);">
      <input type="checkbox" name="terms" class="h-4 w-4 rounded mt-0.5 focus-ring" style="accent-color:var(--blue);" required>
      I agree to {{ $globalSetting->site_name ?? 'Teqhitch' }}'s Terms of Service and Privacy Policy.
    </label>
    @error('terms') <p class="err-msg">{{ $message }}</p> @enderror

    <button type="submit" class="w-full text-white text-[14px] font-semibold py-3 rounded-lg brand-gradient focus-ring">
      Create account
    </button>
  </form>

  <p class="text-center text-[13px] mt-6" style="color:var(--ink-muted);">
    Already have an account?
    <a href="{{ route('login') }}" class="font-semibold" style="color:var(--blue);">Sign in</a>
  </p>
</div>
@endsection