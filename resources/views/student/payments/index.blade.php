@extends('layouts.studentdashboardlayout')

@section('title', 'Payment History')

@section('content')

<main class="px-3 lg:px-8 py-7 max-w-[1240px] mx-auto">

    <!-- PAGE HEADER -->
    <section class="mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('student.dashboard') }}" class="text-[11px] font-medium" style="color:var(--blue);">Dashboard</a>
                    <span class="text-[11px]" style="color:var(--ink-muted);">/</span>
                    <span class="text-[11px]" style="color:var(--ink-muted);">Payments</span>
                </div>
                <h1 class="font-display text-2xl font-bold" style="color:var(--ink);">Payment History</h1>
                <p class="text-[12px] mt-1" style="color:var(--ink-muted);">
                    View your payment records, outstanding balance and transaction history.
                </p>
            </div>

            @if($outstanding > 0)
                <a href="#" class="inline-flex items-center gap-2 rounded-lg text-white text-[12px] font-semibold px-4 py-2.5 brand-gradient focus-ring">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14"/><path d="M5 12h14"/>
                    </svg>
                    Make Payment
                </a>
            @endif
        </div>
    </section>

    <!-- PAYMENT SUMMARY -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">

        <div class="rounded-xl bg-white border p-4" style="border-color:var(--line);">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg grid place-items-center" style="background:rgba(22,87,255,0.09);">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="1.8">
                        <rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 8h10"/><path d="M7 12h6"/><path d="M7 16h4"/>
                    </svg>
                </div>
                <p class="text-[11.5px] font-medium" style="color:var(--ink-muted);">Programme Fee</p>
            </div>
            <p class="font-mono font-600 text-xl mt-3">₦{{ number_format($fee) }}</p>
            <p class="text-[10.5px] mt-1" style="color:var(--ink-muted);">Full programme fee</p>
        </div>

        <div class="rounded-xl bg-white border p-4" style="border-color:var(--line);">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg grid place-items-center" style="background:rgba(43,212,128,0.10);">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="#0FA36F" stroke-width="1.8">
                        <path d="M20 6 9 17l-5-5"/>
                    </svg>
                </div>
                <p class="text-[11.5px] font-medium" style="color:var(--ink-muted);">Amount Paid</p>
            </div>
            <p class="font-mono font-600 text-xl mt-3" style="color:#0FA36F;">₦{{ number_format($amountPaid) }}</p>
            <p class="text-[10.5px] mt-1" style="color:var(--ink-muted);">
                {{ $payments->where('status', 'success')->count() }} {{ Str::plural('payment', $payments->where('status', 'success')->count()) }}
            </p>
        </div>

        <div class="rounded-xl bg-white border p-4" style="border-color:var(--line);">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg grid place-items-center" style="background:rgba(225,68,58,0.09);">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9"/><path d="M12 8v4"/><path d="M12 16h.01"/>
                    </svg>
                </div>
                <p class="text-[11.5px] font-medium" style="color:var(--ink-muted);">Outstanding</p>
            </div>
            <p class="font-mono font-600 text-xl mt-3" style="color:{{ $outstanding > 0 ? 'var(--red)' : 'var(--ink)' }};">
                ₦{{ number_format($outstanding) }}
            </p>
            <p class="text-[10.5px] mt-1" style="color:var(--ink-muted);">
                {{ $outstanding > 0 ? 'Payment required' : 'Fully settled' }}
            </p>
        </div>

        <div class="rounded-xl bg-white border p-4" style="border-color:var(--line);">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg grid place-items-center" style="background:{{ $isUpToDate ? 'rgba(43,212,128,0.10)' : 'rgba(225,68,58,0.09)' }};">
                    @if($isUpToDate)
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="#0FA36F" stroke-width="1.8">
                            <circle cx="12" cy="12" r="9"/><path d="m8 12 2.5 2.5L16 9"/>
                        </svg>
                    @else
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="1.8">
                            <circle cx="12" cy="12" r="9"/><path d="M12 8v4"/><path d="M12 16h.01"/>
                        </svg>
                    @endif
                </div>
                <p class="text-[11.5px] font-medium" style="color:var(--ink-muted);">Payment Status</p>
            </div>
            <div class="mt-3">
                <span class="inline-flex items-center text-[10px] font-semibold px-2 py-1 rounded-full"
                      style="background:{{ $isUpToDate ? 'rgba(43,212,128,0.10)' : 'rgba(225,68,58,0.1)' }}; color:{{ $isUpToDate ? '#0FA36F' : 'var(--red)' }};">
                    {{ $isUpToDate ? 'UP TO DATE' : 'PAYMENT DUE' }}
                </span>
            </div>
        </div>

    </section>

    <!-- PAYMENT PROGRESS -->
    @if($fee > 0)
        <section class="rounded-xl bg-white border p-5 mb-6" style="border-color:var(--line);">
            @php $percent = min(100, round(($amountPaid / $fee) * 100)); @endphp
            <div class="flex items-center justify-between gap-3 mb-3">
                <div>
                    <h2 class="text-[14px] font-semibold">Payment Progress</h2>
                    <p class="text-[11px] mt-0.5" style="color:var(--ink-muted);">Your programme payment completion</p>
                </div>
                <span class="font-mono text-[12px] font-semibold">{{ $percent }}%</span>
            </div>

            <div class="h-2 rounded-full overflow-hidden" style="background:var(--surface-alt);">
                <div class="h-full rounded-full brand-gradient" style="width:{{ $percent }}%;"></div>
            </div>

            <div class="flex items-center justify-between mt-2">
                <span class="text-[10.5px]" style="color:var(--ink-muted);">₦{{ number_format($amountPaid) }} paid</span>
                <span class="text-[10.5px]" style="color:var(--ink-muted);">₦{{ number_format($fee) }} total</span>
            </div>
        </section>
    @endif

    <!-- PAYMENT HISTORY -->
    <section class="rounded-xl bg-white border overflow-hidden" style="border-color:var(--line);">

        <div class="p-5 border-b" style="border-color:var(--line);">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-[15px] font-semibold">Payment History</h2>
                    <p class="text-[11px] mt-0.5" style="color:var(--ink-muted);">Your recorded payment transactions</p>
                </div>
                <span class="text-[10.5px] font-mono px-2 py-1 rounded-md" style="background:var(--surface-alt); color:var(--ink-muted);">
                    {{ $payments->count() }} {{ Str::plural('Transaction', $payments->count()) }}
                </span>
            </div>
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr style="background:var(--surface-alt);">
                        <th class="px-5 py-3 text-[10.5px] font-mono uppercase tracking-wide" style="color:var(--ink-muted);">Date</th>
                        <th class="px-5 py-3 text-[10.5px] font-mono uppercase tracking-wide" style="color:var(--ink-muted);">Reference</th>
                        <th class="px-5 py-3 text-[10.5px] font-mono uppercase tracking-wide" style="color:var(--ink-muted);">Amount</th>
                        <th class="px-5 py-3 text-[10.5px] font-mono uppercase tracking-wide" style="color:var(--ink-muted);">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $p)
                        <tr class="border-t" style="border-color:var(--line);">
                            <td class="px-5 py-4">
                                <p class="text-[12px] font-medium">{{ optional($p->paid_at)->format('M j, Y') ?? '—' }}</p>
                                <p class="text-[10px] mt-0.5" style="color:var(--ink-muted);">{{ optional($p->paid_at)->format('g:i A') }}</p>
                            </td>
                            <td class="px-5 py-4"><span class="font-mono text-[11px]">{{ $p->reference }}</span></td>
                            <td class="px-5 py-4"><span class="font-mono font-semibold text-[12px]">₦{{ number_format($p->amount) }}</span></td>
                            <td class="px-5 py-4">
                                <span class="inline-flex text-[9.5px] font-semibold px-2 py-1 rounded-full"
                                      style="background:{{ $p->status === 'success' ? 'rgba(43,212,128,0.10)' : 'rgba(225,68,58,0.1)' }}; color:{{ $p->status === 'success' ? '#0FA36F' : 'var(--red)' }};">
                                    {{ strtoupper($p->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-6 text-center text-[12px]" style="color:var(--ink-muted);">No payments recorded yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden divide-y" style="border-color:var(--line);">
            @forelse($payments as $p)
                <div class="p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-[12px] font-semibold">Programme Payment</p>
                            <p class="text-[10px] mt-1" style="color:var(--ink-muted);">
                                {{ optional($p->paid_at)->format('M j, Y') ?? '—' }} · {{ optional($p->paid_at)->format('g:i A') }}
                            </p>
                            <p class="font-mono text-[10px] mt-1" style="color:var(--ink-muted);">{{ $p->reference }}</p>
                        </div>
                        <span class="inline-flex text-[9px] font-semibold px-2 py-1 rounded-full"
                              style="background:{{ $p->status === 'success' ? 'rgba(43,212,128,0.10)' : 'rgba(225,68,58,0.1)' }}; color:{{ $p->status === 'success' ? '#0FA36F' : 'var(--red)' }};">
                            {{ strtoupper($p->status) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="font-mono font-semibold text-sm">₦{{ number_format($p->amount) }}</span>
                    </div>
                </div>
            @empty
                <p class="p-4 text-[12px]" style="color:var(--ink-muted);">No payments recorded yet.</p>
            @endforelse
        </div>

    </section>

    <!-- PAYMENT INFORMATION -->
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-3 mt-6">

        <div class="rounded-xl border p-4" style="border-color:var(--line); background:var(--surface-alt);">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg grid place-items-center shrink-0" style="background:rgba(22,87,255,0.09);">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9"/><path d="M12 11v5"/><path d="M12 8h.01"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-[12px] font-semibold">Payment Information</h3>
                    <p class="text-[10.5px] mt-1 leading-relaxed" style="color:var(--ink-muted);">
                        Payments are processed securely. After completing a payment, your transaction record will be available here.
                    </p>
                </div>
            </div>
        </div>

        @if($outstanding > 0)
            <div class="rounded-xl border p-4" style="border-color:rgba(225,68,58,0.20); background:rgba(225,68,58,0.04);">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg grid place-items-center shrink-0" style="background:rgba(225,68,58,0.09);">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="1.8">
                            <circle cx="12" cy="12" r="9"/><path d="M12 8v4"/><path d="M12 16h.01"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[12px] font-semibold">Outstanding Payment</h3>
                        <p class="text-[10.5px] mt-1 leading-relaxed" style="color:var(--ink-muted);">
                            You currently have an outstanding balance of
                            <strong style="color:var(--red);">₦{{ number_format($outstanding) }}</strong>.
                        </p>
                        <a href="#" class="inline-flex items-center gap-1 mt-2 text-[11px] font-semibold" style="color:var(--red);">
                            Make Payment
                            <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endif

    </section>

</main>

@endsection