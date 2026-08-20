@extends('layouts.auth')
@section('title', 'Reset your password')

@section('content')
<div>
  <a href="{{ route('login') }}" class="flex items-center gap-1.5 text-[13px] font-semibold mb-5" style="color:var(--ink-muted);">
    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    Back to sign in
  </a>

  @if (session('status'))
    <div class="text-center py-6">
      <div class="h-14 w-14 rounded-full mx-auto grid place-items-center" style="background:rgba(43,212,128,0.12);">
        <svg class="h-7 w-7" style="color:#0FA36F;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M20 6 9 17l-5-5"/></svg>
      </div>
      <h2 class="font-display font-700 text-[18px] mt-4" style="font-weight:700;">Check your inbox</h2>
      <p class="text-[13.5px] mt-1.5" style="color:var(--ink-muted);">{{ session('status') }}</p>
      <a href="{{ route('login') }}" class="inline-block mt-6 text-[13.5px] font-semibold" style="color:var(--blue);">Return to sign in</a>
    </div>
  @else
    <h1 class="font-display font-700 text-[26px]" style="font-weight:700;">Reset your password</h1>
    <p class="text-[13.5px] mt-1.5" style="color:var(--ink-muted);">Enter your account email and we'll send a reset link.</p>

    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
      @csrf

      <div>
        <label class="field-label" for="email">Email address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
               class="input-field focus-ring @error('email') field-error @enderror" autofocus required />
        @error('email') <p class="err-msg">{{ $message }}</p> @enderror
      </div>

      <button type="submit" class="w-full text-white text-[14px] font-semibold py-3 rounded-lg brand-gradient focus-ring">
        Send reset link
      </button>
    </form>
  @endif
</div>
@endsection