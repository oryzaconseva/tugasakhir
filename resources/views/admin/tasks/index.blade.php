@extends('layouts.admin')
@section('content')

<!-- Top Bar -->
<!-- Content Area -->
<div class="space-y-xl w-full">
<!-- Page Header & Stats Bento -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-md">
<div class="lg:col-span-2 flex flex-col justify-center">
<h2 class="font-headline-lg text-headline-lg text-primary mb-1">Manajemen Tugas Magang</h2>
<p class="font-body-md text-body-md text-on-surface-variant">Pantau kemajuan harian dan berikan umpan balik kepada kelompok mahasiswa Anda.</p>
</div>
<div class="bg-surface-container-lowest p-md rounded-xl shadow-sm border border-outline-variant flex items-center gap-md">
<div class="w-12 h-12 bg-primary-container/10 rounded-full flex items-center justify-center text-primary">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">pending_actions</span>
</div>
<div>
<p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Perlu Ditinjau</p>
<p class="font-headline-md text-headline-md text-primary">{{ $pendingTasksCount ?? 0 }} Tugas</p>
</div>
</div>
<div class="bg-surface-container-lowest p-md rounded-xl shadow-sm border border-outline-variant flex items-center gap-md">
<div class="w-12 h-12 bg-secondary/10 rounded-full flex items-center justify-center text-secondary">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">bolt</span>
</div>
<div>
<p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Total Tugas</p>
<p class="font-headline-md text-headline-md text-secondary font-bold">{{ $totalTasksCount ?? 0 }} Tugas</p>
</div>
</div>
</div>

@if(session('success'))
<div class="bg-primary/10 border border-primary text-primary px-4 py-3 rounded-lg relative mb-md font-body-md" role="alert">
    <span class="block sm:inline">{{ session('success') }}</span>
</div>
@endif

@if($errors->any())
<div class="bg-red-500/10 border border-red-500 text-red-600 px-4 py-3 rounded-lg relative mb-md font-body-md animate-pulse" role="alert">
    <ul class="list-disc list-inside text-sm font-semibold">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Main Table Section -->
<section class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant overflow-hidden flex flex-col">
<!-- Table Actions Bar -->
<div class="p-md border-b border-outline-variant flex flex-col sm:flex-row justify-between items-center gap-md glass-effect">
<form method="GET" action="{{ route('admin.tasks.index') }}" class="flex items-center gap-sm w-full sm:w-auto">
<div class="relative w-full sm:w-80">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-body-md">search</span>
<input name="search" value="{{ request('search') }}" class="w-full bg-background border border-outline-variant rounded-lg pl-10 pr-md py-2 text-body-md focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none transition-all" placeholder="Cari nama atau judul tugas..." type="text">
</div>
<select name="status" onchange="this.form.submit()" class="bg-background border border-outline-variant px-3 py-2 rounded-lg text-on-surface-variant hover:bg-surface-container transition-all font-label-md text-label-md outline-none cursor-pointer appearance-none">
<option value="all">Semua Status</option>
<option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
<option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
<option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
</select>
<button type="submit" class="hidden">Search</button>
</form>
<div class="flex items-center gap-sm w-full sm:w-auto">
<button onclick="openAssignModal()" class="flex-1 sm:flex-none px-md py-2 bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:shadow-lg transition-all flex items-center justify-center gap-1.5 active:scale-95">
    <span class="material-symbols-outlined text-[18px]">add</span>
    <span>Beri Tugas</span>
