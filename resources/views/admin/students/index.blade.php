@extends('layouts.admin')
@section('content')

<!-- Desktop Header area (Search & Profile) -->
<div class="flex-1 flex flex-col space-y-lg">
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-end justify-between gap-md mb-lg">
<div>
<h2 class="font-headline-lg text-headline-lg md:text-[32px] md:leading-[40px] font-bold text-primary">Student Directory</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant mt-sm">Manage and oversee all active interns in the program.</p>
</div>
<form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data" class="m-0 p-0">
    @csrf
    <input type="file" name="csv_file" accept=".csv" class="hidden" id="csv_upload" onchange="this.form.submit()">
    <label for="csv_upload" class="cursor-pointer bg-surface-container-lowest text-primary border border-primary font-label-md text-label-md rounded-lg py-2 px-4 flex items-center justify-center gap-2 hover:bg-primary-fixed transition-colors shadow-sm whitespace-nowrap"><span class="material-symbols-outlined text-[18px]">upload_file</span>Import CSV</label>
</form>
<button onclick="openAddModal()" class="bg-primary text-on-primary font-label-md text-label-md rounded-lg py-2 px-4 flex items-center justify-center gap-2 hover:bg-primary-container hover:text-on-primary-container transition-colors shadow-sm whitespace-nowrap active:scale-95">
<span class="material-symbols-outlined text-[18px]">add</span>
                    Add New Student
</button>
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
<!-- Filters -->
<form method="GET" action="{{ route('admin.students.index') }}" class="bg-surface-container-lowest rounded-xl p-md mb-md shadow-sm border border-outline-variant/30 flex flex-col sm:flex-row gap-md items-center justify-between">
<div class="relative w-full sm:w-72">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
<input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 bg-surface-container-low border border-outline-variant/50 rounded-lg font-body-md text-body-md focus:outline-none focus:border-primary focus:bg-surface-container-lowest transition-all" placeholder="Search by name, email..." type="text"/>
</div>
<div class="flex items-center gap-sm w-full sm:w-auto overflow-x-auto pb-1 sm:pb-0 hide-scrollbar">
<select name="cohort" onchange="this.form.submit()" class="bg-surface-container-lowest border border-outline-variant/50 rounded-lg py-2 pl-3 pr-8 font-label-md text-label-md text-on-surface-variant focus:outline-none focus:border-primary cursor-pointer appearance-none">
<option value="all">All Cohorts</option>
@foreach($cohorts as $cohort)
<option value="{{ $cohort }}" {{ request('cohort') == $cohort ? 'selected' : '' }}>{{ $cohort }}</option>
@endforeach
</select>
<select name="status" onchange="this.form.submit()" class="bg-surface-container-lowest border border-outline-variant/50 rounded-lg py-2 pl-3 pr-8 font-label-md text-label-md text-on-surface-variant focus:outline-none focus:border-primary cursor-pointer appearance-none">
<option value="all">All Statuses</option>
<option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
<option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
<option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
</select>
<button type="submit" class="flex items-center gap-1 text-on-surface-variant font-label-md text-label-md px-3 py-2 hover:bg-surface-container-low rounded-lg transition-colors border border-transparent">
<span class="material-symbols-outlined text-[18px]">search</span>
                        Search
                    </button>
</div>
</form>
<!-- Data Table Card -->
<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/30 flex-1 overflow-hidden flex flex-col">
<div class="overflow-x-auto flex-1">
<table class="w-full text-left border-collapse min-w-[800px]">
<thead>
<tr class="border-b border-surface-variant bg-surface-container-low/50"><th class="py-3 px-md font-label-md text-label-md text-on-surface-variant font-semibold">Student Name</th><th class="py-3 px-md font-label-md text-label-md text-on-surface-variant font-semibold">Email</th><th class="py-3 px-md font-label-md text-label-md text-on-surface-variant font-semibold">Cohort/Divisi</th><th class="py-3 px-md font-label-md text-label-md text-on-surface-variant font-semibold">Join Date</th><th class="py-3 px-md font-label-md text-label-md text-on-surface-variant font-semibold text-right">Actions</th></tr>
</thead>
<tbody class="divide-y divide-surface-variant">
@forelse($students as $student)
<tr class="hover:bg-surface-container-low/30 transition-colors group">
    <td class="py-3 px-md">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-label-md font-bold">
                {{ strtoupper(substr($student->name, 0, 2)) }}
            </div>
            <div><p class="font-body-md text-body-md font-semibold text-on-surface">{{ $student->name }}</p></div>
        </div>
    </td>
    <td class="py-3 px-md font-body-md text-body-md text-on-surface-variant">{{ $student->email ?? 'N/A' }}</td>
    <td class="py-3 px-md font-body-md text-body-md text-on-surface-variant">{{ $student->major ?? 'N/A' }}</td>
    <td class="py-3 px-md font-body-md text-body-md text-on-surface-variant">{{ $student->created_at ? $student->created_at->format('M d, Y') : 'N/A' }}</td>
    <td class="py-3 px-md text-right">
        <div class="flex justify-end items-center gap-2">
            <button type="button" 
                onclick="openEditModal({
                    id: '{{ $student->id }}',
                    name: '{{ addslashes($student->name) }}',
                    nim: '{{ $student->nim }}',
                    university: '{{ addslashes($student->university) }}',
                    major: '{{ addslashes($student->major ?? '') }}',
                    email: '{{ $student->email ?? '' }}',
                    phone: '{{ $student->phone ?? '' }}',
                    status: '{{ $student->status }}'
                })" 
                class="p-1 text-on-surface-variant hover:text-primary hover:bg-primary-fixed rounded transition-colors" 
                title="Edit Profile"
            >
                <span class="material-symbols-outlined text-[18px]">edit</span>
            </button>
            <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?');" class="m-0 p-0 inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-1 text-on-surface-variant hover:text-error hover:bg-error-container rounded transition-colors" title="Delete Student">
                    <span class="material-symbols-outlined text-[18px]">delete</span>
                </button>
            </form>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="py-3 px-md text-center text-on-surface-variant">Belum ada data mahasiswa.</td>
