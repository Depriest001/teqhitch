@extends('layouts.studentdashboardlayout')
@section('title', 'Student Dashboard')

@section('content')

<main class="px-3 lg:px-8 py-7 max-w-[1240px] mx-auto">

    <div class="tab-panel active" data-tab-panel="overview">

        <!-- ACCOUNT TYPE -->
        <section class="rounded-2xl p-5 mb-6 flex flex-wrap items-center justify-between gap-4" style="background:var(--navy);">
            <div class="flex items-center gap-4">
                <div class="h-11 w-11 rounded-xl grid place-items-center shrink-0 brand-gradient">
                    <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M22 10 12 5 2 10l10 5 10-5Z"/>
                        <path d="M6 12v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"/>
                    </svg>
                </div>

                <div>
                    <p class="text-[11px] font-mono tracking-wide" style="color:#7B87AC;">
                        ACCOUNT TYPE
                    </p>

                    <p class="text-white font-display text-[15px] mt-0.5 font-bold">
                        {{ $programName ?? 'No program assigned' }}
                        <span class="font-normal" style="color:#9AA4C4;">
                            · {{ ucfirst($student->source) }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                @php
                    $statusColors = [
                        'active'  => ['bg' => 'rgba(43,212,128,0.16)', 'text' => '#4FE3A3'],
                        'pending' => ['bg' => 'rgba(255,184,0,0.16)', 'text' => '#FFB800'],
                    ];
                    $statusStyle = $statusColors[$student->status] ?? ['bg' => 'rgba(123,135,172,0.16)', 'text' => '#7B87AC'];
                @endphp
                <span class="status-badge" style="background:{{ $statusStyle['bg'] }}; color:{{ $statusStyle['text'] }};">
                    {{ strtoupper($student->status) }}
                </span>

                <span class="text-[12px] font-mono" style="color:#7B87AC;">
                    Enrolled {{ $student->created_at->format('M Y') }}
                </span>
            </div>
        </section>

        <!-- BILLING SUMMARY -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-6">

            <!-- Payment Status -->
            <div class="rounded-xl bg-white border p-4" style="border-color:var(--line);">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg grid place-items-center" style="background:{{ $isPaid ? 'rgba(43,212,128,0.10)' : 'rgba(225,68,58,0.09)' }};">
                            @if($isPaid)
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="#0FA36F" stroke-width="2">
                                    <path d="M20 6 9 17l-5-5"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="2">
                                    <circle cx="12" cy="12" r="9"/><path d="M12 8v4"/><path d="M12 16h.01"/>
                                </svg>
                            @endif
                        </div>
                        <p class="text-[12px] font-semibold" style="color:var(--ink);">Payment Status</p>
                    </div>

                    <span class="text-[10px] font-semibold px-2 py-1 rounded-full"
                          style="background:{{ $isPaid ? 'rgba(43,212,128,0.10)' : 'rgba(225,68,58,0.1)' }}; color:{{ $isPaid ? '#0FA36F' : 'var(--red)' }};">
                        {{ $isPaid ? 'Up to date' : 'Payment pending' }}
                    </span>
                </div>

                <p class="font-mono font-600 text-xl mt-3">
                    ₦{{ number_format($fee) }}
                </p>

                <p class="text-[10.5px] mt-1" style="color:var(--ink-muted);">
                    @if($payment && $payment->paid_at)
                        Last payment · {{ $payment->paid_at->format('M j, Y') }}
                    @else
                        No payment recorded yet
                    @endif
                </p>
            </div>

            <!-- Outstanding Balance -->
            <div class="rounded-xl bg-white border p-4" style="border-color:var(--line);">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg grid place-items-center" style="background:rgba(225,68,58,0.09);">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="2">
                            <circle cx="12" cy="12" r="9"/><path d="M12 8v4"/><path d="M12 16h.01"/>
                        </svg>
                    </div>
                    <p class="text-[12px] font-semibold" style="color:var(--ink);">Outstanding Balance</p>
                </div>

                <p class="font-mono font-600 text-xl mt-3" style="color:{{ $outstandingBalance > 0 ? 'var(--red)' : 'var(--ink)' }};">
                    ₦{{ number_format($outstandingBalance) }}
                </p>

                <p class="text-[10.5px] mt-1" style="color:var(--ink-muted);">
                    {{ $outstandingBalance > 0 ? 'Payment required' : 'Fully paid' }}
                </p>
            </div>

            <!-- Next Installment / Repay -->
            <div class="rounded-xl border p-4 flex items-center justify-between gap-3" style="border-color:var(--line); background:var(--surface-alt);">
                <div class="flex items-center gap-2 min-w-0">
                    <div class="w-8 h-8 rounded-lg grid place-items-center shrink-0" style="background:rgba(22,87,255,0.09);">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="2">
                            <rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18"/><path d="M7 15h3"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[12px] font-semibold" style="color:var(--ink);">
                            {{ $outstandingBalance > 0 ? 'Balance Due' : 'All Settled' }}
                        </p>
                        <p class="text-[10.5px] mt-1" style="color:var(--ink-muted);">
                            {{ $outstandingBalance > 0 ? 'Complete your payment' : 'No action needed' }}
                        </p>
                    </div>
                </div>

                @if($outstandingBalance > 0)
                    <a href="#" class="shrink-0 inline-flex items-center gap-1 rounded-lg text-white text-[11px] font-semibold px-3 py-2 brand-gradient focus-ring">
                        Repay
                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>
                        </svg>
                    </a>
                @endif
            </div>

        </section>

        <!-- COURSES OPEN FOR ENROLLMENT -->
        <section class="rounded-xl bg-white p-5 border mb-6" style="border-color:var(--line);">

            <div class="flex flex-wrap items-end justify-between gap-3 mb-5">
                <div>
                    <h2 class="font-display text-lg font-bold">Courses open for enrollment</h2>
                    <p class="text-[12px] mt-1" style="color:var(--ink-muted);">
                        Add an elective or start a new track alongside your current program.
                    </p>
                </div>
                <a href="{{ route('student.programs.index') }}" class="text-[12px] font-semibold" style="color:var(--blue);">
                    View all programs →
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @forelse($availableCourses as $course)
                    <div class="rounded-xl border p-4 flex flex-col" style="border-color:var(--line);">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            @if($course->category ?? false)
                                <span class="track-chip px-2 py-1 rounded-md text-[10px]" style="background:rgba(22,87,255,0.09); color:var(--cyan);">
                                    {{ strtoupper($course->category) }}
                                </span>
                            @endif

                            @if(isset($course->seats_left))
                                <span class="text-[10px] font-mono px-2 py-0.5 rounded-full"
                                      style="background:{{ $course->seats_left <= 5 ? 'rgba(225,68,58,0.1)' : 'rgba(43,212,128,0.1)' }}; color:{{ $course->seats_left <= 5 ? 'var(--red)' : '#0FA36F' }};">
                                    {{ $course->seats_left }} seats left
                                </span>
                            @endif
                        </div>

                        <h3 class="text-sm font-semibold leading-snug">
                            {{ $course->title }}
                        </h3>

                        @if($course->duration ?? false)
                            <p class="text-[11px] mt-1" style="color:var(--ink-muted);">
                                {{ $course->duration }}
                            </p>
                        @endif

                        <div class="mt-4 flex items-center justify-between">
                            <span class="font-mono font-600 text-[14px]">
                                ₦{{ number_format($course->price) }}
                            </span>

                            <form action="{{ route('enrollment.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <button type="submit" class="text-[11.5px] font-semibold px-3 py-1.5 rounded-lg text-white brand-gradient focus-ring">
                                    Enroll
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-[12px] col-span-full" style="color:var(--ink-muted);">
                        No other courses are currently open for enrollment.
                    </p>
                @endforelse
            </div>

        </section>

    </div>

</main>

@endsection