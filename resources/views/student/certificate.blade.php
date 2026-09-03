@extends('student.layouts.app')

@section('title', 'Certificate')

@section('content')
@php
    $student = auth()->user()->student;
    $certificate = $student?->certificate;
    $requests = $student?->certificateRequests ?? collect();
    $status = $certificate?->status ?? 'not_requested';
@endphp

<div class="space-y-5">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Certificate</h1>
            <p class="text-sm text-slate-500">Manage your academic certificate and certificate requests.</p>
        </div>
        @if($status === 'approved')
            <a href="{{ route('student.certificate.download') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                <i class="fa-solid fa-download"></i> Download
            </a>
        @elseif($status === 'not_requested')
            <a href="{{ route('student.certificate.request') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                <i class="fa-solid fa-plus"></i> Request Certificate
            </a>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500">Certificate Status</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">
                        {{ $status === 'not_requested' ? 'Not Requested' : ucfirst(str_replace('_', ' ', $status)) }}
                    </p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i class="fa-solid fa-certificate"></i>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500">Certificate Type</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">
                        {{ $certificate?->type ?? 'Academic Certificate' }}
                    </p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500">Graduation Session</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">
                        {{ $student?->graduation_session ?? $student?->session?->name ?? 'N/A' }}
                    </p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500">Requests</p>
                    <p class="mt-2 text-lg font-bold text-slate-900">{{ $requests->count() }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i class="fa-solid fa-file-circle-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200">
                <h2 class="font-semibold text-slate-900">Student Information</h2>
            </div>
            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-xs text-slate-500">Full Name</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ $student?->name ?? auth()->user()->name }}</p>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-xs text-slate-500">Matriculation Number</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ $student?->matric_no ?? 'N/A' }}</p>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-xs text-slate-500">Faculty</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ $student?->faculty?->name ?? 'N/A' }}</p>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-xs text-slate-500">Department</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ $student?->department?->name ?? 'N/A' }}</p>
                </div>
                <div class="rounded-lg bg-slate-50 p-4 sm:col-span-2">
                    <p class="text-xs text-slate-500">Programme</p>
                    <p class="mt-1 font-semibold text-slate-900">{{ $student?->program?->name ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200">
                <h2 class="font-semibold text-slate-900">Certificate</h2>
            </div>
            <div class="p-5">
                @if($status === 'approved')
                    <div class="rounded-lg bg-emerald-50 border border-emerald-200 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-emerald-800">Certificate Approved</p>
                                <p class="text-xs text-emerald-700">Your certificate is ready.</p>
                            </div>
                        </div>
                        <a href="{{ route('student.certificate.download') }}" class="mt-4 w-full inline-flex justify-center items-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">
                            <i class="fa-solid fa-download"></i> Download Certificate
                        </a>
                    </div>
                @elseif(in_array($status, ['pending', 'processing']))
                    <div class="rounded-lg bg-amber-50 border border-amber-200 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-amber-800">Request {{ ucfirst($status) }}</p>
                                <p class="text-xs text-amber-700">Your certificate request is being processed.</p>
                            </div>
                        </div>
                    </div>
                @elseif($status === 'rejected')
                    <div class="rounded-lg bg-red-50 border border-red-200 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-red-800">Request Rejected</p>
                                <p class="text-xs text-red-700">{{ $certificate?->remark ?? 'Please contact the appropriate office.' }}</p>
                            </div>
                        </div>
                        <a href="{{ route('student.certificate.request') }}" class="mt-4 w-full inline-flex justify-center items-center gap-2 px-4 py-2 rounded-lg bg-red-600 text-white text-sm font-semibold hover:bg-red-700">
                            <i class="fa-solid fa-rotate-right"></i> Submit Again
                        </a>
                    </div>
                @else
                    <div class="rounded-lg bg-slate-50 border border-slate-200 p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                <i class="fa-solid fa-certificate"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">No Certificate Request</p>
                                <p class="text-xs text-slate-500">You have not submitted a request.</p>
                            </div>
                        </div>
                        <a href="{{ route('student.certificate.request') }}" class="mt-4 w-full inline-flex justify-center items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700">
                            <i class="fa-solid fa-plus"></i> Request Certificate
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-slate-900">Certificate Request History</h2>
                <p class="text-xs text-slate-500 mt-0.5">Your previous certificate requests.</p>
            </div>
            <span class="text-xs font-medium text-slate-500">{{ $requests->count() }} Requests</span>
        </div>
        @if($requests->count())
            <div class="divide-y divide-slate-100">
                @foreach($requests as $request)
                    <div class="p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3 hover:bg-slate-50">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                                <i class="fa-solid fa-file-certificate"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">{{ $request->reference_no ?? 'Certificate Request' }}</p>
                                <p class="text-xs text-slate-500">{{ $request->created_at?->format('d M, Y h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            @php
                                $requestStatus = $request->status ?? 'pending';
                                $statusClasses = [
                                    'approved' => 'bg-emerald-50 text-emerald-700',
                                    'processing' => 'bg-blue-50 text-blue-700',
                                    'pending' => 'bg-amber-50 text-amber-700',
                                    'rejected' => 'bg-red-50 text-red-700',
                                ];
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClasses[$requestStatus] ?? 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($requestStatus) }}
                            </span>
                            @if($requestStatus === 'approved')
                                <a href="{{ route('student.certificate.download', $request->id) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                    Download
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center">
                <div class="w-12 h-12 mx-auto rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center">
                    <i class="fa-solid fa-file-circle-plus text-lg"></i>
                </div>
                <h3 class="mt-3 text-sm font-semibold text-slate-900">No certificate requests</h3>
                <p class="mt-1 text-xs text-slate-500">Your certificate requests will appear here.</p>
            </div>
        @endif
    </div>
</div>
@endsection