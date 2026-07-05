@extends('layouts.admin')

@section('title', 'Pengaturan | InternSync')

@section('content')
<div class="py-6 md:py-10 px-4 sm:px-6 md:px-8 max-w-4xl w-full mx-auto space-y-8 flex-1">


    <!-- Header Section -->
    <div class="space-y-2">
        <h2 class="text-3xl font-extrabold tracking-tight text-on-surface">Pengaturan Sistem</h2>
        <p class="text-on-surface-variant max-w-2xl">Kelola informasi profil Anda dan perbarui kata sandi untuk menjaga keamanan akun.</p>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 p-4 rounded-xl shadow-sm transition-all duration-300">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            <p class="text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Form errors -->
    @if ($errors->any())
        <div class="flex items-start gap-3 bg-error-container/30 border border-error/20 text-error p-4 rounded-xl shadow-sm">
            <span class="material-symbols-outlined text-error mt-0.5">error</span>
            <div class="space-y-1">
                <p class="text-sm font-bold">Terjadi beberapa kesalahan:</p>
                <ul class="list-disc ml-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Settings Container with Tabs -->
    <div class="bg-surface-container-lowest rounded-2xl shadow-[0_20px_40px_rgba(25,28,30,0.04)] border border-outline-variant/20 overflow-hidden flex flex-col md:flex-row min-h-[450px]">
        
        <!-- Tabs List (Sidebar-like for desktop, horizontal for mobile) -->
        <div class="w-full md:w-64 bg-surface-container-low/40 border-b md:border-b-0 md:border-r border-outline-variant/30 p-4 flex flex-row md:flex-col gap-2">
            <button onclick="switchTab('profile')" id="tab-btn-profile" class="flex-1 md:flex-none flex items-center justify-center md:justify-start gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-200 active:scale-95">
                <span class="material-symbols-outlined text-[20px]">account_circle</span>
                <span>Profil Admin</span>
            </button>
            <button onclick="switchTab('security')" id="tab-btn-security" class="flex-1 md:flex-none flex items-center justify-center md:justify-start gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-200 active:scale-95">
                <span class="material-symbols-outlined text-[20px]">security</span>
                <span>Keamanan</span>
            </button>
        </div>

        <!-- Tab Panels -->
        <div class="flex-1 p-6 sm:p-8">
            
            <!-- Panel 1: Profile Information -->
            <div id="tab-panel-profile" class="space-y-6 hidden">
                <div>
                    <h3 class="text-lg font-bold text-on-surface">Informasi Profil</h3>
                    <p class="text-xs text-on-surface-variant mt-1">Perbarui nama panggilan dan alamat email resmi Anda.</p>
                </div>
                
                <form action="{{ route('admin.settings.profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <!-- Name Input -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-on-surface ml-1">Nama Lengkap <span class="text-error">*</span></label>
                        <input name="name" value="{{ old('name', $user->name) }}" required class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all duration-200 placeholder:text-outline-variant font-medium text-sm text-on-surface" placeholder="Nama Lengkap" type="text"/>
                    </div>

                    <!-- Email Input -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-on-surface ml-1">Alamat Email <span class="text-error">*</span></label>
                        <input name="email" value="{{ old('email', $user->email) }}" required class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all duration-200 placeholder:text-outline-variant font-medium text-sm text-on-surface" placeholder="name@domain.com" type="email"/>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-outline-variant/10">
                        <button type="submit" class="w-full sm:w-auto px-8 py-3.5 font-bold text-white bg-gradient-to-r from-primary to-primary-container shadow-lg shadow-primary/20 hover:shadow-primary/30 hover:opacity-95 active:scale-[0.98] transition-all duration-200 rounded-xl text-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Panel 2: Security & Password -->
            <div id="tab-panel-security" class="space-y-6 hidden">
                <div>
                    <h3 class="text-lg font-bold text-on-surface">Ubah Kata Sandi</h3>
                    <p class="text-xs text-on-surface-variant mt-1">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk menjaga keamanan.</p>
                </div>
                
                <form action="{{ route('admin.settings.password.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <!-- Current Password -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-on-surface ml-1">Kata Sandi Saat Ini <span class="text-error">*</span></label>
                        <input name="current_password" required class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all duration-200 placeholder:text-outline-variant font-medium text-sm text-on-surface" placeholder="••••••••" type="password"/>
                    </div>

                    <!-- New Password -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-on-surface ml-1">Kata Sandi Baru <span class="text-error">*</span></label>
                        <input name="password" required class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all duration-200 placeholder:text-outline-variant font-medium text-sm text-on-surface" placeholder="•••••••• (Minimal 8 karakter)" type="password"/>
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-on-surface ml-1">Konfirmasi Kata Sandi Baru <span class="text-error">*</span></label>
                        <input name="password_confirmation" required class="w-full px-5 py-4 bg-surface-container-high border-none rounded-xl focus:ring-2 focus:ring-primary/20 focus:bg-surface-container-lowest transition-all duration-200 placeholder:text-outline-variant font-medium text-sm text-on-surface" placeholder="••••••••" type="password"/>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-outline-variant/10">
                        <button type="submit" class="w-full sm:w-auto px-8 py-3.5 font-bold text-white bg-gradient-to-r from-primary to-primary-container shadow-lg shadow-primary/20 hover:shadow-primary/30 hover:opacity-95 active:scale-[0.98] transition-all duration-200 rounded-xl text-sm">
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>

<script>
    // Tab switching logic
    // Automatically focus on security tab if validation errors are password-related
    let activeTab = "{{ $errors->has('current_password') || $errors->has('password') ? 'security' : 'profile' }}";

    function switchTab(tabId) {
        activeTab = tabId;
        
        // Panels
        const profilePanel = document.getElementById('tab-panel-profile');
        const securityPanel = document.getElementById('tab-panel-security');
        
        // Buttons
        const profileBtn = document.getElementById('tab-btn-profile');
        const securityBtn = document.getElementById('tab-btn-security');

        if (tabId === 'profile') {
            profilePanel.classList.remove('hidden');
            securityPanel.classList.add('hidden');
            
            // Activate button styles
            profileBtn.className = "flex-1 md:flex-none flex items-center justify-center md:justify-start gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-200 active:scale-95 bg-primary text-on-primary shadow-sm";
            securityBtn.className = "flex-1 md:flex-none flex items-center justify-center md:justify-start gap-3 px-4 py-3 rounded-xl font-medium text-sm transition-all duration-200 active:scale-95 text-on-surface-variant hover:bg-surface-container-highest";
        } else {
            profilePanel.classList.add('hidden');
            securityPanel.classList.remove('hidden');
            
            // Activate button styles
            profileBtn.className = "flex-1 md:flex-none flex items-center justify-center md:justify-start gap-3 px-4 py-3 rounded-xl font-medium text-sm transition-all duration-200 active:scale-95 text-on-surface-variant hover:bg-surface-container-highest";
            securityBtn.className = "flex-1 md:flex-none flex items-center justify-center md:justify-start gap-3 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-200 active:scale-95 bg-primary text-on-primary shadow-sm";
        }
    }

    // Initialize tabs
    document.addEventListener("DOMContentLoaded", function() {
        switchTab(activeTab);
    });
</script>
@endsection
