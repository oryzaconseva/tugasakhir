@extends('layouts.admin')

@section('content')
<!-- Main Content Shell -->

<!-- TopAppBar (Shared Component) -->

<!-- Canvas Area -->
<section class="flex-1 p-12 flex flex-col items-center justify-center relative overflow-hidden">
<!-- Background Decorative Elements -->
<div class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
<div class="absolute bottom-0 left-0 w-64 h-64 bg-secondary/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
<div class="w-full max-w-4xl grid md:grid-cols-5 gap-12 items-center relative z-10">
<!-- Left: Session Details -->
<div class="md:col-span-2 space-y-8 order-2 md:order-1">
<div class="space-y-2">
<span class="inline-block px-3 py-1 bg-secondary-fixed text-on-secondary-fixed-variant text-[10px] font-bold tracking-widest uppercase rounded-full">Active Session</span>
<h3 class="font-headline text-4xl font-extrabold text-on-surface tracking-tighter leading-tight">Generate Daily Presence QR</h3>
<p class="text-on-surface-variant font-body text-base">Present this code to students for the morning check-in. The session expires at the end of the day.</p>
</div>
<div class="space-y-4">
<div class="flex items-center gap-4 p-4 rounded-xl bg-surface-container transition-all hover:bg-surface-container-high group">
<div class="w-12 h-12 rounded-full bg-surface-container-lowest flex items-center justify-center shadow-sm group-hover:text-primary transition-colors">
<span class="material-symbols-outlined" data-icon="calendar_month">calendar_month</span>
</div>
<div>
<p class="text-xs text-on-surface-variant font-medium">Current Date</p>
<p class="text-on-surface font-semibold font-headline">{{ now()->translatedFormat('l, d F Y') }}</p>
</div>
</div>
<div class="flex items-center gap-4 p-4 rounded-xl bg-surface-container transition-all hover:bg-surface-container-high group">
<div class="w-12 h-12 rounded-full bg-surface-container-lowest flex items-center justify-center shadow-sm group-hover:text-primary transition-colors">
<span class="material-symbols-outlined" data-icon="schedule">schedule</span>
</div>
<div>
<p class="text-xs text-on-surface-variant font-medium">Session Window</p>
<p class="text-on-surface font-semibold font-headline">08:00 AM - 17:00 PM</p>
</div>
</div>
</div>
<form action="{{ route('admin.attendance_qrs.generate') }}" method="POST">
    @csrf
    <button type="submit" class="w-full py-4 px-6 bg-primary text-on-primary font-bold rounded-xl flex items-center justify-center gap-3 transition-all hover:shadow-lg hover:shadow-primary/20 active:scale-[0.98]">
    <span class="material-symbols-outlined" data-icon="refresh">refresh</span>
                            Regenerate Secure Token
                        </button>
</form>
</div>
<!-- Right: QR Generator View -->
<div class="md:col-span-3 flex flex-col items-center order-1 md:order-2">
<div class="w-full aspect-square max-w-[400px] bg-surface-container-lowest rounded-full p-8 shadow-[0_20px_60px_-15px_rgba(31,94,155,0.12)] relative group">
<!-- Scanning Frame Decoration -->
<div class="absolute inset-4 border-2 border-primary/20 rounded-full animate-pulse pointer-events-none"></div>
<div class="absolute inset-0 qr-gradient-glow rounded-full"></div>
<!-- QR Content Area -->
<div class="w-full h-full bg-white rounded-full flex items-center justify-center p-12 relative overflow-hidden">
<div class="relative w-full h-full bg-white flex items-center justify-center">
<!-- QR Generating Here -->
@if($latestQr)
    <img alt="Dynamic QR Code" class="w-full h-auto relative z-10 mix-blend-multiply opacity-90" src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode($latestQr->qr_data) }}"/>
@else
    <div class="text-center text-sm text-on-surface-variant z-10">No token created today. Regnerate token below.</div>
@endif
<!-- Decorative corners for scanning feel -->
<div class="absolute top-0 left-0 w-6 h-6 border-t-2 border-l-2 border-primary rounded-tl-lg"></div>
<div class="absolute top-0 right-0 w-6 h-6 border-t-2 border-r-2 border-primary rounded-tr-lg"></div>
<div class="absolute bottom-0 left-0 w-6 h-6 border-b-2 border-l-2 border-primary rounded-bl-lg"></div>
<div class="absolute bottom-0 right-0 w-6 h-6 border-b-2 border-r-2 border-primary rounded-br-lg"></div>
<div class="scanning-line"></div>
</div>
</div>
<!-- Floating Feedback -->
<div class="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-white px-6 py-3 rounded-full shadow-lg flex items-center gap-3 border border-outline-variant/20 whitespace-nowrap">
<div class="flex gap-1">
<span class="w-2 h-2 rounded-full bg-secondary animate-bounce"></span>
<span class="w-2 h-2 rounded-full bg-secondary animate-bounce [animation-delay:0.2s]"></span>
<span class="w-2 h-2 rounded-full bg-secondary animate-bounce [animation-delay:0.4s]"></span>
</div>
<span class="text-xs font-bold font-headline text-on-surface">{{ $latestQr ? 'Broadcasting Token...' : 'Waiting Generator...' }}</span>
</div>
</div>
<div class="mt-16 w-full grid grid-cols-2 gap-4">
<div class="p-4 rounded-2xl bg-surface-container-lowest border border-outline-variant/10 text-center">
<p class="text-display-sm font-headline text-2xl font-extrabold text-primary">{{ $todayScannedCount }}</p>
<p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-wider">Students Scanned</p>
</div>
<div class="p-4 rounded-2xl bg-surface-container-lowest border border-outline-variant/10 text-center">
<p class="text-display-sm font-headline text-2xl font-extrabold text-secondary">{{ now()->format('H:i') }}</p>
<p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-wider">Live Time</p>
</div>
</div>
</div>
</div>
</section>
<!-- Footer / Branding -->
<footer class="px-12 py-6 flex justify-between items-center text-[10px] text-on-surface-variant font-medium tracking-wide uppercase">
<div class="flex items-center gap-6">
<span>© 2024 InternSync Workspace</span>
<span class="w-1 h-1 bg-outline-variant rounded-full"></span>
<span>Version 2.4.0-Stable</span>
</div>
<div class="flex items-center gap-4">
<a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
<a class="hover:text-primary transition-colors" href="#">Support Center</a>
</div>
</footer>

@endsection
