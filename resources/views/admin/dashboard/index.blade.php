@extends('layouts.admin')
@section('content')

<!-- HEADER -->
<!-- DASHBOARD CANVAS -->
<div class="space-y-lg">
<!-- METRIC CARDS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-md">
<!-- Card 1 -->
<div class="bg-surface-container-lowest rounded-xl p-md shadow-sm border border-outline-variant/10 flex items-center justify-between hover:shadow-md transition-shadow">
<div>
<p class="font-label-md text-label-md text-on-surface-variant mb-xs">Total Interns</p>
<h2 class="font-display-lg text-display-lg text-primary">{{ number_format($totalStudents ?? 124) }}</h2>
<span class="text-xs text-green-600 flex items-center gap-1 mt-1">
<span class="material-symbols-outlined text-sm" data-icon="arrow_upward">arrow_upward</span>
                            12% from last month
                        </span>
</div>
<div class="bg-primary-container/10 p-sm rounded-lg">
<span class="material-symbols-outlined text-primary" data-icon="school">school</span>
</div>
</div>
<!-- Card 2 -->
<div class="bg-surface-container-lowest rounded-xl p-md shadow-sm border border-outline-variant/10 flex items-center justify-between hover:shadow-md transition-shadow">
<div>
<p class="font-label-md text-label-md text-on-surface-variant mb-xs">Daily Attendances</p>
<h2 class="font-display-lg text-display-lg text-primary">{{ number_format($todayAttendances ?? 94) }}</h2>
<div class="w-32 h-1.5 bg-surface-container mt-2 rounded-full overflow-hidden">
<div class="h-full bg-secondary-container w-[94.2%] rounded-full"></div>
</div>
</div>
<div class="bg-secondary-container/10 p-sm rounded-lg">
<span class="material-symbols-outlined text-secondary" data-icon="event_available">event_available</span>
</div>
</div>
<!-- Card 3 -->
<div class="bg-surface-container-lowest rounded-xl p-md shadow-sm border border-outline-variant/10 flex items-center justify-between hover:shadow-md transition-shadow">
<div>
<p class="font-label-md text-label-md text-on-surface-variant mb-xs">Active Tasks / Logs</p>
<h2 class="font-display-lg text-display-lg text-primary">{{ number_format($totalActivities ?? 18) }}</h2>
<span class="text-xs text-on-tertiary-fixed-variant flex items-center gap-1 mt-1 font-medium">
<span class="material-symbols-outlined text-sm" data-icon="warning">warning</span>
                            Needs Review
                        </span>
