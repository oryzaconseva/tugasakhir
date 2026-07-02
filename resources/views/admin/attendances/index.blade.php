@extends('layouts.admin')
@section('content')

<!-- TopNavBar -->
<!-- Page Content -->
<div class="space-y-xl">
<!-- Modern Header Section -->
<div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-lg bg-white p-lg rounded-2xl border border-outline-variant/20 shadow-sm">
<div class="flex items-center gap-lg">
<!-- Circular Progress -->
<div class="relative w-24 h-24 flex items-center justify-center">
<div class="circular-progress w-full h-full rounded-full" style="--percentage: {{ $onTimePercent ?? 88 }};"></div>
<div class="absolute flex flex-col items-center">
<span class="text-xl font-black text-primary leading-none">{{ $onTimePercent ?? 88 }}%</span>
</div>
</div>
<div class="space-y-1">
<div class="flex items-baseline gap-2">
<h2 class="text-4xl font-black text-primary tracking-tight">{{ number_format($totalRecords ?? 0) }}</h2>
<span class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Records Today</span>
</div>
<div class="flex items-center gap-3 mt-2">
<span class="flex items-center gap-1 text-secondary text-[11px] font-bold bg-secondary/10 px-2 py-0.5 rounded">
<span class="material-symbols-outlined text-sm">trending_down</span> Late: {{ number_format($lateCount ?? 0) }}
                        </span>
<p class="text-sm text-on-surface-variant font-medium">Last updated: {{ $lastUpdate ?? now()->format('d M Y') }}</p>
</div>
</div>
</div>
<div class="flex items-center gap-md w-full lg:w-auto justify-between lg:justify-end">
<form method="GET" action="{{ route('admin.attendances.index') }}" class="relative">
<input name="date" onchange="this.form.submit()" class="bg-surface-container-lowest border border-outline-variant/40 rounded-xl py-3 pl-11 pr-4 text-sm font-semibold text-on-surface focus:ring-2 focus:ring-primary appearance-none cursor-pointer hover:border-primary/50 transition-all outline-none" type="date" value="{{ $selectedDate ?? date('Y-m-d') }}">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">calendar_month</span>
</form>
<button class="bg-primary text-white w-12 h-12 rounded-xl flex items-center justify-center hover:bg-primary-container shadow-lg active:scale-95 transition-all">
<span class="material-symbols-outlined">tune</span>
</button>
</div>
</div>
<div class="grid grid-cols-12 gap-xl">
<!-- Refined Attendance Table -->
<section class="col-span-12 lg:col-span-8">
<div class="bg-white rounded-2xl border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col h-full">
<div class="px-xl py-lg border-b border-outline-variant/20 flex justify-between items-center">
<div>
<h3 class="text-xl font-bold text-primary">Live Attendance Status</h3>
<p class="text-xs text-on-surface-variant mt-0.5">Real-time logs for all registered interns</p>
</div>
<button class="text-sm font-bold px-4 py-2 rounded-xl border border-outline-variant/30 hover:bg-surface-container transition-all text-on-surface-variant flex items-center gap-2">
<span class="material-symbols-outlined text-lg">ios_share</span> Export
                        </button>
</div>
<div class="overflow-x-auto flex-1">
<table class="w-full text-left border-collapse min-w-[700px]">
<thead>
<tr class="bg-surface-container-low/30 border-b border-outline-variant/10">
<th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline">Student</th>
<th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline">Cohort</th>
<th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline">Status</th>
<th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline">Check-In</th>
<th class="px-xl py-4 text-center"></th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/10">
@forelse($attendances as $attendance)
<tr class="hover:bg-primary/5 transition-all group">
<td class="px-xl py-5">
<div class="flex items-center gap-4">
<div class="relative">
<div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-700 ring-2 ring-white shadow-sm overflow-hidden">
<img alt="Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($attendance->student->name ?? 'Unknown') }}&background=EBF4FF&color=1F5E9B"/>
</div>
</div>
<div>
<p class="font-bold text-sm text-on-surface leading-none mb-1">{{ $attendance->student->name ?? 'Unknown Student' }}</p>
<p class="text-[11px] text-on-surface-variant font-medium">{{ $attendance->student->email ?? '-' }}</p>
</div>
</div>
</td>
<td class="px-xl py-5">
<span class="text-sm font-medium text-on-surface-variant">{{ $attendance->student->major ?? '-' }}</span>
</td>
<td class="px-xl py-5">
    @if($attendance->status == 'present')
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-700 uppercase tracking-wider border border-emerald-100">
        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> HADIR
        </span>
    @elseif(in_array(strtolower($attendance->status), ['permit', 'izin', 'excused', 'sick', 'sakit']))
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black bg-amber-50 text-amber-700 uppercase tracking-wider border border-amber-100">
        <span class="material-symbols-outlined text-[14px]">event_busy</span> {{ strtoupper($attendance->status) }}
        </span>
    @else
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black bg-rose-50 text-rose-700 uppercase tracking-wider border border-rose-100">
        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> {{ strtoupper($attendance->status) }}
        </span>
    @endif
