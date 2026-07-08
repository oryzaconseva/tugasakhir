@extends('layouts.admin')
@section('content')

{{-- Flash message notifikasi --}}
@if(session('success'))
<div id="flash-success" class="fixed top-6 right-6 z-50 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl shadow-xl max-w-sm animate-fade-in-down">
    <span class="material-symbols-outlined text-emerald-600 text-2xl">check_circle</span>
    <p class="text-sm font-semibold leading-snug">{{ session('success') }}</p>
    <button onclick="document.getElementById('flash-success').remove()" class="ml-auto text-emerald-400 hover:text-emerald-600">
        <span class="material-symbols-outlined text-lg">close</span>
    </button>
</div>
<script>setTimeout(()=>{const el=document.getElementById('flash-success');if(el)el.remove();},5000);</script>
@endif

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
<span class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Data Hari Ini</span>
</div>
<div class="flex items-center gap-3 mt-2">
<span class="flex items-center gap-1 text-secondary text-[11px] font-bold bg-secondary/10 px-2 py-0.5 rounded">
<span class="material-symbols-outlined text-sm">trending_down</span> Terlambat: {{ number_format($lateCount ?? 0) }}
                        </span>
<p class="text-sm text-on-surface-variant font-medium">Terakhir diperbarui: {{ $lastUpdate ?? now()->format('d M Y') }}</p>
</div>
</div>
</div>
<div class="flex items-center gap-md w-full lg:w-auto justify-between lg:justify-end flex-wrap">
<form method="GET" action="{{ route('admin.attendances.index') }}" class="relative">
<input name="date" onchange="this.form.submit()" class="bg-surface-container-lowest border border-outline-variant/40 rounded-xl py-3 pl-11 pr-4 text-sm font-semibold text-on-surface focus:ring-2 focus:ring-primary appearance-none cursor-pointer hover:border-primary/50 transition-all outline-none" type="date" value="{{ $selectedDate ?? date('Y-m-d') }}">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">calendar_month</span>
</form>

{{-- Tombol Tandai Absen Manual --}}
<button onclick="document.getElementById('modal-mark-absent').classList.remove('hidden')" class="flex items-center gap-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold px-4 py-3 rounded-xl shadow-lg active:scale-95 transition-all">
    <span class="material-symbols-outlined text-lg">person_off</span>
    <span class="hidden sm:inline">Tandai Absen</span>
</button>
</div>
</div>
<div class="grid grid-cols-12 gap-xl">
<!-- Refined Attendance Table -->
<section class="col-span-12">
<div class="bg-white rounded-2xl border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col h-full">
<div class="px-xl py-lg border-b border-outline-variant/20 flex justify-between items-center">
<div>
<h3 class="text-xl font-bold text-primary">Status Absensi Langsung</h3>
<p class="text-xs text-on-surface-variant mt-0.5">Log real-time untuk semua mahasiswa terdaftar</p>
</div>
<button class="text-sm font-bold px-4 py-2 rounded-xl border border-outline-variant/30 hover:bg-surface-container transition-all text-on-surface-variant flex items-center gap-2">
<span class="material-symbols-outlined text-lg">ios_share</span> Ekspor
                        </button>
</div>
<div class="overflow-x-auto flex-1">
<table class="w-full text-left border-collapse min-w-[700px]">
<thead>
<tr class="bg-surface-container-low/30 border-b border-outline-variant/10">
<th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline">Mahasiswa</th>
<th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline">Jurusan</th>
<th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline">Status</th>
<th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline">Jam Masuk</th>
<th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline">Jam Keluar</th>
<th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline">Durasi</th>
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
<td class="px-xl py-5">
    <div class="flex flex-col">
        <span class="text-sm font-semibold text-primary">{{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('h:i A') : '--:--' }}</span>
        @if($attendance->is_late)
            <span class="text-[9px] font-black text-rose-600 bg-rose-50 border border-rose-100 px-1.5 py-0.5 rounded uppercase tracking-wider w-max mt-1">Terlambat</span>
        @elseif($attendance->check_in_time)
            <span class="text-[9px] font-black text-emerald-600 bg-emerald-50 border border-emerald-100 px-1.5 py-0.5 rounded uppercase tracking-wider w-max mt-1">Tepat Waktu</span>
        @endif
        @if($attendance->check_in_latitude && $attendance->check_in_longitude)
            <span class="inline-flex items-center gap-0.5 text-[10px] text-on-surface-variant/70 mt-1.5 font-medium location-name"
                data-lat="{{ $attendance->check_in_latitude }}"
                data-lng="{{ $attendance->check_in_longitude }}">
                <span class="material-symbols-outlined text-[11px] text-outline">location_on</span>
                <span class="loc-text italic">Memuat lokasi...</span>
            </span>
            <a href="https://www.google.com/maps?q={{ $attendance->check_in_latitude }},{{ $attendance->check_in_longitude }}" target="_blank" class="inline-flex items-center gap-0.5 text-[10px] text-primary/70 hover:text-primary hover:underline font-semibold">
                <span class="material-symbols-outlined text-[11px]">open_in_new</span> Maps
            </a>
        @endif
    </div>
