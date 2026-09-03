@extends('layouts.studentdashboardlayout')
@section('title', 'Programs')

@section('content')

<main class="px-3 lg:px-8 py-7 max-w-[1240px] mx-auto">

    <!-- PAGE HEADER -->
    <section class="mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('student.dashboard') }}" class="text-[11px] font-medium" style="color:var(--blue);">
                        Dashboard
                    </a>
                    <span class="text-[11px]" style="color:var(--ink-muted);">/</span>
                    <span class="text-[11px]" style="color:var(--ink-muted);">Programs</span>
                </div>

                <h1 class="font-display text-2xl font-bold" style="color:var(--ink);">Programs</h1>

                <p class="text-[12px] mt-1" style="color:var(--ink-muted);">
                    Manage your current programme and explore available learning tracks.
                </p>
            </div>

            <a href="#available-programs" class="inline-flex items-center gap-2 rounded-lg text-white text-[12px] font-semibold px-4 py-2.5 brand-gradient focus-ring">
                Explore Programs
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>
                </svg>
            </a>
        </div>
    </section>

    <!-- CURRENT PROGRAM -->
    <section class="rounded-2xl border overflow-hidden mb-6" style="border-color:var(--line);">

        <div class="p-5 lg:p-6" style="background:var(--navy);">
            <div class="flex flex-wrap items-start justify-between gap-5">
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 rounded-xl grid place-items-center shrink-0 brand-gradient">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-[10px] font-mono tracking-widest" style="color:#7B87AC;">CURRENT PROGRAMME</p>
                        <h2 class="text-white text-xl font-bold mt-1">{{ $programName ?? 'No programme assigned' }}</h2>
                        <p class="text-[11px] mt-1" style="color:#9AA4C4;">{{ ucfirst($student->source) }}</p>
                    </div>
                </div>

                @php
                    $statusColors = [
                        'active'  => ['bg' => 'rgba(43,212,128,0.16)', 'text' => '#4FE3A3'],
                        'pending' => ['bg' => 'rgba(255,184,0,0.16)', 'text' => '#FFB800'],
                    ];
                    $statusStyle = $statusColors[$student->status] ?? ['bg' => 'rgba(123,135,172,0.16)', 'text' => '#7B87AC'];
                @endphp
                <span class="text-[10px] font-semibold px-2.5 py-1 rounded-full" style="background:{{ $statusStyle['bg'] }}; color:{{ $statusStyle['text'] }};">
                    {{ strtoupper($student->status) }}
                </span>
            </div>
        </div>

        <div class="bg-white p-5 lg:p-6">
            {{-- Progress bar removed: no completion-tracking data exists yet --}}

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div>
                    <p class="text-[10px]" style="color:var(--ink-muted);">Learning Mode</p>
                    <p class="text-[12px] font-semibold mt-1">{{ ucfirst($student->study_mode ?? '—') }}</p>
                </div>

                <div>
                    <p class="text-[10px]" style="color:var(--ink-muted);">Enrolled</p>
                    <p class="text-[12px] font-semibold mt-1">{{ $student->created_at->format('M Y') }}</p>
                </div>
            </div>
        </div>

    </section>

    <!-- AVAILABLE PROGRAMS -->
    <section id="available-programs">

        <div class="flex flex-wrap items-end justify-between gap-3 mb-5">
            <div>
                <h2 class="font-display text-lg font-bold">Available Programs</h2>
                <p class="text-[12px] mt-1" style="color:var(--ink-muted);">
                    Explore other programmes and expand your skills.
                </p>
            </div>

            <span class="text-[10.5px] font-mono px-2 py-1 rounded-md" style="background:var(--surface-alt); color:var(--ink-muted);">
                {{ $availableCourses->count() }} {{ Str::plural('Program', $availableCourses->count()) }} Available
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @forelse($availableCourses as $course)
                <div class="rounded-xl bg-white border p-4 flex flex-col" style="border-color:var(--line);">

                    @if($course->category ?? false)
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <span class="px-2 py-1 rounded-md text-[10px] font-semibold" style="background:rgba(22,87,255,0.09); color:var(--cyan);">
                                {{ strtoupper($course->category) }}
                            </span>
                        </div>
                    @endif

                    <h3 class="text-[14px] font-semibold">{{ $course->title }}</h3>

                    @if($course->description ?? false)
                        <p class="text-[11px] mt-1 leading-relaxed" style="color:var(--ink-muted);">
                            {{ Str::limit($course->description, 100) }}
                        </p>
                    @endif

                    <div class="grid grid-cols-2 gap-3 mt-4 pt-4 border-t" style="border-color:var(--line);">
                        @if($course->duration ?? false)
                            <div>
                                <p class="text-[9.5px]" style="color:var(--ink-muted);">Duration</p>
                                <p class="text-[11.5px] font-semibold mt-1">{{ $course->duration }}</p>
                            </div>
                        @endif

                        <div>
                            <p class="text-[9.5px]" style="color:var(--ink-muted);">Fee</p>
                            <p class="font-mono text-[11.5px] font-semibold mt-1">₦{{ number_format($course->price) }}</p>
                        </div>
                    </div>

                    <a href="{{ route('courses.show', $course->id) }}" class="mt-4 w-full inline-flex items-center justify-center rounded-lg text-white text-[11.5px] font-semibold py-2.5 brand-gradient focus-ring">
                        View Program
                    </a>
                </div>
            @empty
                <p class="text-[12px] col-span-full" style="color:var(--ink-muted);">
                    No other programs are currently open.
                </p>
            @endforelse
        </div>

    </section>

</main>

@endsection