</button>
</div>
</div>
<!-- Table Responsive Wrapper -->
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse min-w-[800px]">
<thead>
<tr class="bg-surface-container-low border-b border-outline-variant">
<th class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-widest w-[240px]">Nama Mahasiswa</th>
<th class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-widest">Judul Tugas</th>
<th class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-widest text-center">Prioritas</th>
<th class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-widest">Status</th>
<th class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-widest">Tenggat</th>
<th class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-widest text-right">Aksi</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant">
@forelse($tasks as $task)
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-lg py-4">
<div class="flex items-center gap-md">
<div class="w-10 h-10 rounded-full bg-slate-200 border-2 border-white shadow-sm shrink-0 overflow-hidden flex items-center justify-center font-bold text-primary">
<img alt="Intern Avatar" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($task->student->name ?? 'Unknown') }}&background=EBF4FF&color=1F5E9B">
</div>
<div>
<p class="font-body-md text-body-md font-semibold text-primary">{{ $task->student->name ?? 'Unknown Student' }}</p>
<p class="text-[11px] text-on-surface-variant">{{ $task->student->major ?? '-' }}</p>
</div>
</div>
</td>
<td class="px-lg py-4">
<p class="font-body-md text-body-md text-on-surface leading-snug font-semibold">{{ $task->title }}</p>
@if($task->progress_notes)
    <div class="mt-1.5 p-2 bg-slate-50 border border-slate-200/60 rounded-lg text-xs text-on-surface-variant flex items-start gap-1.5 max-w-[320px]">
        <span class="material-symbols-outlined text-[16px] text-slate-500 shrink-0 mt-0.5">description</span>
        <div class="break-all">
            <span class="font-bold block mb-0.5 text-slate-700">Catatan Progres:</span>
            @if(filter_var($task->progress_notes, FILTER_VALIDATE_URL) || preg_match('/^https?:\/\/\S+$/', trim($task->progress_notes)))
                <a href="{{ trim($task->progress_notes) }}" target="_blank" class="text-primary hover:underline font-semibold inline-flex items-center gap-0.5">
                    <span>{{ trim($task->progress_notes) }}</span>
                    <span class="material-symbols-outlined text-[12px]">open_in_new</span>
                </a>
            @else
                <span class="font-medium text-slate-600">{{ $task->progress_notes }}</span>
            @endif
        </div>
    </div>
@endif
@if($task->task_proof)
    <div class="mt-1.5 p-2 bg-blue-50 border border-blue-200/60 rounded-lg text-xs text-blue-900 flex items-start gap-1.5 max-w-[320px]">
        <span class="material-symbols-outlined text-[16px] text-blue-600 shrink-0 mt-0.5">download</span>
        <div class="break-all flex-1">
            <span class="font-bold block mb-0.5 text-blue-800">Bukti Pekerjaan:</span>
            <a href="{{ asset('storage/' . $task->task_proof) }}" target="_blank" class="text-blue-700 hover:underline font-semibold inline-flex items-center gap-0.5">
                <span>Download Bukti</span>
                <span class="material-symbols-outlined text-[12px]">open_in_new</span>
            </a>
        </div>
    </div>
@endif
</td>
<td class="px-lg py-4 text-center">
    @if(($task->priority ?? 'normal') === 'urgent')
        <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-800 text-[10px] font-bold uppercase tracking-wider">Urgent</span>
    @elseif(($task->priority ?? 'normal') === 'high')
        <span class="inline-block px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold uppercase tracking-wider">High</span>
    @else
        <span class="inline-block px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-[10px] font-bold uppercase tracking-wider">Normal</span>
    @endif
</td>
<td class="px-lg py-4">
<div class="flex items-center gap-sm">
    @if($task->status == 'completed')
        <div class="w-2 h-2 rounded-full bg-green-500"></div>
        <span class="font-body-md text-body-md text-on-surface-variant">Selesai</span>
    @elseif($task->status == 'in_progress')
        <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
        <span class="font-body-md text-body-md text-on-surface-variant">Sedang Dikerjakan</span>
    @else
        <div class="w-2 h-2 rounded-full bg-amber-500"></div>
        <span class="font-body-md text-body-md text-on-surface-variant">Menunggu</span>
    @endif
