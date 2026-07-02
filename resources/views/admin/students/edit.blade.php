@extends('layouts.admin')

@section('content')
<div class="py-6 md:py-10 px-4 sm:px-8 lg:px-12 max-w-6xl mx-auto">
<!-- Breadcrumbs -->
<nav class="flex items-center gap-2 text-sm text-on-surface-variant mb-6 font-medium">
<a class="hover:text-primary transition-colors" href="{{ route('admin.students.index') }}">Students</a>
<span class="material-symbols-outlined text-xs" data-icon="chevron_right">chevron_right</span>
<span class="text-primary">Edit Mahasiswa</span>
</nav>

@if ($errors->any())
    <div class="bg-error-container text-on-error-container p-4 rounded-xl mb-4">
        <ul class="list-disc list-inside text-sm font-medium">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
<div>
<h1 class="text-4xl font-extrabold font-headline tracking-tight text-on-surface mb-2">Edit Mahasiswa</h1>
<p class="text-on-surface-variant text-lg max-w-xl">Updating profile records for the academic semester. Ensure all institutional data is accurate.</p>
</div>
</div>
<!-- Editor Grid Layout -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
<!-- Left: Profile Identity Card -->
<div class="lg:col-span-4 space-y-6">
<div class="bg-surface-container-lowest rounded-3xl p-8 text-center flex flex-col items-center gap-6 shadow-[0px_4px_20px_rgba(0,0,0,0.02)] transition-all hover:shadow-lg">
<div class="relative group">
<div class="h-32 w-32 rounded-full overflow-hidden border-4 border-primary-fixed p-1">
<img alt="Student Profile" class="w-full h-full object-cover rounded-full bg-surface-container" data-alt="professional portrait of a young male student with glasses and short dark hair in a clean academic style" src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=EBF4FF&color=1F5E9B"/>
</div>
<button class="absolute bottom-0 right-0 h-10 w-10 bg-primary text-white rounded-full flex items-center justify-center shadow-lg hover:scale-105 active:scale-95 transition-all">
<span class="material-symbols-outlined text-sm" data-icon="photo_camera">photo_camera</span>
</button>
</div>
<div>
<h3 class="font-headline font-bold text-xl text-on-surface">{{ $student->name }}</h3>
<p class="text-on-surface-variant text-sm font-medium tracking-wide">NIM: {{ $student->nim }}</p>
</div>
<div class="w-full pt-4 border-t border-outline-variant/15 flex flex-col gap-3">
<div class="flex justify-between text-xs font-semibold uppercase tracking-wider text-on-surface-variant/60">
<span>Status</span>
<span class="text-secondary font-bold">{{ ucfirst($student->status) }}</span>
</div>
</div>
</div>
<!-- Informational Bento Box -->
<div class="bg-surface-container-low rounded-3xl p-6 space-y-4">
<h4 class="font-headline font-bold text-sm text-on-surface-variant uppercase tracking-widest">Metadata</h4>
<div class="flex items-center gap-4 text-sm">
<div class="h-8 w-8 rounded-lg bg-white flex items-center justify-center text-primary shadow-sm">
<span class="material-symbols-outlined text-sm" data-icon="event_note">event_note</span>
</div>
<div>
<p class="text-xs text-on-surface-variant">Last Update</p>
<p class="font-semibold text-on-surface">{{ $student->updated_at ? $student->updated_at->format('M d, Y') : 'N/A' }}</p>
</div>
</div>
<div class="flex items-center gap-4 text-sm">
<div class="h-8 w-8 rounded-lg bg-white flex items-center justify-center text-primary shadow-sm">
<span class="material-symbols-outlined text-sm" data-icon="fingerprint">fingerprint</span>
</div>
<div>
<p class="text-xs text-on-surface-variant">Device ID</p>
<p class="font-semibold text-on-surface truncate max-w-[120px]">QR-{{ substr($student->nim, -4) }}</p>
</div>
</div>
</div>
</div>
<!-- Right: Form Content Area -->
<div class="lg:col-span-8">
<div class="bg-surface-container-lowest rounded-3xl p-5 sm:p-8 md:p-12 shadow-[0px_4px_20px_rgba(0,0,0,0.02)]">
<form action="{{ route('admin.students.update', $student->id) }}" method="POST" class="space-y-8">
    @csrf
    @method('PUT')
<!-- Form Section 1: Academic Profile -->
<div class="space-y-6">
<div class="flex items-center gap-2 border-b border-outline-variant/15 pb-4">
<span class="material-symbols-outlined text-primary" data-icon="person_edit">person_edit</span>
<h2 class="font-headline font-bold text-lg text-on-surface">Academic Identity</h2>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="space-y-2">
<label class="text-sm font-bold text-on-surface-variant ml-1">Nama Lengkap</label>
<input name="name" class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all font-medium text-on-surface" placeholder="e.g. Jane Doe" type="text" value="{{ old('name', $student->name) }}" required/>
</div>
<div class="space-y-2">
<label class="text-sm font-bold text-on-surface-variant ml-1">NIM</label>
<input name="nim" class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all font-medium text-on-surface" placeholder="12345678" type="text" value="{{ old('nim', $student->nim) }}" required/>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<!-- University -->
<div class="space-y-2">
<label class="text-sm font-bold text-on-surface-variant ml-1">Asal Universitas</label>
<input name="university" value="{{ old('university', $student->university) }}" required class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all font-medium text-on-surface" placeholder="E.g. Universitas Indonesia" type="text"/>
</div>
<div class="space-y-2">
<label class="text-sm font-bold text-on-surface-variant ml-1">Jurusan</label>
<input name="major" class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all font-medium text-on-surface" placeholder="e.g. Informatics" type="text" value="{{ old('major', $student->major) }}" />
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="space-y-2">
<label class="text-sm font-bold text-on-surface-variant ml-1">Academic Email</label>
<input name="email" class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all font-medium text-on-surface" placeholder="name@university.edu" type="email" value="{{ old('email', $student->email) }}"/>
</div>
<div class="space-y-2">
<label class="text-sm font-bold text-on-surface-variant ml-1">Nomor Telepon</label>
<input name="phone" class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all font-medium text-on-surface" placeholder="+62 8..." type="text" value="{{ old('phone', $student->phone) }}"/>
</div>
</div>
</div>
<!-- Additional Notes / Status -->
<div class="space-y-2">
<label class="text-sm font-bold text-on-surface-variant ml-1">Status Intern</label>
<select name="status" class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all font-medium text-on-surface">
    <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Aktif</option>
    <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>Inaktif</option>
    <option value="completed" {{ old('status', $student->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
</select>
</div>
<!-- Actions -->
<div class="pt-8 flex flex-col-reverse md:flex-row items-center justify-end gap-4">
<a href="{{ route('admin.students.index') }}" class="w-full text-center md:w-auto px-10 py-4 text-sm font-bold text-on-surface-variant hover:bg-surface-container-high rounded-xl transition-all">
                                    Batal
</a>
<button class="w-full md:w-auto px-12 py-4 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3" type="submit">
<span class="material-symbols-outlined text-sm" data-icon="save">save</span>
                                    Update Profile
                                </button>
</div>
</form>
</div>
</div>
</div>
</div>

@endsection