</tr>
@endforelse
</tbody>
</table>
</div>
<!-- Pagination -->
<div class="border-t border-surface-variant bg-surface-container-lowest p-md flex items-center justify-between">
<span class="font-label-md text-label-md text-on-surface-variant">Showing {{ $students->count() }} students</span>
<div class="flex items-center gap-sm">
    @if(method_exists($students, 'links'))
        {{ $students->links('pagination::tailwind') }}
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
<!-- Add Student Modal -->
<div id="addStudentModal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div onclick="closeAddModal()" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300"></div>
    
    <!-- Modal Box -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[calc(100%-2rem)] sm:w-full sm:max-w-xl bg-white rounded-2xl border border-outline-variant shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="addModalBox">
        <!-- Header -->
        <div class="px-lg py-md bg-slate-50 border-b border-outline-variant flex justify-between items-center">
            <h3 class="font-headline-md text-[18px] font-bold text-primary flex items-center gap-2">
                <span class="material-symbols-outlined text-[22px] text-primary">person_add</span>
                <span>Add New Student</span>
            </h3>
            <button onclick="closeAddModal()" class="w-8 h-8 rounded-full hover:bg-slate-200 flex items-center justify-center text-outline transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        
        <!-- Form -->
        <form action="{{ route('admin.students.store') }}" method="POST" class="p-lg space-y-md m-0">
            @csrf
            
            <!-- Full Name -->
            <div class="space-y-1">
                <label for="add_name" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Lengkap</label>
                <input type="text" name="name" id="add_name" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="e.g. Alexander Hamilton">
            </div>
            
            <!-- Student ID (NIM) & University Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                <!-- NIM -->
                <div class="space-y-1">
                    <label for="add_nim" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">NIM</label>
                    <input type="text" name="nim" id="add_nim" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="e.g. 202401001">
                </div>
                
                <!-- University -->
                <div class="space-y-1">
                    <label for="add_university" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Asal Universitas</label>
                    <input type="text" name="university" id="add_university" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="e.g. Universitas Indonesia">
                </div>
            </div>
            
            <!-- Major & Status Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                <!-- Major -->
                <div class="space-y-1">
                    <label for="add_major" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Jurusan</label>
                    <input type="text" name="major" id="add_major" class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="e.g. Teknik Informatika">
                </div>
                
                <!-- Status -->
                <div class="space-y-1">
                    <label for="add_status" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Status</label>
                    <div class="relative">
                        <select name="status" id="add_status" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all cursor-pointer appearance-none">
                            <option value="active" selected>Aktif</option>
                            <option value="inactive">Inaktif</option>
                            <option value="completed">Selesai</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">arrow_drop_down</span>
                    </div>
                </div>
            </div>

            <!-- Email & Phone Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                <!-- Email -->
                <div class="space-y-1">
                    <label for="add_email" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Email Address</label>
                    <input type="email" name="email" id="add_email" class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="student@university.ac.id">
                </div>
                
                <!-- Phone -->
                <div class="space-y-1">
                    <label for="add_phone" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Nomor Telepon</label>
                    <input type="text" name="phone" id="add_phone" class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all" placeholder="e.g. 08123456789">
                </div>
            </div>
            
            <!-- Footer Actions -->
            <div class="pt-sm border-t border-outline-variant flex justify-end gap-sm">
                <button type="button" onclick="closeAddModal()" class="px-md py-2 text-slate-700 hover:bg-slate-100 rounded-lg text-sm font-semibold transition-all">Batal</button>
                <button type="submit" class="px-md py-2 bg-primary text-white hover:bg-primary-container rounded-lg text-sm font-semibold shadow-md transition-all active:scale-95">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Student Modal -->