</div>
</td>
<td class="px-lg py-4">
<span class="font-label-md text-label-md text-on-surface-variant">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</span>
</td>
<td class="px-lg py-4 text-right">
<div class="flex items-center justify-end gap-2">
<button type="button" 
    class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-primary-fixed rounded transition-colors edit-task-btn" 
    title="Edit Task"
    data-id="{{ $task->id }}"
    data-title="{{ $task->title }}"
    data-description="{{ $task->description }}"
    data-due-date="{{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}"
    data-status="{{ $task->status }}"
    data-priority="{{ $task->priority }}"
    data-task-file="{{ $task->task_file }}"
    data-task-proof="{{ $task->task_proof }}"
    data-student-name="{{ $task->student->name ?? '' }}"
    data-student-nim="{{ $task->student->nim ?? '' }}"
>
    <span class="material-symbols-outlined text-[20px]">edit</span>
</button>
<button type="button"
    onclick="openDeleteTaskModal('{{ $task->id }}', '{{ addslashes($task->title) }}')"
    class="p-1.5 text-on-surface-variant hover:text-red-500 hover:bg-red-50 rounded transition-all"
    title="Hapus Tugas">
    <span class="material-symbols-outlined text-[20px]">delete</span>
</button>
</div>
</td>
</tr>
@empty
<tr>
<td colspan="6" class="px-lg py-12 text-center text-on-surface-variant">
    Belum ada tugas yang diberikan.
</td>
</tr>
@endforelse
</tbody>
</table>
</div>
<!-- Pagination -->
<div class="px-lg py-md bg-surface-container-low flex justify-between items-center border-t border-outline-variant">
<p class="font-label-md text-label-md text-on-surface-variant">Menampilkan {{ method_exists($tasks, 'total') ? $tasks->total() : $tasks->count() }} tugas</p>
<div class="flex items-center gap-sm">
    @if(method_exists($tasks, 'hasPages') && $tasks->hasPages())
        {{ $tasks->links('pagination::tailwind') }}
    @else
        <button class="p-2 border border-outline-variant rounded-md hover:bg-white disabled:opacity-30" disabled="">
        <span class="material-symbols-outlined text-[20px]">chevron_left</span>
        </button>
        <button class="w-8 h-8 flex items-center justify-center rounded-md bg-primary text-on-primary font-label-md text-label-md">1</button>
        <button class="p-2 border border-outline-variant rounded-md hover:bg-white">
        <span class="material-symbols-outlined text-[20px]">chevron_right</span>
        </button>
    @endif
</div>
</div>
</section>
<!-- Feedback Quick View -->
<section class="grid grid-cols-1 md:grid-cols-3 gap-lg">
<div class="md:col-span-2 bg-surface-container-lowest rounded-xl p-lg shadow-sm border border-outline-variant">
<div class="flex justify-between items-center mb-md">
<h3 class="font-headline-md text-headline-md text-primary">Riwayat Umpan Balik Terbaru</h3>
<button class="text-primary font-label-md text-label-md hover:underline">Lihat Semua Aktivitas</button>
</div>
<div class="space-y-md">
<!-- Example Feedback data -->
@foreach($studentsProgress->take(2) as $student)
    <div class="flex gap-md p-md bg-background rounded-lg border-l-4 border-green-500">
    <span class="material-symbols-outlined text-green-500">check_circle</span>
    <div>
    <p class="font-body-md text-body-md font-semibold text-primary">Mahasiswa Dievaluasi</p>
    <p class="font-body-md text-body-md text-on-surface-variant">{{ $student->name }} - Melacak penyelesaian {{ $student->completed_tasks_count }} tugas sejauh ini.</p>
    <p class="text-[11px] text-outline mt-1">Baru-baru ini</p>
    </div>
    </div>
