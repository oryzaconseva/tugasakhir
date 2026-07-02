<!-- Desktop Sidebar -->
<aside class="hidden md:flex flex-col h-[calc(100vh-80px)] w-72 bg-slate-50 dark:bg-slate-950 p-4 gap-2 sticky top-20 rounded-r-3xl shadow-2xl shadow-blue-900/5">
<div class="px-4 py-6 mb-4">
<h2 class="text-lg font-black text-blue-700 font-headline">Academic Atelier</h2>
<p class="text-xs text-slate-500 font-medium">Institutional Portal</p>
</div>
<nav class="flex flex-col gap-1">
<a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:translate-x-1 transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-l-4 border-blue-600' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}" href="{{ route('admin.dashboard') }}">
<span class="material-symbols-outlined">dashboard</span>
<span class="font-manrope text-sm font-medium">Dashboard</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:translate-x-1 transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('admin.students.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-l-4 border-blue-600' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}" href="{{ route('admin.students.index') }}">
<span class="material-symbols-outlined">group</span>
<span class="font-manrope text-sm font-medium">Data Mahasiswa</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:translate-x-1 transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('admin.attendance_qrs.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-l-4 border-blue-600' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}" href="{{ route('admin.attendance_qrs.index') }}">
<span class="material-symbols-outlined">qr_code_scanner</span>
<span class="font-manrope text-sm font-medium">QR Absensi</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:translate-x-1 transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('admin.tasks.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-l-4 border-blue-600' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}" href="{{ route('admin.tasks.index') }}">
<span class="material-symbols-outlined">assignment</span>
<span class="font-manrope text-sm font-medium">Task Management</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:translate-x-1 transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('admin.attendances.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-l-4 border-blue-600' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}" href="{{ route('admin.attendances.index') }}">
<span class="material-symbols-outlined">calendar_today</span>
<span class="font-manrope text-sm font-medium">Data Absensi</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:translate-x-1 transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('admin.daily_activities.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-l-4 border-blue-600' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}" href="{{ route('admin.daily_activities.index') }}">
<span class="material-symbols-outlined">monitoring</span>
<span class="font-manrope text-sm font-medium">Monitoring Aktivitas</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:translate-x-1 transition-all duration-200 active:scale-[0.98] {{ request()->routeIs('admin.leave_requests.*') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-l-4 border-blue-600' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}" href="{{ route('admin.leave_requests.index') }}">
<span class="material-symbols-outlined">assignment_turned_in</span>
<span class="font-manrope text-sm font-medium">Pengajuan Izin</span>
</a>
</nav>
</aside>