</td>
<td class="px-xl py-5">
    <div class="flex flex-col">
        <span class="text-sm font-semibold text-primary">{{ $attendance->check_out_time ? \Carbon\Carbon::parse($attendance->check_out_time)->format('h:i A') : '--:--' }}</span>
        @if($attendance->is_early_checkout)
            <span class="text-[9px] font-black text-amber-600 bg-amber-50 border border-amber-100 px-1.5 py-0.5 rounded uppercase tracking-wider w-max mt-1">Pulang Cepat</span>
        @elseif($attendance->check_out_time)
            <span class="text-[9px] font-black text-emerald-600 bg-emerald-50 border border-emerald-100 px-1.5 py-0.5 rounded uppercase tracking-wider w-max mt-1">Tepat Waktu</span>
        @endif
        @if($attendance->check_out_latitude && $attendance->check_out_longitude)
            <span class="inline-flex items-center gap-0.5 text-[10px] text-on-surface-variant/70 mt-1.5 font-medium location-name"
                data-lat="{{ $attendance->check_out_latitude }}"
                data-lng="{{ $attendance->check_out_longitude }}">
                <span class="material-symbols-outlined text-[11px] text-outline">location_on</span>
                <span class="loc-text italic">Memuat lokasi...</span>
            </span>
            <a href="https://www.google.com/maps?q={{ $attendance->check_out_latitude }},{{ $attendance->check_out_longitude }}" target="_blank" class="inline-flex items-center gap-0.5 text-[10px] text-primary/70 hover:text-primary hover:underline font-semibold">
                <span class="material-symbols-outlined text-[11px]">open_in_new</span> Maps
            </a>
        @endif
    </div>
</td>
<td class="px-xl py-5 text-sm font-medium text-on-surface-variant">
    @if($attendance->check_in_time && $attendance->check_out_time)
        @php
            $checkIn = \Carbon\Carbon::parse($attendance->check_in_time);
            $checkOut = \Carbon\Carbon::parse($attendance->check_out_time);
            $duration = $checkIn->diff($checkOut);
            $hours = $duration->h;
            $minutes = $duration->i;
            $durationStr = "";
            if ($hours > 0) {
                $durationStr .= "{$hours}j ";
            }
            $durationStr .= "{$minutes}m";
        @endphp
        {{ $durationStr }}
    @else
        -
    @endif
</td>
<td class="px-xl py-5 text-center">
<button class="w-8 h-8 rounded-full flex items-center justify-center text-outline hover:text-primary hover:bg-primary/10 transition-all">
<span class="material-symbols-outlined text-xl">more_horiz</span>
</button>
</td>
</tr>
@empty
<tr>
    <td colspan="7" class="px-xl py-10 text-center text-on-surface-variant">Belum ada data absensi hari ini.</td>
</tr>
@endforelse
</tbody>
</table>
</div>
<div class="px-xl py-lg flex justify-between items-center text-sm font-medium text-on-surface-variant border-t border-outline-variant/10">
<span class="">Menampilkan <span class="text-on-surface font-bold">{{ $attendances->count() }}</span> data</span>
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
</div>
</div>

