@extends('layouts.admin')

@section('content')
<!-- Main Content Area -->

<!-- TopAppBar -->

<!-- Content Canvas -->
<div class="pt-8 pb-12 px-12 min-h-screen bg-surface">
<div class="max-w-4xl mx-auto">
<!-- Breadcrumbs -->
<nav class="flex items-center gap-2 text-xs font-medium text-on-surface-variant mb-6">
<a href="{{ route('admin.students.index') }}" class="hover:text-primary">Students</a>
<span class="material-symbols-outlined text-xs">chevron_right</span>
<span class="text-primary">Tambah Mahasiswa</span>
</nav>
<div class="flex flex-col gap-8">
<!-- Header Section -->


@if ($errors->any())
    <div class="bg-error-container text-on-error-container p-4 rounded-xl mb-4">
        <ul class="list-disc list-inside text-sm font-medium">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Form Section -->
<div class="bg-surface-container-lowest rounded-3xl p-10 shadow-[0px_20px_40px_rgba(25,28,30,0.06)] relative overflow-hidden group">
<!-- Subtle Gradient Accent -->
<div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-primary-container/10 to-transparent rounded-full -mr-20 -mt-20 blur-3xl"></div>
<form action="{{ route('admin.students.store') }}" method="POST" class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
    @csrf
<!-- Full Name -->
<div class="flex flex-col gap-2 md:col-span-2">
<label class="text-sm font-bold text-on-surface-variant ml-1" for="name">Nama Lengkap</label>
<input name="name" value="{{ old('name') }}" required class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all placeholder:text-outline/50 text-on-surface font-medium" id="name" placeholder="E.g. Alexander Hamilton" type="text"/>
</div>
<!-- Student ID (NIM) -->
<div class="flex flex-col gap-2">
<label class="text-sm font-bold text-on-surface-variant ml-1" for="nim">NIM</label>
<div class="relative">
<span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-lg">badge</span>
<input name="nim" value="{{ old('nim') }}" required class="w-full bg-surface-container-high border-none rounded-xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all placeholder:text-outline/50 text-on-surface font-medium" id="nim" placeholder="202401001" type="text"/>
</div>
</div>
<!-- University -->
<div class="flex flex-col gap-2">
<label class="text-sm font-bold text-on-surface-variant ml-1" for="university">Asal Universitas</label>
<div class="relative">
<span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-lg">school</span>
<input name="university" value="{{ old('university') }}" required class="w-full bg-surface-container-high border-none rounded-xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all placeholder:text-outline/50 text-on-surface font-medium" id="university" placeholder="E.g. Universitas Indonesia" type="text"/>
</div>
</div>
<!-- Major -->
<div class="flex flex-col gap-2">
<label class="text-sm font-bold text-on-surface-variant ml-1" for="major">Jurusan</label>
<input name="major" value="{{ old('major') }}" class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all text-on-surface font-medium" id="major" placeholder="E.g. Teknik Informatika" type="text" />
</div>
<!-- Email -->
<div class="flex flex-col gap-2">
<label class="text-sm font-bold text-on-surface-variant ml-1" for="email">Email Address</label>
<div class="relative">
<span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-lg">mail</span>
<input name="email" value="{{ old('email') }}" class="w-full bg-surface-container-high border-none rounded-xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all placeholder:text-outline/50 text-on-surface font-medium" id="email" placeholder="student@university.ac.id" type="email"/>
</div>
</div>
<!-- Phone Number -->
<div class="flex flex-col gap-2">
<label class="text-sm font-bold text-on-surface-variant ml-1" for="phone">Nomor Telepon</label>
<div class="relative">
<span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-lg">phone</span>
<input name="phone" value="{{ old('phone') }}" class="w-full bg-surface-container-high border-none rounded-xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all placeholder:text-outline/50 text-on-surface font-medium" id="phone" placeholder="+62 812 3456 7890" type="tel"/>
</div>
</div>
<!-- Status -->
<div class="flex flex-col gap-2 md:col-span-2">
<label class="text-sm font-bold text-on-surface-variant ml-1" for="status">Status</label>
<select name="status" class="w-full bg-surface-container-high border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all text-on-surface font-medium" id="status">
    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inaktif</option>
    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
</select>
</div>
<!-- Action Buttons -->
<div class="md:col-span-2 pt-6 flex items-center justify-end gap-4">
<a href="{{ route('admin.students.index') }}" class="px-8 py-3 rounded-full text-sm font-bold text-slate-600 hover:bg-slate-100 transition-all">
                                    Batal
</a>
<button class="px-10 py-3 rounded-full bg-gradient-to-r from-primary to-primary-container text-white text-sm font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2" type="submit">
<span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">save</span>
                                    Simpan Mahasiswa
                                </button>
</div>
</form>
</div>
<!-- Guidance Bento Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<div class="md:col-span-2 bg-secondary-container/30 p-6 rounded-3xl flex flex-col gap-4">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center">
<span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">info</span>
</div>
<h4 class="font-bold text-on-secondary-container">Data Verification Notice</h4>
</div>
<p class="text-sm text-on-secondary-container/80 leading-relaxed">
                                Ensure all information matches the university database. The Student ID (NIM) will be used as the primary identifier for generating the unique QR code for attendance tracking.
                            </p>
</div>
<div class="bg-surface-container rounded-3xl p-6 flex flex-col items-center justify-center text-center gap-2 border border-outline-variant/10">
<span class="material-symbols-outlined text-3xl text-primary-container">qr_code_2</span>
<p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">Auto-Generated</p>
<p class="text-xs text-on-surface-variant px-4">QR code will be automatically created upon saving.</p>
</div>
</div>
</div>
</div>
</div>

@endsection
