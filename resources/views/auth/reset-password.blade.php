@extends('layouts.auth')
@section('title', 'Set a new password')

@section('content')
<div>
  <a href="{{ route('login') }}" class="flex items-center gap-1.5 text-[13px] font-semibold mb-5" style="color:var(--ink-muted);">
    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    Back to sign in
  </a>

  <h1 class="font-display font-700 text-[26px]" style="font-weight:700;">Set a new password</h1>
  <p class="text-[13.5px] mt-1.5" style="color:var(--ink-muted);">Choose a new password for your {{ $globalSetting->site_name ?? 'Teqhitch' }} account.</p>

  <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-4">
    @csrf

    <input type="hidden" name="token" value="{{ $token ?? request()->route('token') }}">

    <div>
      <label class="field-label" for="email">Email address</label>
      <input id="email" type="email" name="email" value="{{ old('email', $email ?? request('email')) }}" placeholder="you@example.com"
             class="input-field focus-ring @error('email') field-error @enderror" autofocus required />
      @error('email') <p class="err-msg">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="field-label" for="password">New password</label>
      <div class="relative">
        <input id="password" type="password" name="password" placeholder="Create a new password"
               class="input-field focus-ring pr-10 @error('password') field-error @enderror" required />
        <button type="button" class="pw-toggle absolute right-3 top-1/2 -translate-y-1/2" style="color:var(--ink-muted);">
          <svg class="h-[18px] w-[18px] eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>
          <svg class="h-[18px] w-[18px] eye-closed hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17.9 17.9A10.4 10.4 0 0 1 12 20c-7 0-11-8-11-8a18.6 18.6 0 0 1 5-5.9M9.9 4.2A9.7 9.7 0 0 1 12 4c7 0 11 8 11 8a18.6 18.6 0 0 1-2.2 3.2M14.1 14.1a3 3 0 1 1-4.2-4.2"/><path d="M1 1l22 22"/></svg>
        </button>
      </div>
      @error('password') <p class="err-msg">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="field-label" for="password_confirmation">Confirm new password</label>
      <div class="relative">
        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Repeat your new password"
               class="input-field focus-ring pr-10" required />
        <button type="button" class="pw-toggle absolute right-3 top-1/2 -translate-y-1/2" style="color:var(--ink-muted);">
          <svg class="h-[18px] w-[18px] eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/></svg>
          <svg class="h-[18px] w-[18px] eye-closed hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17.9 17.9A10.4 10.4 0 0 1 12 20c-7 0-11-8-11-8a18.6 18.6 0 0 1 5-5.9M9.9 4.2A9.7 9.7 0 0 1 12 4c7 0 11 8 11 8a18.6 18.6 0 0 1-2.2 3.2M14.1 14.1a3 3 0 1 1-4.2-4.2"/><path d="M1 1l22 22"/></svg>
        </button>
      </div>
    </div>

    <button type="submit" class="w-full text-white text-[14px] font-semibold py-3 rounded-lg brand-gradient focus-ring">
      Reset password
    </button>
  </form>
</div>
@endsection