</div>
<div class="bg-tertiary-container/10 p-sm rounded-lg">
<span class="material-symbols-outlined text-on-tertiary-container" data-icon="task">task</span>
</div>
</div>
</div>
<!-- MAIN GRID: BENTO STYLE -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-lg h-full">
<!-- ATTENDANCE ANALYTICS (7 Cols) -->
<div class="lg:col-span-8 bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 p-lg flex flex-col h-full">
<div class="flex items-center justify-between mb-lg">
<div>
<h3 class="font-headline-md text-headline-md text-on-surface">Attendance Analytics</h3>
<p class="text-on-surface-variant font-body-md">Weekly engagement trends across all cohorts</p>
</div>
<select class="bg-surface-container-low border-none rounded-lg text-label-md px-md py-sm cursor-pointer focus:ring-2 focus:ring-primary">
<option>Last 7 Days</option>
<option>Last 30 Days</option>
</select>
</div>
<!-- MOCK CHART SPACE -->
<div class="flex-1 relative min-h-[300px] flex items-end gap-sm md:gap-lg pb-md px-md">
<!-- Chart Lines (Stylized with div) -->
<div class="absolute inset-0 flex flex-col justify-between pointer-events-none opacity-20">
<div class="border-b border-outline w-full h-0"></div>
<div class="border-b border-outline w-full h-0"></div>
<div class="border-b border-outline w-full h-0"></div>
<div class="border-b border-outline w-full h-0"></div>
<div class="border-b border-outline w-full h-0"></div>
</div>
<!-- Bars -->
<div class="flex-1 flex flex-col justify-end group">
<div class="bg-primary rounded-t-lg transition-all group-hover:bg-secondary" style="height: 65%"></div>
<p class="text-center text-[10px] mt-sm text-on-surface-variant font-bold">MON</p>
</div>
<div class="flex-1 flex flex-col justify-end group">
<div class="bg-primary rounded-t-lg transition-all group-hover:bg-secondary" style="height: 80%"></div>
<p class="text-center text-[10px] mt-sm text-on-surface-variant font-bold">TUE</p>
</div>
<div class="flex-1 flex flex-col justify-end group">
<div class="bg-primary rounded-t-lg transition-all group-hover:bg-secondary" style="height: 45%"></div>
<p class="text-center text-[10px] mt-sm text-on-surface-variant font-bold">WED</p>
</div>
<div class="flex-1 flex flex-col justify-end group">
<div class="bg-secondary-container rounded-t-lg transition-all group-hover:brightness-110" style="height: 92%"></div>
<p class="text-center text-[10px] mt-sm text-on-surface-variant font-bold">THU</p>
</div>
<div class="flex-1 flex flex-col justify-end group">
<div class="bg-primary rounded-t-lg transition-all group-hover:bg-secondary" style="height: 75%"></div>
<p class="text-center text-[10px] mt-sm text-on-surface-variant font-bold">FRI</p>
</div>
<div class="flex-1 flex flex-col justify-end group opacity-50">
<div class="bg-outline-variant rounded-t-lg" style="height: 20%"></div>
<p class="text-center text-[10px] mt-sm text-on-surface-variant font-bold">SAT</p>
</div>
<div class="flex-1 flex flex-col justify-end group opacity-50">
<div class="bg-outline-variant rounded-t-lg" style="height: 15%"></div>
<p class="text-center text-[10px] mt-sm text-on-surface-variant font-bold">SUN</p>
</div>
</div>
</div>
<!-- QUICK QR GENERATOR (4 Cols) -->
<div class="lg:col-span-4 space-y-lg">
<!-- QR Generator Card -->
<div class="bg-primary text-on-primary rounded-xl p-lg shadow-lg relative overflow-hidden">
<div class="relative z-10">
<h3 class="font-headline-md text-headline-md mb-xs">Daily Check-in</h3>
<p class="text-primary-fixed text-sm mb-lg opacity-80">Generate today's secure attendance QR code for your cohort.</p>
<div class="bg-white p-lg rounded-xl flex items-center justify-center mb-lg mx-auto w-48 h-48 border-4 border-primary-container shadow-inner group cursor-pointer relative">
<!-- Mock QR Pattern -->
@if(isset($latestQr) && $latestQr)
    <img alt="Dynamic QR Code" class="w-full h-full object-cover" src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($latestQr->qr_data) }}"/>
@else
    <div class="w-full h-full flex items-center justify-center text-primary font-bold text-center">No active QR</div>
@endif
<div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black/5">
<span class="material-symbols-outlined text-primary text-4xl" data-icon="refresh">refresh</span>
</div>
</div>
<form action="{{ route('admin.attendance_qrs.generate') ?? '#' }}" method="POST" class="w-full">
    @csrf
    <button type="submit" class="w-full bg-on-primary text-primary font-bold py-sm rounded-lg hover:bg-surface-variant transition-colors active:scale-95 flex items-center justify-center gap-sm">
    <span class="material-symbols-outlined" data-icon="qr_code_2">qr_code_2</span>
                                Generate QR Code
                            </button>
