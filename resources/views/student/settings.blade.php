@extends('layouts.studentdashboardlayout')
@section('title', 'Profile Settings')

@section('content')

<main class="px-3 lg:px-8 py-7 max-w-[1240px] mx-auto space-y-5">

    <div>
        <h1 class="font-display text-2xl font-bold" style="color:var(--ink);">Profile Settings</h1>
        <p class="text-[12px] mt-1" style="color:var(--ink-muted);">Manage your personal information and account settings.</p>
    </div>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" class="flex items-center gap-3 p-3 rounded-xl" style="background:rgba(43,212,128,0.08); border:1px solid rgba(43,212,128,0.25); color:#0FA36F;">
            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="9"/><path d="m8 12 2.5 2.5L16 9"/>
            </svg>
            <p class="text-sm font-medium flex-1">{{ session('success') }}</p>
            <button type="button" @click="show = false" class="shrink-0 opacity-70 hover:opacity-100" aria-label="Dismiss">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                </svg>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div x-data="{ show: true }" x-show="show" class="p-3 rounded-xl" style="background:rgba(225,68,58,0.06); border:1px solid rgba(225,68,58,0.2); color:var(--red);">
            <div class="flex items-center gap-2 font-semibold text-sm">
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/><path d="M12 8v4"/><path d="M12 16h.01"/>
                </svg>
                <span class="flex-1">Please correct the following errors:</span>
                <button type="button" @click="show = false" class="shrink-0 opacity-70 hover:opacity-100" aria-label="Dismiss">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>
            <ul class="mt-2 pl-5 list-disc text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 items-start">

        <!-- Summary card -->
        <div class="bg-white border rounded-xl overflow-hidden" style="border-color:var(--line);">
            <div class="p-5">
                <div class="flex items-center gap-4">
                    @php
                        $initials  = $student
                        ? collect(explode(' ', trim($student->full_name)))->map(fn($n) => strtoupper($n[0] ?? ''))->take(2)->implode('')
                        : '?';
                    @endphp
                    @if($student->avatar)
                        <img src="{{ asset('uploads/'.$student->avatar) }}" alt="" class="w-16 h-16 rounded-full object-cover">
                    @else
                        <div class="w-16 h-16 rounded-full brand-gradient text-white flex items-center justify-center text-xl font-display font-bold">
                            {{ $initials }}
                        </div>
                    @endif
                    <div class="min-w-0">
                        <h2 class="font-semibold truncate" style="color:var(--ink);">{{ $student->full_name }}</h2>
                        <p class="text-xs truncate" style="color:var(--ink-muted);">{{ $student->email }}</p>
                        <span class="inline-flex mt-2 px-2.5 py-1 rounded-full text-[10px] font-semibold" style="background:rgba(22,87,255,0.08); color:var(--blue);">
                            Student
                        </span>
                    </div>
                </div>
            </div>
            <div class="border-t p-5 space-y-3" style="border-color:var(--line);">
                <div class="flex justify-between gap-3">
                    <span class="text-xs" style="color:var(--ink-muted);">Student ID</span>
                    <span class="text-xs font-semibold">{{ $student->student_id ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between gap-3">
                    <span class="text-xs" style="color:var(--ink-muted);">Programme</span>
                    <span class="text-xs font-semibold text-right">{{ $student->program_name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between gap-3">
                    <span class="text-xs" style="color:var(--ink-muted);">Study Mode</span>
                    <span class="text-xs font-semibold text-right">{{ ucfirst($student->study_mode ?? 'N/A') }}</span>
                </div>
            </div>
        </div>

        <!-- Edit form -->
        <div class="lg:col-span-2 bg-white border rounded-xl overflow-hidden" style="border-color:var(--line);">
            <div class="px-5 py-4 border-b" style="border-color:var(--line);">
                <h2 class="font-semibold" style="color:var(--ink);">Personal Information</h2>
                <p class="text-xs mt-0.5" style="color:var(--ink-muted);">Update your personal information.</p>
            </div>
            <form action="{{ route('student.profile.update') }}" method="POST" class="p-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold mb-1.5" style="color:var(--ink-muted);">Full Name</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $student->full_name) }}"
                               class="w-full rounded-lg border px-3 py-2.5 text-sm" style="border-color:var(--line);" required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1.5" style="color:var(--ink-muted);">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $student->email) }}"
                               class="w-full rounded-lg border px-3 py-2.5 text-sm" style="border-color:var(--line);" required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1.5" style="color:var(--ink-muted);">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $student->phone) }}"
                               class="w-full rounded-lg border px-3 py-2.5 text-sm" style="border-color:var(--line);">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1.5" style="color:var(--ink-muted);">Gender</label>
                        <select name="gender" class="w-full rounded-lg border px-3 py-2.5 text-sm" style="border-color:var(--line);">
                            <option value="">Select Gender</option>
                            <option value="male" @selected(old('gender', $student->gender) === 'male')>Male</option>
                            <option value="female" @selected(old('gender', $student->gender) === 'female')>Female</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold mb-1.5" style="color:var(--ink-muted);">Address</label>
                        <textarea name="address" rows="3" class="w-full rounded-lg border px-3 py-2.5 text-sm" style="border-color:var(--line);">{{ old('address', $student->address) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end mt-5 pt-4 border-t" style="border-color:var(--line);">
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-white text-sm font-semibold brand-gradient focus-ring">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Password -->
    <div class="bg-white border rounded-xl overflow-hidden max-w-xl" style="border-color:var(--line);">
        <div class="px-5 py-4 border-b" style="border-color:var(--line);">
            <h2 class="font-semibold" style="color:var(--ink);">Change Password</h2>
            <p class="text-xs mt-0.5" style="color:var(--ink-muted);">Keep your account secure with a strong password.</p>
        </div>
        <form action="{{ route('student.password.update') }}" method="POST" class="p-5 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:var(--ink-muted);">Current Password</label>
                <input type="password" name="current_password" class="w-full rounded-lg border px-3 py-2.5 text-sm" style="border-color:var(--line);" required>
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:var(--ink-muted);">New Password</label>
                <input type="password" name="password" class="w-full rounded-lg border px-3 py-2.5 text-sm" style="border-color:var(--line);" minlength="8" required>
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:var(--ink-muted);">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="w-full rounded-lg border px-3 py-2.5 text-sm" style="border-color:var(--line);" required>
            </div>

            <div class="flex justify-end pt-1">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-white text-sm font-semibold" style="background:var(--navy);">
                    Update Password
                </button>
            </div>
        </form>
    </div>

    <!-- Account info -->
    <div class="bg-white border rounded-xl overflow-hidden" style="border-color:var(--line);">
        <div class="px-5 py-4 border-b" style="border-color:var(--line);">
            <h2 class="font-semibold" style="color:var(--ink);">Account Information</h2>
        </div>
        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="rounded-lg p-3" style="background:var(--surface-alt);">
                <p class="text-[11px]" style="color:var(--ink-muted);">Account Created</p>
                <p class="text-sm font-semibold mt-1">{{ $student->created_at?->format('d M, Y') }}</p>
            </div>
            <div class="rounded-lg p-3" style="background:var(--surface-alt);">
                <p class="text-[11px]" style="color:var(--ink-muted);">Last Updated</p>
                <p class="text-sm font-semibold mt-1">{{ $student->updated_at?->format('d M, Y') }}</p>
            </div>
        </div>
    </div>

</main>

@endsection