@endforeach
</div>
</div>
<!-- Performance Overview Widget -->
<div class="bg-primary-container text-on-primary-container p-lg rounded-xl shadow-xl flex flex-col justify-between overflow-hidden relative">
<div class="z-10">
<h3 class="font-headline-md text-headline-md font-bold mb-1">Performa Batch</h3>
<p class="opacity-80 font-label-md text-label-md">Progres Sprint Saat Ini</p>
<div class="mt-lg">
<div class="flex justify-between font-label-md text-label-md mb-2">
<span class="">Penyelesaian Target Sprint</span>
<span class="">{{ $pendingTasksCount ? min(100, round((($totalTasksCount - $pendingTasksCount) / max(1, $totalTasksCount)) * 100)) : 100 }}%</span>
</div>
<div class="w-full bg-white/20 h-2 rounded-full">
<div class="bg-white h-full rounded-full" style="width: {{ $pendingTasksCount ? min(100, round((($totalTasksCount - $pendingTasksCount) / max(1, $totalTasksCount)) * 100)) : 100 }}%;"></div>
</div>
</div>
<div class="mt-lg grid grid-cols-2 gap-sm">
<div class="p-sm bg-white/10 rounded-lg">
<p class="text-[10px] uppercase opacity-70">Selesai</p>
<p class="text-xl font-bold">{{ $totalTasksCount - $pendingTasksCount }}</p>
</div>
<div class="p-sm bg-white/10 rounded-lg">
<p class="text-[10px] uppercase opacity-70">Ditinjau/Menunggu</p>
<p class="text-xl font-bold">{{ $pendingTasksCount }}</p>
</div>
</div>
</div>
<!-- Abstract Design Element -->
<div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
</div>
<!-- Assign Task Modal -->
<div id="assignTaskModal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div onclick="closeAssignModal()" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300"></div>
    
    <!-- Modal Box -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[calc(100%-2rem)] sm:w-full sm:max-w-lg bg-white rounded-2xl border border-outline-variant shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="assignModalBox">
        <!-- Header -->
        <div class="px-lg py-md bg-slate-50 border-b border-outline-variant flex justify-between items-center">
            <h3 class="font-headline-md text-[18px] font-bold text-primary flex items-center gap-2">
                <span class="material-symbols-outlined text-[22px] text-primary">add_task</span>
                <span>Beri Tugas Baru</span>
            </h3>
            <button onclick="closeAssignModal()" class="w-8 h-8 rounded-full hover:bg-slate-200 flex items-center justify-center text-outline transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        
        <!-- Form -->
        <form action="{{ route('admin.tasks.store') }}" method="POST" enctype="multipart/form-data" class="p-lg space-y-md m-0">
            @csrf
            
            <!-- Task Title -->
            <div class="space-y-1">
                <label for="task_title" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Judul Tugas</label>
                <input type="text" name="title" id="task_title" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="e.g. Redesign fitur profile">
            </div>
            
            <!-- Assign To -->
            <div class="space-y-1">
                <label for="task_assign_to" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Ditugaskan Ke</label>
                <div class="relative">
                    <select name="student_ids[]" id="task_assign_to" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all cursor-pointer appearance-none">
                        <option value="" disabled selected>Pilih Mahasiswa...</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->nim }})</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">arrow_drop_down</span>
                </div>
            </div>
            
            <!-- Due Date & Priority Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                <!-- Due Date -->
                <div class="space-y-1">
                    <label for="task_due_date" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal Tenggat</label>
                    <input type="date" name="due_date" id="task_due_date" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                </div>
                
                <!-- Priority -->
                <div class="space-y-1">
                    <label for="task_priority" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Prioritas</label>
                    <div class="relative">
                        <select name="priority" id="task_priority" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all cursor-pointer appearance-none">
                            <option value="normal">Normal</option>
                            <option value="high">Tinggi</option>
                            <option value="urgent">Mendesak</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">arrow_drop_down</span>
                    </div>
                </div>
            </div>
            
            <!-- Description -->
            <div class="space-y-1">
                <label for="task_description" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Deskripsi</label>
                <textarea name="description" id="task_description" rows="4" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all resize-none" placeholder="Detail instruksi tugas..."></textarea>
            </div>

            <!-- Task File Upload -->
            <div class="space-y-1">
                <label for="task_file" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Lampiran Tugas (PDF/ZIP)</label>
                <input type="file" name="task_file" id="task_file" accept=".pdf,.zip" class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
            </div>
            
            <!-- Footer Actions -->
            <div class="pt-sm border-t border-outline-variant flex justify-end gap-sm">
                <button type="button" onclick="closeAssignModal()" class="px-md py-2 text-slate-700 hover:bg-slate-100 rounded-lg text-sm font-semibold transition-all">Batal</button>
                <button type="submit" class="px-md py-2 bg-primary text-white hover:bg-primary-container rounded-lg text-sm font-semibold shadow-md transition-all active:scale-95">Kirim</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Task Modal -->