</form>
</div>
<!-- Background decoration -->
<div class="absolute -bottom-10 -right-10 w-40 h-40 bg-on-primary-container/20 rounded-full blur-3xl"></div>
</div>
<!-- RECENT FEEDBACK -->
<div class="bg-surface-container-lowest rounded-xl p-lg shadow-sm border border-outline-variant/10">
<div class="flex items-center justify-between mb-md">
<h4 class="font-headline-md text-headline-md text-on-surface">Recent Activity</h4>
<a class="text-xs text-primary font-bold hover:underline" href="{{ route('admin.daily_activities.index') ?? '#' }}">View All</a>
</div>
<div class="space-y-md">
@if(isset($recentActivities) && count($recentActivities) > 0)
    @foreach($recentActivities->take(3) as $activity)
    <div class="flex gap-md">
    <div class="w-10 h-10 rounded-full bg-primary/10 border border-outline-variant flex items-center justify-center font-bold text-primary text-xs">
    {{ strtoupper(substr($activity->student->name ?? '?', 0, 1)) }}
    </div>
    <div class="flex-1">
    <p class="font-label-md text-label-md text-on-surface">{{ $activity->student->name ?? 'Unknown' }}</p>
    <p class="text-xs text-on-surface-variant">{{ Str::limit($activity->activity_description, 30) }}</p>
    <span class="text-[10px] text-outline">{{ \Carbon\Carbon::parse($activity->date)->diffForHumans() }}</span>
    </div>
    </div>
    @endforeach
@else
    <div class="flex gap-md">
    <img alt="Student Profile" class="w-10 h-10 rounded-full border border-outline-variant" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAcHWszGk_tyEqm4l0uyh6LGCLkrjy-chUdfCENaA8bbF7tcdFzoVBw04IBCLT9zLXzmYEGYlOSHNhkTXNlJ5XDe3_E5L1e0wls6mzqJ3phvaejYn4ljL3ghD_HvuwQT2xKtFCNARVPQddqXtSehK_OW9ocdX0YBQ4-CnXyNHM1FpmgJNRdxhxbSKjlWNlA6gUSvpdZ_natyUmsUnc9TqRZossVEiVfJj57HIsMZ0IXm84wupvd4QwCMphB1FIQkM_hR48-e7yki9m_">
    <div class="flex-1">
    <p class="font-label-md text-label-md text-on-surface">Budi Santoso</p>
    <p class="text-xs text-on-surface-variant">Submitted Daily Log - Day 45</p>
    <span class="text-[10px] text-outline">2 mins ago</span>
    </div>
    </div>
    <div class="flex gap-md">
    <img alt="Student Profile" class="w-10 h-10 rounded-full border border-outline-variant" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCjoI4YUjAgy54HJ5k02eSt72ciTRhtHXQk_4-yj0LrH2cKqbQKqLXy0Unl4hsTbkxJjiOY4DQlac_Czo44yAAYkz3b2L1hfQFGCUmSPS7outmZCMca51IL5vBaED1nmpZICGiocDmPOloS_F50SBFyi_esQyijs7Kp6XuaF8BnJ_-VSpNgfYZSZSnMyvRgSjH8U4X0XHr72gvebmRuEwv5kzMYixpWM0xvqjjFWVkWWbptZRORLcSrcb8yYW9EidYxCWO0La_sU3-Z">
    <div class="flex-1">
    <p class="font-label-md text-label-md text-on-surface">Lina Wijaya</p>
    <p class="text-xs text-on-surface-variant">Checked-in at Office</p>
    <span class="text-[10px] text-outline">15 mins ago</span>
    </div>
    </div>
    <div class="flex gap-md">
    <div class="w-10 h-10 rounded-full bg-error-container/20 flex items-center justify-center">
    <span class="material-symbols-outlined text-secondary" data-icon="warning">warning</span>
    </div>
    <div class="flex-1">
    <p class="font-label-md text-label-md text-secondary">Attendance Alert</p>
    <p class="text-xs text-on-surface-variant">3 students absent without leave</p>
    <span class="text-[10px] text-outline">1 hour ago</span>
    </div>
    </div>
