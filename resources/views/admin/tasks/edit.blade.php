@extends('layouts.admin')

@section('title', 'Edit Task | InternSync')

@section('content')
<div class="flex-1 p-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 mb-8 text-sm">
        <a href="{{ route('admin.tasks.index') }}" class="text-on-surface-variant hover:text-primary transition-colors">Task Management</a>
        <span class="material-symbols-outlined text-sm text-outline-variant">chevron_right</span>
        <span class="text-primary font-bold">Edit Task</span>
    </nav>
    
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h1 class="text-4xl font-extrabold text-on-surface tracking-tight mb-2">Edit Task Details</h1>
                <p class="text-on-surface-variant max-w-md">Refine the objectives and timeline for this individual assignment.</p>
            </div>
            <div class="flex items-center gap-3">
                <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Hapus tugas ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 rounded-full bg-error text-white font-bold text-sm transition-all hover:shadow-lg hover:shadow-error/20 active:scale-95 flex items-center">
                        <span class="material-symbols-outlined mr-2 text-sm">delete</span>
                        Hapus Task
                    </button>
                </form>
            </div>
        </div>

        <!-- Form errors -->
        @if ($errors->any())
            <div class="bg-error-container text-on-error-container p-4 rounded-xl mb-6">
                <ul class="list-disc ml-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Section (Floating Card Style) -->
        <div class="bg-surface-container-lowest rounded-3xl p-8 shadow-[0_20px_40px_rgba(25,28,30,0.04)]">
            <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @csrf
                @method('PUT')
                
                <!-- Title Field -->
                <div class="md:col-span-2 space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant ml-1">Task Title</label>
                    <input name="title" value="{{ old('title', $task->title) }}" required class="w-full bg-surface-container-low border-none rounded-xl px-6 py-4 focus:ring-2 focus:ring-primary/20 text-on-surface font-semibold placeholder:text-outline-variant transition-all" placeholder="Enter task name..." type="text"/>
                </div>
                
                <!-- Description Field -->
                <div class="md:col-span-2 space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant ml-1">Project Description</label>
                    <textarea name="description" required class="w-full bg-surface-container-low border-none rounded-xl px-6 py-4 focus:ring-2 focus:ring-primary/20 text-on-surface font-medium placeholder:text-outline-variant transition-all resize-none" rows="4">{{ old('description', $task->description) }}</textarea>
                </div>
                
                <!-- Deadline Field -->
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant ml-1">Deadline Date</label>
                    <div class="relative">
                        <input name="due_date" value="{{ old('due_date', \Carbon\Carbon::parse($task->due_date)->format('Y-m-d')) }}" required class="w-full bg-surface-container-low border-none rounded-xl px-6 py-4 focus:ring-2 focus:ring-primary/20 text-on-surface font-semibold transition-all" type="date"/>
                    </div>
                </div>
                
                <!-- Status Field -->
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant ml-1">Execution Status</label>
                    <select name="status" required class="w-full bg-surface-container-low border-none rounded-xl px-6 py-4 focus:ring-2 focus:ring-primary/20 text-on-surface font-semibold transition-all">
                        <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>On Progress</option>
                        <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <!-- Priority Field -->
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant ml-1">Priority</label>
                    <select name="priority" required class="w-full bg-surface-container-low border-none rounded-xl px-6 py-4 focus:ring-2 focus:ring-primary/20 text-on-surface font-semibold transition-all">
                        <option value="normal" {{ old('priority', $task->priority) == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ old('priority', $task->priority) == 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </div>
                
                <!-- Task File Upload -->
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant ml-1">Task Attachment (PDF/ZIP)</label>
                    <input name="task_file" class="w-full bg-surface-container-low border-none rounded-xl px-6 py-4 focus:ring-2 focus:ring-primary/20 text-on-surface transition-all" type="file" accept=".pdf,.zip"/>
                    @if($task->task_file)
                        <div class="mt-2 text-xs font-medium text-primary flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">attachment</span>
                            <a href="{{ asset('storage/' . $task->task_file) }}" target="_blank" class="hover:underline">View Current Attachment</a>
                        </div>
                    @endif
                </div>
                
                <!-- Student Task Proof -->
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant ml-1">Student Proof of Work</label>
                    @if($task->task_proof)
                        <div class="w-full bg-teal-50 border border-teal-200 rounded-xl px-6 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-teal-600">check_circle</span>
                                <span class="text-sm font-semibold text-teal-950">Submitted Proof</span>
                            </div>
                            <a href="{{ asset('storage/' . $task->task_proof) }}" target="_blank" class="text-xs font-bold text-teal-700 hover:underline flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">download</span>
                                Download Bukti
                            </a>
                        </div>
                    @else
                        <div class="w-full bg-surface-container-low border border-dashed border-outline-variant rounded-xl px-6 py-4 flex items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-sm">info</span>
                            <span class="text-xs font-medium">No proof uploaded yet</span>
                        </div>
                    @endif
                </div>
                
                <!-- Assigned Members (Readonly box) -->
                <div class="md:col-span-2 space-y-4 pt-4">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Assigned Intern (Immutable)</label>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-center p-4 bg-surface-container-low rounded-xl group transition-all">
                            <div class="w-12 h-12 rounded-full overflow-hidden mr-4 border-2 border-white shadow-sm flex items-center justify-center bg-primary text-white font-bold text-lg">
                                {{ strtoupper(substr($task->student->name ?? '?', 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-on-surface">{{ $task->student->name ?? 'Unknown Student' }}</p>
                                <p class="text-[10px] text-on-surface-variant font-medium">NIM: {{ $task->student->nim ?? '-' }}</p>
                            </div>
                            <!-- Lock icon indicating unchangeable -->
                            <span class="material-symbols-outlined text-outline-variant text-[18px]">lock</span>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="md:col-span-2 pt-10 flex flex-col sm:flex-row items-center justify-end gap-4 border-t border-outline-variant/10">
                    <a href="{{ route('admin.tasks.index') }}" class="w-full sm:w-auto px-8 py-4 text-center rounded-full text-sm font-bold text-on-surface-variant hover:bg-surface-container-high transition-all">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-10 py-4 rounded-full bg-primary text-white text-sm font-bold shadow-xl shadow-primary/20 hover:shadow-2xl hover:shadow-primary/30 transition-all active:scale-95 flex items-center justify-center">
                        <span class="material-symbols-outlined mr-2 text-lg">check_circle</span>
                        Update Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
