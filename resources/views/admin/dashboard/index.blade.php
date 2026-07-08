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
<p class="font-label-md text-label-md text-on-surface-variant mb-xs">Total Mahasiswa</p>
<h2 class="font-display-lg text-display-lg text-primary">{{ number_format($totalStudents ?? 124) }}</h2>
<span class="text-xs text-green-600 flex items-center gap-1 mt-1">
<span class="material-symbols-outlined text-sm" data-icon="arrow_upward">arrow_upward</span>
                            12% dari bulan lalu
                        </span>
</div>
<div class="bg-primary-container/10 p-sm rounded-lg">
<span class="material-symbols-outlined text-primary" data-icon="school">school</span>
</div>
</div>
<!-- Card 2 -->
<div class="bg-surface-container-lowest rounded-xl p-md shadow-sm border border-outline-variant/10 flex items-center justify-between hover:shadow-md transition-shadow">
<div>
<p class="font-label-md text-label-md text-on-surface-variant mb-xs">Absensi Hari Ini</p>
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
<p class="font-label-md text-label-md text-on-surface-variant mb-xs">Tugas / Log Aktif</p>
<h2 class="font-display-lg text-display-lg text-primary">{{ number_format($totalActivities ?? 18) }}</h2>
<span class="text-xs text-on-tertiary-fixed-variant flex items-center gap-1 mt-1 font-medium">
<span class="material-symbols-outlined text-sm" data-icon="warning">warning</span>
                            Perlu Ditinjau
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
<h3 class="font-headline-md text-headline-md text-on-surface">Analitik Kehadiran</h3>
<p class="text-on-surface-variant font-body-md">Tren kehadiran mingguan seluruh mahasiswa</p>
</div>
<select class="bg-surface-container-low border-none rounded-lg text-label-md px-md py-sm cursor-pointer focus:ring-2 focus:ring-primary">
<option>7 Hari Terakhir</option>
<option>30 Hari Terakhir</option>
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
<!-- QUICK QR GENERATOR / SYSTEM SHORTCUTS (4 Cols) -->
<div class="lg:col-span-4 space-y-lg">
@if(auth()->user()->role === 'administrator')
<!-- System Quick Actions Card for Admin -->
<div class="bg-primary text-on-primary rounded-xl p-lg shadow-lg relative overflow-hidden">
<div class="relative z-10">
<h3 class="font-headline-md text-headline-md mb-xs">Administrasi Sistem</h3>
<p class="text-primary-fixed text-sm mb-lg opacity-80">Pintasan untuk mengelola data mahasiswa, impor data, dan konfigurasi sistem.</p>
<div class="space-y-md">
<a href="{{ route('admin.students.index') }}" class="w-full bg-on-primary text-primary font-bold py-3 rounded-lg hover:bg-surface-variant transition-colors active:scale-95 flex items-center justify-center gap-sm">
<span class="material-symbols-outlined text-[20px]">group</span>
                            Kelola Data Mahasiswa
                        </a>
<a href="{{ route('admin.settings.index') }}" class="w-full bg-primary-container/25 text-on-primary border border-primary-container/50 font-bold py-3 rounded-lg hover:bg-primary-container/45 transition-colors active:scale-95 flex items-center justify-center gap-sm">
<span class="material-symbols-outlined text-[20px]">settings</span>
                            Pengaturan Sistem
                        </a>
</div>
</div>
<!-- Background decoration -->
<div class="absolute -bottom-10 -right-10 w-40 h-40 bg-on-primary-container/20 rounded-full blur-3xl"></div>
</div>
@else
<!-- Discipline Alerts Card for HR -->
<div class="bg-white rounded-2xl p-lg shadow-sm border border-outline-variant/30 flex flex-col space-y-md">
    <div class="flex items-center justify-between border-b border-outline-variant/10 pb-md">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center">
                <span class="material-symbols-outlined text-rose-500 text-lg">warning</span>
            </div>
            <h3 class="font-bold text-primary">Peringatan Kedisiplinan</h3>
        </div>
        <span class="px-2 py-0.5 rounded text-[10px] font-black bg-rose-50 text-rose-600 border border-rose-100 uppercase tracking-wide">Hari Ini</span>
    </div>
    
    <!-- Late Section -->
    <div class="space-y-sm">
        <div class="flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
            <h4 class="text-[10px] font-black text-on-surface-variant uppercase tracking-wider">Terlambat (Check-in > 08:00)</h4>
        </div>
        <div class="space-y-sm max-h-[140px] overflow-y-auto">
            @forelse($lateStudents as $late)
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-rose-50/40 border border-rose-100/40 hover:bg-rose-50 transition-all">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full overflow-hidden">
                            <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($late->student->name) }}&background=FEE2E2&color=991B1B" alt="Avatar">
                        </div>
                        <span class="text-xs font-bold text-on-surface">{{ $late->student->name }}</span>
                    </div>
                    <span class="text-[10px] font-black text-rose-700 bg-rose-100/50 px-2 py-0.5 rounded border border-rose-100">{{ \Carbon\Carbon::parse($late->check_in_time)->format('h:i A') }}</span>
                </div>
            @empty
                <div class="flex items-center gap-2 text-emerald-600 bg-emerald-50/30 border border-emerald-100/30 p-2.5 rounded-xl">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    <span class="text-xs font-semibold">Tepat waktu.</span>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Early Checkout Section -->
    <div class="space-y-sm pt-2 border-t border-outline-variant/10">
        <div class="flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            <h4 class="text-[10px] font-black text-on-surface-variant uppercase tracking-wider">Pulang Cepat (Check-out < 17:00)</h4>
        </div>
        <div class="space-y-sm max-h-[140px] overflow-y-auto">
            @forelse($earlyCheckoutStudents as $early)
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-amber-50/40 border border-amber-100/40 hover:bg-amber-50 transition-all">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full overflow-hidden">
                            <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($early->student->name) }}&background=FEF3C7&color=92400E" alt="Avatar">
                        </div>
                        <span class="text-xs font-bold text-on-surface">{{ $early->student->name }}</span>
                    </div>
                    <span class="text-[10px] font-black text-amber-700 bg-amber-100/50 px-2 py-0.5 rounded border border-amber-100">{{ \Carbon\Carbon::parse($early->check_out_time)->format('h:i A') }}</span>
                </div>
            @empty
                <div class="flex items-center gap-2 text-emerald-600 bg-emerald-50/30 border border-emerald-100/30 p-2.5 rounded-xl">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    <span class="text-xs font-semibold">Tidak ada pulang cepat.</span>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endif