<div id="editTaskModal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div onclick="closeEditTaskModal()" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300"></div>
    
    <!-- Modal Box -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[calc(100%-2rem)] sm:w-full sm:max-w-lg bg-white rounded-2xl border border-outline-variant shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="editModalBox">
        <!-- Header -->
        <div class="px-lg py-md bg-slate-50 border-b border-outline-variant flex justify-between items-center">
            <h3 class="font-headline-md text-[18px] font-bold text-primary flex items-center gap-2">
                <span class="material-symbols-outlined text-[22px] text-primary">edit_square</span>
                <span>Edit Detail Tugas</span>
            </h3>
            <button onclick="closeEditTaskModal()" class="w-8 h-8 rounded-full hover:bg-slate-200 flex items-center justify-center text-outline transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        
        <!-- Form -->
        <form id="editTaskForm" method="POST" enctype="multipart/form-data" class="p-lg space-y-md m-0">
            @csrf
            @method('PUT')
            
            <!-- Task Title -->
            <div class="space-y-1">
                <label for="edit_title" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Judul Tugas</label>
                <input type="text" name="title" id="edit_title" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="e.g. Redesign fitur profile">
            </div>
            
            <!-- Due Date & Priority Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                <!-- Due Date -->
                <div class="space-y-1">
                    <label for="edit_due_date" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Tanggal Tenggat</label>
                    <input type="date" name="due_date" id="edit_due_date" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                </div>
                
                <!-- Priority -->
                <div class="space-y-1">
                    <label for="edit_priority" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Prioritas</label>
                    <div class="relative">
                        <select name="priority" id="edit_priority" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all cursor-pointer appearance-none">
                            <option value="normal">Normal</option>
                            <option value="high">Tinggi</option>
                            <option value="urgent">Mendesak</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">arrow_drop_down</span>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="space-y-1">
                <label for="edit_status" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Status Pengerjaan</label>
                <div class="relative">
                    <select name="status" id="edit_status" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all cursor-pointer appearance-none">
                        <option value="pending">Menunggu</option>
                        <option value="in_progress">Sedang Dikerjakan</option>
                        <option value="completed">Selesai</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">arrow_drop_down</span>
                </div>
            </div>
            
            <!-- Description -->
            <div class="space-y-1">
                <label for="edit_description" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Deskripsi</label>
                <textarea name="description" id="edit_description" rows="3" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all resize-none" placeholder="Detail instruksi tugas..."></textarea>
            </div>

            <!-- Task File Upload -->
            <div class="space-y-1">
                <label for="edit_task_file" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Lampiran Tugas (PDF/ZIP)</label>
                <input type="file" name="task_file" id="edit_task_file" accept=".pdf,.zip" class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                <div id="edit_current_attachment"></div>
            </div>

            <!-- Student Task Proof -->
            <div class="space-y-1">
                <label class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Bukti Pengerjaan Mahasiswa</label>
                <div id="edit_task_proof_container"></div>
            </div>

            <!-- Assigned Member (Read-only) -->
            <div class="space-y-1">
                <label class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Mahasiswa yang Ditugaskan (Tidak Dapat Diubah)</label>
                <div class="flex items-center p-3 bg-surface-container-low rounded-xl">
                    <div class="w-10 h-10 rounded-full overflow-hidden mr-3 border-2 border-white shadow-sm flex items-center justify-center bg-primary text-white font-bold text-sm" id="edit_student_avatar">
                        <span id="edit_student_avatar_text">?</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-on-surface" id="edit_student_name">Unknown Student</p>
                        <p class="text-[10px] text-on-surface-variant font-medium" id="edit_student_nim">NIM: -</p>
                    </div>
                    <span class="material-symbols-outlined text-outline-variant text-[18px]">lock</span>
                </div>
            </div>
            
            <!-- Footer Actions -->
            <div class="pt-sm border-t border-outline-variant flex justify-end gap-sm">
                <button type="button" onclick="closeEditTaskModal()" class="px-md py-2 text-slate-700 hover:bg-slate-100 rounded-lg text-sm font-semibold transition-all">Batal</button>
                <button type="submit" class="px-md py-2 bg-primary text-white hover:bg-primary-container rounded-lg text-sm font-semibold shadow-md transition-all active:scale-95">Perbarui Tugas</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Task Modal -->