@endif
</div>
</div>
</div>
</div>
<!-- RECENT STUDENT ACTIVITY TABLE -->
<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 overflow-hidden">
<div class="px-lg py-md border-b border-outline-variant/30 flex justify-between items-center bg-surface-container-low/30">
<h3 class="font-headline-md text-headline-md text-on-surface">Active Intern Progress</h3>
<form method="GET" action="{{ route('admin.dashboard') ?? '/admin' }}" class="flex items-center gap-sm m-0">
    <div class="flex items-center bg-surface-container-lowest border border-outline-variant rounded-lg px-sm">
        <span class="material-symbols-outlined text-outline text-sm" data-icon="search">search</span>
        <input name="search" value="{{ request('search') }}" onchange="this.form.submit()" class="bg-transparent border-none text-xs focus:ring-0 py-2 w-48 outline-none" placeholder="Search interns..." type="text">
    </div>
    @if(request('search'))
        <a href="{{ route('admin.dashboard') ?? '/admin' }}" class="text-xs text-red-500 hover:underline shrink-0 mr-sm">Clear</a>
    @endif
</form>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left">
<thead>
<tr class="bg-surface-container-low text-label-md text-on-surface-variant uppercase tracking-wider">
<th class="px-lg py-sm font-bold">Student Name</th>
<th class="px-lg py-sm font-bold">Cohort</th>
<th class="px-lg py-sm font-bold">Attendance</th>
<th class="px-lg py-sm font-bold">Log Status</th>
<th class="px-lg py-sm font-bold">Action</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/20">
@forelse($activeInterns as $student)
    @php
        $words = explode(' ', $student->name);
        $initials = strtoupper(substr($words[0] ?? '', 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
        $attendanceRate = $student->attendances_count > 0 ? round(($student->present_count / $student->attendances_count) * 100) : 100;
        $missingLogsCount = max(0, $student->present_count - $student->daily_activities_count);
    @endphp
    <tr onclick="window.location='{{ route('admin.students.index', ['edit_id' => $student->id]) }}'" class="hover:bg-surface-container/50 transition-colors cursor-pointer">
        <td class="px-lg py-md">
            <div class="flex items-center gap-sm">
                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center font-bold text-primary text-xs">{{ $initials }}</div>
                <span class="font-label-md text-label-md text-on-surface font-semibold">{{ $student->name }}</span>
            </div>
        </td>
        <td class="px-lg py-md text-on-surface-variant text-sm">{{ $student->major ?? '-' }}</td>
        <td class="px-lg py-md">
            <div class="flex items-center gap-sm">
                <span class="text-xs font-bold text-on-surface">{{ $attendanceRate }}%</span>
                <div class="flex-1 w-20 h-1 bg-surface-container rounded-full overflow-hidden">
                    @if($attendanceRate >= 90)
                        <div class="h-full bg-green-500 rounded-full" style="width: {{ $attendanceRate }}%"></div>
                    @elseif($attendanceRate >= 75)
                        <div class="h-full bg-primary rounded-full" style="width: {{ $attendanceRate }}%"></div>
                    @else
                        <div class="h-full bg-secondary rounded-full" style="width: {{ $attendanceRate }}%"></div>
                    @endif
                </div>
            </div>
        </td>
        <td class="px-lg py-md">
            @if($missingLogsCount === 0)
                <span class="bg-green-100 text-green-800 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-tight">Up to date</span>
            @else
                <span class="bg-secondary-container/20 text-secondary text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-tight">{{ $missingLogsCount }} Logs Missing</span>
            @endif
        </td>
        <td class="px-lg py-md">
            <a href="{{ route('admin.students.index', ['edit_id' => $student->id]) }}" class="material-symbols-outlined text-on-surface-variant hover:text-primary" data-icon="edit">edit</a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="px-lg py-8 text-center text-on-surface-variant text-sm">
            No active interns found.
        </td>
    </tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
@endsection