<div id="editStudentModal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div onclick="closeEditModal()" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300"></div>
    
    <!-- Modal Box -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[calc(100%-2rem)] sm:w-full sm:max-w-xl bg-white rounded-2xl border border-outline-variant shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="editModalBox">
        <!-- Header -->
        <div class="px-lg py-md bg-slate-50 border-b border-outline-variant flex justify-between items-center">
            <h3 class="font-headline-md text-[18px] font-bold text-primary flex items-center gap-2">
                <span class="material-symbols-outlined text-[22px] text-primary">edit_square</span>
                <span>Edit Profile Mahasiswa</span>
            </h3>
            <button onclick="closeEditModal()" class="w-8 h-8 rounded-full hover:bg-slate-200 flex items-center justify-center text-outline transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        
        <!-- Form -->
        <form id="editStudentForm" method="POST" class="p-lg space-y-md m-0">
            @csrf
            @method('PUT')
            
            <!-- Full Name -->
            <div class="space-y-1">
                <label for="edit_name" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Nama Lengkap</label>
                <input type="text" name="name" id="edit_name" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
            </div>
            
            <!-- Student ID (NIM) & University Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                <!-- NIM -->
                <div class="space-y-1">
                    <label for="edit_nim" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">NIM</label>
                    <input type="text" name="nim" id="edit_nim" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                </div>
                
                <!-- University -->
                <div class="space-y-1">
                    <label for="edit_university" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Asal Universitas</label>
                    <input type="text" name="university" id="edit_university" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                </div>
            </div>
            
            <!-- Major & Status Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                <!-- Major -->
                <div class="space-y-1">
                    <label for="edit_major" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Jurusan</label>
                    <input type="text" name="major" id="edit_major" class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                </div>
                
                <!-- Status -->
                <div class="space-y-1">
                    <label for="edit_status" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Status</label>
                    <div class="relative">
                        <select name="status" id="edit_status" required class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all cursor-pointer appearance-none">
                            <option value="active">Aktif</option>
                            <option value="inactive">Inaktif</option>
                            <option value="completed">Selesai</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline pointer-events-none">arrow_drop_down</span>
                    </div>
                </div>
            </div>

            <!-- Email & Phone Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                <!-- Email -->
                <div class="space-y-1">
                    <label for="edit_email" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Email Address</label>
                    <input type="email" name="email" id="edit_email" class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                </div>
                
                <!-- Phone -->
                <div class="space-y-1">
                    <label for="edit_phone" class="block font-label-md text-xs font-bold text-slate-700 uppercase tracking-wider">Nomor Telepon</label>
                    <input type="text" name="phone" id="edit_phone" class="w-full bg-background border border-outline-variant rounded-lg px-3 py-2 text-body-md focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all">
                </div>
            </div>
            
            <!-- Footer Actions -->
            <div class="pt-sm border-t border-outline-variant flex justify-end gap-sm">
                <button type="button" onclick="closeEditModal()" class="px-md py-2 text-slate-700 hover:bg-slate-100 rounded-lg text-sm font-semibold transition-all">Batal</button>
                <button type="submit" class="px-md py-2 bg-primary text-white hover:bg-primary-container rounded-lg text-sm font-semibold shadow-md transition-all active:scale-95">Update Profile</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        const modal = document.getElementById('addStudentModal');
        const box = document.getElementById('addModalBox');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
    
    function closeAddModal() {
        const modal = document.getElementById('addStudentModal');
        const box = document.getElementById('addModalBox');
        
        box.classList.remove('scale-100', 'opacity-100');
        box.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function openEditModal(student) {
        const modal = document.getElementById('editStudentModal');
        const box = document.getElementById('editModalBox');
        const form = document.getElementById('editStudentForm');
        
        // Populate inputs
        document.getElementById('edit_name').value = student.name || '';
        document.getElementById('edit_nim').value = student.nim || '';
        document.getElementById('edit_university').value = student.university || '';
        document.getElementById('edit_major').value = student.major || '';
        document.getElementById('edit_email').value = student.email || '';
        document.getElementById('edit_phone').value = student.phone || '';
        document.getElementById('edit_status').value = student.status || 'active';
        
        // Dynamically set form action action
        form.action = `/admin/students/${student.id}`;
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
    
    function closeEditModal() {
        const modal = document.getElementById('editStudentModal');
        const box = document.getElementById('editModalBox');
        
        box.classList.remove('scale-100', 'opacity-100');
        box.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    window.addEventListener('DOMContentLoaded', () => {
        @if(isset($editStudent) && $editStudent)
            openEditModal({
                id: '{{ $editStudent->id }}',
                name: '{{ addslashes($editStudent->name) }}',
                nim: '{{ $editStudent->nim }}',
                university: '{{ addslashes($editStudent->university) }}',
                major: '{{ addslashes($editStudent->major ?? '') }}',
                email: '{{ $editStudent->email ?? '' }}',
                phone: '{{ $editStudent->phone ?? '' }}',
                status: '{{ $editStudent->status }}'
            });
        @endif
    });
</script>
@endsection