<div id="deleteTaskModal" class="fixed inset-0 z-50 hidden">
    <div onclick="closeDeleteTaskModal()" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[calc(100%-2rem)] sm:w-full sm:max-w-md bg-white rounded-2xl border border-outline-variant shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="deleteTaskModalBox">
        <div class="px-lg py-md bg-red-50 border-b border-red-100 flex justify-between items-center">
            <h3 class="font-headline-md text-[18px] font-bold text-error flex items-center gap-2">
                <span class="material-symbols-outlined text-[22px] text-error">delete_forever</span>
                <span>Hapus Tugas</span>
            </h3>
            <button onclick="closeDeleteTaskModal()" class="w-8 h-8 rounded-full hover:bg-red-100 flex items-center justify-center text-outline transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <div class="p-lg">
            <div class="flex items-start gap-4 mb-lg">
                <div class="w-10 h-10 rounded-full bg-error/10 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-error text-[22px]">warning</span>
                </div>
                <div>
                    <p class="font-body-md text-body-md text-on-surface font-semibold mb-1">Apakah Anda yakin ingin menghapus tugas ini?</p>
                    <p class="font-body-md text-body-md text-on-surface-variant">Tugas <span id="deleteTaskTitle" class="font-semibold text-on-surface"></span> akan dihapus secara permanen dan tidak dapat dikembalikan.</p>
                </div>
            </div>
            <form id="deleteTaskForm" method="POST" class="m-0 p-0">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-sm">
                    <button type="button" onclick="closeDeleteTaskModal()" class="px-md py-2 text-slate-700 hover:bg-slate-100 rounded-lg text-sm font-semibold transition-all">Batal</button>
                    <button type="submit" class="px-md py-2 bg-error text-white hover:bg-red-700 rounded-lg text-sm font-semibold shadow-md transition-all active:scale-95 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">delete</span>
                        Hapus Permanen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAssignModal() {
        const modal = document.getElementById('assignTaskModal');
        const box = document.getElementById('assignModalBox');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
    
    function closeAssignModal() {
        const modal = document.getElementById('assignTaskModal');
        const box = document.getElementById('assignModalBox');
        
        box.classList.remove('scale-100', 'opacity-100');
        box.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function openEditTaskModal(task) {
        const modal = document.getElementById('editTaskModal');
        const box = document.getElementById('editModalBox');
        const form = document.getElementById('editTaskForm');
        
        // Populate inputs
        document.getElementById('edit_title').value = task.title || '';
        document.getElementById('edit_description').value = task.description || '';
        document.getElementById('edit_due_date').value = task.due_date || '';
        document.getElementById('edit_status').value = task.status || 'pending';
        document.getElementById('edit_priority').value = task.priority || 'normal';
        
        // Current attachment display
        const currentAttachmentDiv = document.getElementById('edit_current_attachment');
        if (task.task_file) {
            currentAttachmentDiv.innerHTML = `
                <div class="mt-2 text-xs font-medium text-primary flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">attachment</span>
                    <a href="/storage/${task.task_file}" target="_blank" class="hover:underline">Lihat Lampiran Saat Ini</a>
                </div>
            `;
        } else {
            currentAttachmentDiv.innerHTML = '';
        }

        // Student info (read-only)
        document.getElementById('edit_student_name').textContent = task.student_name || 'Unknown Student';
        document.getElementById('edit_student_nim').textContent = 'NIM: ' + (task.student_nim || '-');
        document.getElementById('edit_student_avatar_text').textContent = (task.student_name || '?').substring(0, 1).toUpperCase();
        
        // Task proof container
        const proofDiv = document.getElementById('edit_task_proof_container');
        if (task.task_proof) {
            proofDiv.innerHTML = `
                <div class="w-full bg-teal-50 border border-teal-200 rounded-xl px-4 py-2 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-teal-600 text-sm">check_circle</span>
                        <span class="text-xs font-semibold text-teal-950">Bukti Telah Dikumpulkan</span>
                    </div>
                    <a href="/storage/${task.task_proof}" target="_blank" class="text-xs font-bold text-teal-700 hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs">download</span>
                        Unduh Bukti
                    </a>
                </div>
            `;
        } else {
            proofDiv.innerHTML = `
                <div class="w-full bg-surface-container-low border border-dashed border-outline-variant rounded-xl px-4 py-2 flex items-center gap-2 text-on-surface-variant">
                    <span class="material-symbols-outlined text-xs">info</span>
                    <span class="text-[11px] font-medium">Belum ada bukti yang dikumpulkan</span>
                </div>
            `;
        }

        // Set Action URL
        form.action = `/admin/tasks/${task.id}`;
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
    
    function closeEditTaskModal() {
        const modal = document.getElementById('editTaskModal');
        const box = document.getElementById('editModalBox');
        
        box.classList.remove('scale-100', 'opacity-100');
        box.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.edit-task-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const task = {
                    id: this.getAttribute('data-id'),
                    title: this.getAttribute('data-title'),
                    description: this.getAttribute('data-description'),
                    due_date: this.getAttribute('data-due-date'),
                    status: this.getAttribute('data-status'),
                    priority: this.getAttribute('data-priority'),
                    task_file: this.getAttribute('data-task-file'),
                    task_proof: this.getAttribute('data-task-proof'),
                    student_name: this.getAttribute('data-student-name'),
                    student_nim: this.getAttribute('data-student-nim')
                };
                openEditTaskModal(task);
            });
        });

        // Validasi HTML5 dalam bahasa Indonesia
        const validationMessages = {
            title:       { valueMissing: 'Judul tugas wajib diisi.' },
            description: { valueMissing: 'Deskripsi tugas wajib diisi.' },
            due_date:    { valueMissing: 'Tanggal tenggat wajib diisi.' },
            priority:    { valueMissing: 'Prioritas tugas wajib dipilih.' },
            'student_ids[]': { valueMissing: 'Pilih minimal satu mahasiswa penerima tugas.' },
        };
        document.querySelectorAll('input[required], select[required], textarea[required]').forEach(input => {
            input.addEventListener('invalid', () => {
                const msg = validationMessages[input.name] || {};
                input.setCustomValidity(input.validity.valueMissing
                    ? (msg.valueMissing || 'Field ini wajib diisi.')
                    : '');
            });
            input.addEventListener('input', () => input.setCustomValidity(''));
            input.addEventListener('change', () => input.setCustomValidity(''));
        });
    });

    function openDeleteTaskModal(taskId, taskTitle) {
        const modal = document.getElementById('deleteTaskModal');
        const box = document.getElementById('deleteTaskModalBox');
        const form = document.getElementById('deleteTaskForm');
        document.getElementById('deleteTaskTitle').textContent = taskTitle;
        form.action = `/admin/tasks/${taskId}`;
        modal.classList.remove('hidden');
        setTimeout(() => {
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeDeleteTaskModal() {
        const modal = document.getElementById('deleteTaskModal');
        const box = document.getElementById('deleteTaskModalBox');
        box.classList.remove('scale-100', 'opacity-100');
        box.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { modal.classList.add('hidden'); }, 300);
    }
</script>

@endsection