<!-- RECENT FEEDBACK -->
<div class="bg-surface-container-lowest rounded-xl p-lg shadow-sm border border-outline-variant/10">
<div class="flex items-center justify-between mb-md">
<h4 class="font-headline-md text-headline-md text-on-surface">Aktivitas Terbaru</h4>
<a class="text-xs text-primary font-bold hover:underline" href="{{ route('admin.daily_activities.index') ?? '#' }}">Lihat Semua</a>
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
    <p class="text-xs text-on-surface-variant">Menyerahkan Log Harian - Hari ke-45</p>
    <span class="text-[10px] text-outline">2 menit lalu</span>
    </div>
    </div>
    <div class="flex gap-md">
    <img alt="Student Profile" class="w-10 h-10 rounded-full border border-outline-variant" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCjoI4YUjAgy54HJ5k02eSt72ciTRhtHXQk_4-yj0LrH2cKqbQKqLXy0Unl4hsTbkxJjiOY4DQlac_Czo44yAAYkz3b2L1hfQFGCUmSPS7outmZCMca51IL5vBaED1nmpZICGiocDmPOloS_F50SBFyi_esQyijs7Kp6XuaF8BnJ_-VSpNgfYZSZSnMyvRgSjH8U4X0XHr72gvebmRuEwv5kzMYixpWM0xvqjjFWVkWWbptZRORLcSrcb8yYW9EidYxCWO0La_sU3-Z">
    <div class="flex-1">
    <p class="font-label-md text-label-md text-on-surface">Lina Wijaya</p>
    <p class="text-xs text-on-surface-variant">Check-In di Kantor</p>
    <span class="text-[10px] text-outline">15 menit lalu</span>
    </div>
    </div>
    <div class="flex gap-md">
    <div class="w-10 h-10 rounded-full bg-error-container/20 flex items-center justify-center">
    <span class="material-symbols-outlined text-secondary" data-icon="warning">warning</span>
    </div>
    <div class="flex-1">
    <p class="font-label-md text-label-md text-secondary">Peringatan Absensi</p>
    <p class="text-xs text-on-surface-variant">3 mahasiswa absen tanpa keterangan</p>
    <span class="text-[10px] text-outline">1 jam lalu</span>
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
<h3 class="font-headline-md text-headline-md text-on-surface">Progres Mahasiswa Aktif</h3>
<form method="GET" action="{{ route('admin.dashboard') ?? '/admin' }}" class="flex items-center gap-sm m-0">
    <div class="flex items-center bg-surface-container-lowest border border-outline-variant rounded-lg px-sm">
        <span class="material-symbols-outlined text-outline text-sm" data-icon="search">search</span>
        <input name="search" value="{{ request('search') }}" onchange="this.form.submit()" class="bg-transparent border-none text-xs focus:ring-0 py-2 w-48 outline-none" placeholder="Cari mahasiswa..." type="text">
    </div>
    @if(request('search'))
        <a href="{{ route('admin.dashboard') ?? '/admin' }}" class="text-xs text-red-500 hover:underline shrink-0 mr-sm">Hapus</a>
    @endif
</form>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left">
<thead>
<tr class="bg-surface-container-low text-label-md text-on-surface-variant uppercase tracking-wider">
<th class="px-lg py-sm font-bold">Nama Mahasiswa</th>
<th class="px-lg py-sm font-bold">Jurusan</th>
<th class="px-lg py-sm font-bold">Kehadiran</th>
<th class="px-lg py-sm font-bold">Status Log</th>
@if(auth()->user()->role === 'administrator')
<th class="px-lg py-sm font-bold">Aksi</th>
@endif
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
    <tr @if(auth()->user()->role === 'administrator') onclick="window.location='{{ route('admin.students.index', ['edit_id' => $student->id]) }}'" class="hover:bg-surface-container/50 transition-colors cursor-pointer" @else class="hover:bg-surface-container/30 transition-colors" @endif>
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
                <span class="bg-green-100 text-green-800 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-tight">Lengkap</span>
            @else
                <span class="bg-secondary-container/20 text-secondary text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-tight">{{ $missingLogsCount }} Log Belum Ada</span>
            @endif
        </td>
        @if(auth()->user()->role === 'administrator')
        <td class="px-lg py-md">
            <a href="{{ route('admin.students.index', ['edit_id' => $student->id]) }}" class="material-symbols-outlined text-on-surface-variant hover:text-primary" data-icon="edit">edit</a>
        </td>
        @endif
    </tr>
@empty
    <tr>
        <td colspan="{{ auth()->user()->role === 'administrator' ? 5 : 4 }}" class="px-lg py-8 text-center text-on-surface-variant text-sm">
            Belum ada mahasiswa aktif.
        </td>
    </tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
@endsection