{{-- Modal Konfirmasi Tandai Absen --}}
<div id="modal-mark-absent" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-md mx-4">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 rounded-2xl bg-rose-100 flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl text-rose-600">person_off</span>
            </div>
            <div>
                <h3 class="text-xl font-black text-on-surface">Tandai Siswa Absen</h3>
                <p class="text-sm text-on-surface-variant mt-0.5">Proses dilakukan untuk tanggal yang dipilih</p>
            </div>
        </div>

        <div class="bg-rose-50 border border-rose-100 rounded-xl p-4 mb-6">
            <p class="text-sm text-rose-800 font-medium leading-relaxed">
                Sistem akan menandai semua mahasiswa aktif yang <strong>belum memiliki record absensi</strong> pada tanggal ini sebagai:
            </p>
            <ul class="mt-2 space-y-1 text-sm text-rose-700 font-semibold">
                <li class="flex items-center gap-2"><span class="material-symbols-outlined text-base">close</span> <strong>ABSEN</strong> &mdash; jika tidak punya izin approved</li>
                <li class="flex items-center gap-2"><span class="material-symbols-outlined text-base">event_busy</span> <strong>IZIN</strong> &mdash; jika punya Leave Request approved</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('admin.attendances.mark_absent') }}">
            @csrf
            <input type="hidden" name="date" value="{{ $selectedDate ?? date('Y-m-d') }}">
            <div class="mb-4">
                <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-1">Tanggal Target</label>
                <p class="text-base font-black text-primary">
                    {{ \Carbon\Carbon::parse($selectedDate ?? date('Y-m-d'))->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="document.getElementById('modal-mark-absent').classList.add('hidden')" class="flex-1 border border-outline-variant/40 text-on-surface-variant font-bold py-3 rounded-xl hover:bg-surface-container transition-all">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-rose-600 hover:bg-rose-700 text-white font-black py-3 rounded-xl shadow-lg active:scale-95 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-lg">check</span> Ya, Tandai Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
/**
 * Reverse Geocoding menggunakan Nominatim (OpenStreetMap)
 * - Cache hasil di sessionStorage agar tidak request ulang koordinat yang sama
 * - Rate limit: antrian 1 request per 1.1 detik (sesuai ToS Nominatim)
 */
(function () {
    const CACHE_PREFIX = 'geocache_';
    const queue = [];
    let isProcessing = false;

    function getCacheKey(lat, lng) {
        // Bulatkan ke 4 desimal (~11m akurasi) untuk cache hit lebih baik
        return CACHE_PREFIX + parseFloat(lat).toFixed(4) + ',' + parseFloat(lng).toFixed(4);
    }

    function setCache(key, value) {
        try { sessionStorage.setItem(key, value); } catch (e) {}
    }

    function getCache(key) {
        try { return sessionStorage.getItem(key); } catch (e) { return null; }
    }

    function formatAddress(data) {
        const a = data.address || {};
        // Prioritaskan nama tempat yang paling deskriptif
        const place = a.amenity || a.shop || a.tourism || a.leisure ||
                      a.building || a.office || a.name || null;
        const road  = a.road || a.pedestrian || a.footway || a.path || null;
        const area  = a.suburb || a.neighbourhood || a.village ||
                      a.town || a.city_district || a.city || null;

        let parts = [];
        if (place) parts.push(place);
        else if (road) parts.push(road);
        if (area && area !== place) parts.push(area);

        return parts.length > 0 ? parts.join(', ') : (data.display_name || 'Lokasi tidak diketahui');
    }

    async function fetchLocation(lat, lng) {
        const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;
        const resp = await fetch(url, {
            headers: { 'Accept-Language': 'id,en' }
        });
        if (!resp.ok) throw new Error('Nominatim error');
        return resp.json();
    }

    function processQueue() {
        if (isProcessing || queue.length === 0) return;
        isProcessing = true;

        const { lat, lng, elements } = queue.shift();
        const cacheKey = getCacheKey(lat, lng);

        fetchLocation(lat, lng)
            .then(data => {
                const label = formatAddress(data);
                setCache(cacheKey, label);
                elements.forEach(el => {
                    el.querySelector('.loc-text').textContent = label;
                    el.querySelector('.loc-text').classList.remove('italic');
                });
            })
            .catch(() => {
                elements.forEach(el => {
                    el.querySelector('.loc-text').textContent = 'Lokasi tidak tersedia';
                });
            })
            .finally(() => {
                isProcessing = false;
                // Rate limit: 1.1 detik antar request
                setTimeout(processQueue, 1100);
            });
    }

    function enqueue(lat, lng, el) {
        const cacheKey = getCacheKey(lat, lng);
        const cached   = getCache(cacheKey);

        if (cached) {
            // Langsung tampilkan dari cache
            el.querySelector('.loc-text').textContent = cached;
            el.querySelector('.loc-text').classList.remove('italic');
            return;
        }

        // Cek apakah koordinat ini sudah ada di antrian
        const existing = queue.find(q =>
            parseFloat(q.lat).toFixed(4) === parseFloat(lat).toFixed(4) &&
            parseFloat(q.lng).toFixed(4) === parseFloat(lng).toFixed(4)
        );

        if (existing) {
            existing.elements.push(el);
        } else {
            queue.push({ lat, lng, elements: [el] });
        }

        processQueue();
    }

    // Inisiasi semua elemen .location-name
    document.querySelectorAll('.location-name').forEach(el => {
        const lat = el.dataset.lat;
        const lng = el.dataset.lng;
        if (lat && lng) enqueue(lat, lng, el);
    });
})();
</script>
@endpush

@endsection