</td>
<td class="px-xl py-5 text-sm font-semibold text-primary">{{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('h:i A') : '--:--' }}</td>
<td class="px-xl py-5 text-center">
<button class="w-8 h-8 rounded-full flex items-center justify-center text-outline hover:text-primary hover:bg-primary/10 transition-all">
<span class="material-symbols-outlined text-xl">more_horiz</span>
</button>
</td>
</tr>
@empty
<tr>
    <td colspan="5" class="px-xl py-10 text-center text-on-surface-variant">Belum ada data absensi hari ini.</td>
</tr>
@endforelse
</tbody>
</table>
</div>
<div class="px-xl py-lg flex justify-between items-center text-sm font-medium text-on-surface-variant border-t border-outline-variant/10">
<span class="">Showing <span class="text-on-surface font-bold">{{ $attendances->count() }}</span> records</span>
<div class="flex items-center gap-sm">
    @if(method_exists($attendances, 'links'))
        {{ $attendances->links('pagination::tailwind') }}
    @else
        <button class="p-2 border border-outline-variant rounded-md hover:bg-white disabled:opacity-30" disabled="">
        <span class="material-symbols-outlined text-[20px]">chevron_left</span>
        </button>
        <button class="w-8 h-8 flex items-center justify-center rounded-md bg-primary text-on-primary font-label-md text-label-md">1</button>
        <button class="p-2 border border-outline-variant rounded-md hover:bg-white disabled:opacity-30" disabled="">
        <span class="material-symbols-outlined text-[20px]">chevron_right</span>
        </button>
    @endif
</div>
</div>
</div>
</section>
<!-- Sidebar Widgets -->
<aside class="col-span-12 lg:col-span-4 flex flex-col gap-xl">
<!-- Sophisticated QR Widget -->
<div class="bg-white rounded-2xl border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col">
<div class="p-lg border-b border-outline-variant/10 flex justify-between items-center">
<div class="flex items-center gap-2">
<div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
<span class="material-symbols-outlined text-primary text-lg">qr_code_2</span>
</div>
<h4 class="font-bold text-primary">Attendance QR</h4>
</div>
<div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-50 border border-rose-100 text-[10px] font-black text-rose-600 uppercase tracking-wider">
<span class="w-1.5 h-1.5 bg-rose-500 rounded-full animate-ping"></span>
                            LIVE
                        </div>
</div>
<div class="p-lg flex flex-col items-center">
<div class="w-full aspect-square max-w-[240px] bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/20 flex flex-col items-center justify-center relative group shadow-inner">
<!-- High-fidelity QR Visual -->
@if($latestQr)
    <img alt="Dynamic QR Code" class="w-full h-auto p-2" src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($latestQr->qr_data) }}"/>
@else
    <div class="text-center text-sm text-on-surface-variant font-medium p-4">No active QR today.</div>
@endif</div><div class="w-full mt-lg space-y-4">
<form action="{{ route('admin.attendance_qrs.generate') }}" method="POST" class="w-full">
    @csrf
    <button type="submit" class="w-full bg-primary text-white font-bold py-2.5 px-4 rounded-xl hover:bg-primary-container transition-all active:scale-95 flex items-center justify-center gap-2 shadow-sm">
        <span class="material-symbols-outlined text-lg">qr_code_2</span>
        Generate QR Code
    </button>
</form>
<div class="space-y-3">
<div class="flex items-center gap-3 text-on-surface-variant">
<span class="material-symbols-outlined text-xl text-outline">schedule</span>
<div class="flex flex-col">
<span class="text-[10px] font-bold uppercase tracking-widest text-outline leading-none mb-1">Expiration Time</span>
<span class="text-sm font-semibold text-on-surface">Ends at 09:15 AM</span>
</div>
</div>
<div class="flex items-center gap-3 text-on-surface-variant">
<span class="material-symbols-outlined text-xl text-outline">location_on</span>
<div class="flex flex-col">
<span class="text-[10px] font-bold uppercase tracking-widest text-outline leading-none mb-1">Geofencing Radius</span>
<span class="text-sm font-semibold text-on-surface">Millennia Office (50m)</span>
</div>
</div>
</div>
<div class="grid grid-cols-2 gap-3 pt-2">
<button class="flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-outline-variant/30 text-sm font-bold text-on-surface-variant hover:bg-surface-container transition-all active:scale-95">
<span class="material-symbols-outlined text-lg">download</span>
            Download
        </button>
<button class="flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl border border-outline-variant/30 text-sm font-bold text-on-surface-variant hover:bg-surface-container transition-all active:scale-95">
<span class="material-symbols-outlined text-lg">print</span>
            Print
        </button>
</div>
</div></div></div></aside></div></div>@endsection


