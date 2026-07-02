@extends('layouts.admin')

@section('title', 'Tambah Task | InternSync')

@section('content')
<div class="p-8 max-w-5xl w-full mx-auto space-y-8 flex-1">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-sm">
        <a href="{{ route('admin.tasks.index') }}" class="text-on-surface-variant hover:text-primary transition-colors">Task Management</a>
        <span class="material-symbols-outlined text-xs text-outline-variant" data-icon="chevron_right">chevron_right</span>
        <span class="text-primary font-semibold">Tambah Task</span>
    </nav>

    <!-- Header Section -->
    <div class="space-y-2">
        <h2 class="text-3xl font-extrabold tracking-tight text-on-surface">Tambah Task Baru</h2>
        <p class="text-on-surface-variant max-w-2xl">Lengkapi formulir di bawah ini untuk menugaskan pekerjaan baru. Anda dapat memilih lebih dari satu mahasiswa (Tahan tombol Ctrl/Cmd saat memilih).</p>
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

    <!-- Form Card: The Academic Atelier Card Style -->
    <div class="bg-surface-container-lowest rounded-xl shadow-[0_20px_40px_rgba(25,28,30,0.04)] overflow-hidden transition-all duration-300">
        <form action="{{ route('admin.tasks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-8 space-y-8">
                <!-- Form Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <!-- Task Title -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-sm font-semibold text-on-surface ml-1">Task Title <span class="text-error">*</span></label>
                        <input name="title" value="{{ old('title') }}" required class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all duration-200 placeholder:text-outline-variant" placeholder="e.g., Redesign Landing Page Dashboard" type="text"/>
                    </div>
                    
                    <!-- Description -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-sm font-semibold text-on-surface ml-1">Description <span class="text-error">*</span></label>
                        <textarea name="description" required class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all duration-200 placeholder:text-outline-variant resize-none" placeholder="Detail deskripsi tugas, ekspektasi output, dan referensi link jika ada..." rows="5">{{ old('description') }}</textarea>
                    </div>
                    
                    <!-- Deadline -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-on-surface ml-1">Deadline <span class="text-error">*</span></label>
                        <input name="due_date" value="{{ old('due_date') }}" required class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all duration-200" type="date"/>
                    </div>
                    
                    <!-- Initial Status -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-on-surface ml-1">Initial Status</label>
                        <select name="status" class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all duration-200">
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>On Progress</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <!-- Priority -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-on-surface ml-1">Priority <span class="text-error">*</span></label>
                        <select name="priority" required class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all duration-200">
                            <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                            <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                        </select>
                    </div>

                    <!-- Task File Upload -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-on-surface ml-1">Task Attachment (PDF/ZIP)</label>
                        <input name="task_file" class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all duration-200" type="file" accept=".pdf,.zip"/>
                    </div>
                    
                    <!-- Assign To (Multi-select) -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-sm font-semibold text-on-surface ml-1">Assign To <span class="text-xs font-normal text-on-surface-variant">(Tahan Ctrl/Cmd untuk memilih beberapa)</span> <span class="text-error">*</span></label>
                        <select name="student_ids[]" multiple required class="w-full h-48 px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all duration-200">
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->nim }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-6 border-t border-outline-variant/10">
                    <a href="{{ route('admin.tasks.index') }}" class="w-full sm:w-auto px-10 py-4 text-center font-bold text-on-surface-variant hover:text-on-surface bg-surface-container-high hover:bg-surface-dim transition-all duration-300 rounded-xl">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-10 py-4 font-bold text-white bg-gradient-to-r from-primary to-primary-container shadow-lg shadow-primary/20 hover:shadow-primary/40 active:scale-[0.98] transition-all duration-300 rounded-xl">
                        Simpan Task (Bulk Assign)
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Bento Hint/Tips -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="col-span-1 bg-secondary-container/30 p-6 rounded-xl flex gap-4 items-start border-none">
            <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">tips_and_updates</span>
            <div>
                <h4 class="font-bold text-secondary text-sm">Best Practice</h4>
                <p class="text-xs text-on-secondary-container/80 mt-1">Sistem akan secara otomatis menyalin Detail *Task* ini kedalam meja tiap profil mahasiswa yang Anda centang.</p>
            </div>
        </div>
        <div class="col-span-1 md:col-span-2 bg-surface-container-high/50 p-6 rounded-xl flex gap-4 items-center">
            <div class="w-10 h-10 rounded-full border-2 border-white bg-primary-container flex items-center justify-center text-primary-fixed">
                <span class="material-symbols-outlined text-[18px]">group</span>
            </div>
            <p class="text-xs text-on-surface-variant">Saat ini terdapat {{ collect($students)->count() }} mahasiswa yang siap menerima penugasan baru.</p>
        </div>
    </div>
</div>
@endsection
