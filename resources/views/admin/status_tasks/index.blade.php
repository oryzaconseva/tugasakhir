<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface": "#f7f9fb",
                        "on-secondary-container": "#0a6f66",
                        "surface-bright": "#f7f9fb",
                        "tertiary-fixed-dim": "#81d6c0",
                        "secondary-container": "#9cefe4",
                        "background": "#f7f9fb",
                        "primary-container": "#3e77b6",
                        "on-error": "#ffffff",
                        "outline": "#727781",
                        "tertiary-container": "#27826f",
                        "on-surface-variant": "#424750",
                        "on-primary": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "secondary": "#006a62",
                        "on-primary-container": "#fdfcff",
                        "primary": "#1f5e9b",
                        "on-background": "#191c1e",
                        "inverse-primary": "#a1c9ff",
                        "secondary-fixed-dim": "#83d5ca",
                        "inverse-surface": "#2d3133",
                        "surface-tint": "#22609e",
                        "surface-container-high": "#e6e8ea",
                        "error-container": "#ffdad6",
                        "surface-container-highest": "#e0e3e5",
                        "on-tertiary-fixed": "#00201a",
                        "on-secondary": "#ffffff",
                        "on-tertiary-container": "#f4fffa",
                        "inverse-on-surface": "#eff1f3",
                        "on-secondary-fixed-variant": "#00504a",
                        "on-surface": "#191c1e",
                        "surface-container": "#eceef0",
                        "on-primary-fixed-variant": "#004880",
                        "surface-container-low": "#f2f4f6",
                        "secondary-fixed": "#9ff1e6",
                        "outline-variant": "#c2c7d1",
                        "tertiary-fixed": "#9df3dc",
                        "on-tertiary-fixed-variant": "#005143",
                        "primary-fixed": "#d3e4ff",
                        "tertiary": "#006857",
                        "surface-dim": "#d8dadc",
                        "error": "#ba1a1a",
                        "surface-variant": "#e0e3e5",
                        "on-secondary-fixed": "#00201d",
                        "on-error-container": "#93000a",
                        "primary-fixed-dim": "#a1c9ff",
                        "on-primary-fixed": "#001c38",
                        "on-tertiary": "#ffffff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "fontFamily": {
                        "headline": ["Poppins", "sans-serif"],
                        "body": ["Poppins", "sans-serif"],
                        "label": ["Poppins", "sans-serif"]
                    }
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(24px);
        }
    </style>
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-surface font-body text-on-surface">
    <!-- NavigationDrawer -->
    <nav
        class="fixed left-0 top-0 h-full flex flex-col py-8 z-40 bg-slate-100 dark:bg-slate-900 shadow-none border-none h-screen w-72 rounded-r-3xl">
        <div class="px-8 mb-10">
            <span
                class="font-['Manrope'] text-xl font-extrabold tracking-tighter text-blue-900 dark:text-blue-100">InternSync</span>
        </div>
        <div class="flex flex-col gap-1 overflow-y-auto">
            <a class="text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 px-6 py-3 transition-all flex items-center gap-4 font-['Manrope'] text-sm tracking-tight font-medium"
                href="{{ route('admin.dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span> Dashboard
            </a>
            <a class="text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 px-6 py-3 transition-all flex items-center gap-4 font-['Manrope'] text-sm tracking-tight font-medium"
                href="{{ route('admin.students.index') }}">
                <span class="material-symbols-outlined">group</span> Data Mahasiswa
            </a>
            <a class="text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 px-6 py-3 transition-all flex items-center gap-4 font-['Manrope'] text-sm tracking-tight font-medium"
                href="{{ route('admin.attendance_qrs.index') }}">
                <span class="material-symbols-outlined">qr_code_scanner</span> QR Absensi
            </a>
            <a class="text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 px-6 py-3 transition-all flex items-center gap-4 font-['Manrope'] text-sm tracking-tight font-medium"
                href="{{ route('admin.tasks.index') ?? '#' }}">
                <span class="material-symbols-outlined">assignment</span> Task Management
            </a>
            <a class="text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 px-6 py-3 transition-all flex items-center gap-4 font-['Manrope'] text-sm tracking-tight font-medium"
                href="{{ route('admin.attendances.index') }}">
                <span class="material-symbols-outlined">calendar_today</span> Data Absensi
            </a>
            <a class="text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 px-6 py-3 transition-all flex items-center gap-4 font-['Manrope'] text-sm tracking-tight font-medium"
                href="{{ route('admin.daily_activities.index') }}">
                <span class="material-symbols-outlined">analytics</span> Monitoring Aktivitas
            </a>
            <a class="bg-blue-50 dark:bg-blue-900/30 text-blue-800 dark:text-blue-100 border-l-4 border-blue-600 font-bold px-6 py-3 flex items-center gap-4 font-['Manrope'] text-sm tracking-tight"
                href="{{ route('admin.status_tasks.index') ?? '#' }}">
                <span class="material-symbols-outlined">fact_check</span> Status Task
            </a>
        </div>
    </nav>
    <!-- Content Area -->
    <main class="ml-72 min-h-screen">
        <!-- TopAppBar -->
        <header
            class="flex justify-between items-center px-8 w-full z-50 sticky top-0 bg-white/70 backdrop-blur-xl h-16 shadow-sm shadow-slate-200/20">
            <div class="flex items-center gap-4">
                <button class="hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full p-2 transition-all">
                    <span class="material-symbols-outlined text-blue-700">menu</span>
                </button>
                <h1 class="font-['Manrope'] text-lg font-semibold text-on-surface">Status Task</h1>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3">
                    <img alt="User Profile" class="w-8 h-8 rounded-full object-cover"
                        data-alt="Close up portrait of a professional mentor with friendly expression, natural lighting in a modern office environment"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuB7kLKbJy-aF51ngAJCq7a4cmXbKz8y9p6MY3V61G876EEgw4_1POcM-iZapGN4uElX6jdFvO4ec5HUvn0s7TB7E-SiGIBxUShbnGHs16qRSp5JlAEpd7y-EB1pK68XcNQ0xFAfboz_sadrLshOJl2aDT_Zotnk-WpfBH0lyJP6inf7s3hhwCnmjBAvSjiCE0QQf5Gc6Erdj8GU1Z4ILBcGL13LOBE5wDuMpQFJ4PNabwQmqNXu3eMTOKiWLrIRVbKNR5Z9W6ZGlos" />
                    <span class="font-medium text-sm text-on-surface-variant">Admin Sync</span>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 text-slate-600 hover:bg-slate-100 rounded-full px-4 py-2 transition-all">
                        <span class="material-symbols-outlined">logout</span>
                        <span class="text-sm font-medium">Keluar</span>
                    </button>
                </form>
            </div>
        </header>
        <!-- Main Content Canvas -->
        <div class="p-8 max-w-7xl mx-auto">
            <!-- Summary Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <div
                    class="col-span-1 md:col-span-2 bg-surface-container-lowest p-8 rounded-xl shadow-[0_20_40px_rgba(25,28,30,0.06)] relative overflow-hidden group">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full transition-transform group-hover:scale-110">
                    </div>
                    <h3
                        class="font-headline text-sm font-semibold text-on-surface-variant uppercase tracking-wider mb-2">
                        Overall Progress</h3>
                    <div class="flex items-baseline gap-2 mb-4">
                        <span class="font-headline text-5xl font-extrabold text-primary tracking-tighter">74%</span>
                        <span class="text-secondary font-medium">+12% from last week</span>
                    </div>
                    <div class="w-full bg-surface-container-high h-3 rounded-full overflow-hidden">
                        <div
                            class="bg-gradient-to-r from-primary to-primary-container h-full w-[74%] rounded-full shadow-[0_0_12px_rgba(31,94,155,0.3)]">
                        </div>
                    </div>
                </div>
                <div
                    class="bg-surface-container-lowest p-8 rounded-xl shadow-[0_20_40px_rgba(25,28,30,0.06)] flex flex-col justify-between">
                    <div>
                        <span class="material-symbols-outlined text-tertiary-container mb-4"
                            style="font-variation-settings: 'FILL' 1;">check_circle</span>
                        <h3
                            class="font-headline text-sm font-semibold text-on-surface-variant uppercase tracking-wider">
                            Completed</h3>
                    </div>
                    <span class="font-headline text-4xl font-extrabold text-on-surface">128</span>
                </div>
                <div
                    class="bg-surface-container-lowest p-8 rounded-xl shadow-[0_20_40px_rgba(25,28,30,0.06)] flex flex-col justify-between">
                    <div>
                        <span class="material-symbols-outlined text-primary-container mb-4"
                            style="font-variation-settings: 'FILL' 1;">pending</span>
                        <h3
                            class="font-headline text-sm font-semibold text-on-surface-variant uppercase tracking-wider">
                            In Progress</h3>
                    </div>
                    <span class="font-headline text-4xl font-extrabold text-on-surface">45</span>
                </div>
            </div>
            <!-- Task List Section -->
            <div class="space-y-8">
                <div class="flex items-center justify-between">
                    <h2 class="font-headline text-2xl font-extrabold tracking-tight">Current Internship Tasks</h2>
                    <div class="flex gap-2">
                        <button
                            class="bg-surface-container-high text-on-surface-variant px-4 py-2 rounded-full text-sm font-medium hover:bg-surface-container-highest transition-colors">Recent</button>
                        <button
                            class="bg-primary text-on-primary px-4 py-2 rounded-full text-sm font-medium hover:bg-primary/90 transition-colors">Add
                            New Task</button>
                    </div>
                </div>
                <!-- Custom Task Cards (Non-Standard List) -->
                <div class="grid grid-cols-1 gap-4">
                    <!-- Task Item 1 -->
                    <div
                        class="bg-surface-container-lowest hover:bg-surface-bright p-6 rounded-xl transition-all duration-300 group flex items-center gap-8">
                        <div class="w-16 h-16 rounded-xl bg-primary/5 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-3xl">terminal</span>
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center gap-3 mb-1">
                                <h4 class="font-headline font-bold text-lg text-on-surface">API Integration: Attendance
                                    Module</h4>
                                <span
                                    class="bg-secondary-container text-on-secondary-container text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-tighter">Backend</span>
                            </div>
                            <p class="text-sm text-on-surface-variant line-clamp-1">Refactoring the QR validation logic
                                and integrating with the real-time notification service.</p>
                        </div>
                        <div class="w-64">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-bold text-on-surface-variant">Progress</span>
                                <span class="text-xs font-extrabold text-primary">90%</span>
                            </div>
                            <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
                                <div class="bg-primary h-full w-[90%] rounded-full"></div>
                            </div>
                        </div>
                        <div class="flex -space-x-2">
                            <img alt="Team 1" class="w-8 h-8 rounded-full border-2 border-surface-container-lowest"
                                data-alt="Portrait of a young male software developer wearing glasses"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCbZyg1g2Tm3xQbJKzMUR3cuDqa_hdAGdD4e7IXKB9CwyxQulx9mH7ZvWsjwn1Gv12xqG4KnO_9xK3v3fUE0d1nsFpgRZXuG3sZOUBvr538MeCocc1k3vrAMO5Q5LmXMyi7gVWkzgm9EOO9X6qNFkeEtE53kBGPfe4w5jPL6eq6jD32y5PE3tI2z6TnR6WdITVvefVt0dDw8ca70lpUwdNFDZURwIrbrqXUUJFS1qdAO4Ajsg_n63m-Daep18eslcVquyUDRgkN2Q8" />
                            <img alt="Team 2" class="w-8 h-8 rounded-full border-2 border-surface-container-lowest"
                                data-alt="Portrait of a smiling female designer with wavy hair"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBJ19fPkYVatcmpveNxkfDVCbQlPEanTvD3BJH8UYk6Bg509XFn7lA182WzeYBeAmFRVyqioxnDn_U6T_TUFyYMpSZAA9GT-w0v3NETxIPK12LDvFJJO6vVzIVycOTdm_nStt5NNJF6SFi6hYN_uVa7T_h-wNZ5VX_eFyqZ4DSxgqaucWmO0YdgJOWHF1jfhpN59fhxf86I6t_IVxC2QW37tBahwA1GTDJn4AeyYIigZV2ASvTA22rIZ6KcN9s5viuMxd2FokjKZAk" />
                            <div
                                class="w-8 h-8 rounded-full border-2 border-surface-container-lowest bg-surface-container-high flex items-center justify-center text-[10px] font-bold text-on-surface-variant">
                                +2</div>
                        </div>
                        <div class="flex items-center gap-2 min-w-[120px] justify-end">
                            <span class="material-symbols-outlined text-secondary"
                                style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="text-xs font-bold text-secondary uppercase tracking-widest">On Track</span>
                        </div>
                    </div>
                    <!-- Task Item 2 -->
                    <div
                        class="bg-surface-container-lowest hover:bg-surface-bright p-6 rounded-xl transition-all duration-300 group flex items-center gap-8">
                        <div
                            class="w-16 h-16 rounded-xl bg-tertiary-fixed-dim/20 flex items-center justify-center text-tertiary">
                            <span class="material-symbols-outlined text-3xl">brush</span>
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center gap-3 mb-1">
                                <h4 class="font-headline font-bold text-lg text-on-surface">Dashboard UI Refinement</h4>
                                <span
                                    class="bg-primary-fixed text-on-primary-fixed-variant text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-tighter">Design</span>
                            </div>
                            <p class="text-sm text-on-surface-variant line-clamp-1">Updating the academic atelier design
                                system tokens and cleaning up asymmetric bento components.</p>
                        </div>
                        <div class="w-64">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-bold text-on-surface-variant">Progress</span>
                                <span class="text-xs font-extrabold text-primary">45%</span>
                            </div>
                            <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
                                <div class="bg-primary h-full w-[45%] rounded-full"></div>
                            </div>
                        </div>
                        <div class="flex -space-x-2">
                            <img alt="Team 3" class="w-8 h-8 rounded-full border-2 border-surface-container-lowest"
                                data-alt="Close up of a professional woman looking confidently at the camera"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCdLwdSJslkHXnxWBNz1yWEm2vOh1n6RSZe8ekTs3RJbgIsYZzdZA_XC1Zc2C4Dir2E3wJOoqQbRWpjeF0C8-KJGMEY-AAt-VpLCLuq1TOlxyfX_jpI_sYFK-ZaCZqhgV8i5LSWq6WoBre0m4siwyEWrtAQXfXZ7k18abelZWZzsDYFXM6y5Ppr27EkL8kIB80UPwPIzcYrXrtMLbXZ0E7W_TmoPPlylrcDHBDAAssNc615N1A44_V4XDX4alA4pw2vv2eU5asI9T4" />
                            <div
                                class="w-8 h-8 rounded-full border-2 border-surface-container-lowest bg-surface-container-high flex items-center justify-center text-[10px] font-bold text-on-surface-variant">
                                +1</div>
                        </div>
                        <div class="flex items-center gap-2 min-w-[120px] justify-end">
                            <span class="material-symbols-outlined text-primary"
                                style="font-variation-settings: 'FILL' 1;">change_history</span>
                            <span class="text-xs font-bold text-primary uppercase tracking-widest">Active</span>
                        </div>
                    </div>
                    <!-- Task Item 3 -->
                    <div
                        class="bg-surface-container-lowest hover:bg-surface-bright p-6 rounded-xl transition-all duration-300 group flex items-center gap-8">
                        <div
                            class="w-16 h-16 rounded-xl bg-error-container/20 flex items-center justify-center text-error">
                            <span class="material-symbols-outlined text-3xl">bug_report</span>
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center gap-3 mb-1">
                                <h4 class="font-headline font-bold text-lg text-on-surface">Database Optimization</h4>
                                <span
                                    class="bg-error-container text-on-error-container text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-tighter">Critical</span>
                            </div>
                            <p class="text-sm text-on-surface-variant line-clamp-1">Fixing slow query performance on the
                                student attendance history logging table.</p>
                        </div>
                        <div class="w-64">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-bold text-on-surface-variant">Progress</span>
                                <span class="text-xs font-extrabold text-error">12%</span>
                            </div>
                            <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden">
                                <div class="bg-error h-full w-[12%] rounded-full shadow-[0_0_8px_rgba(186,26,26,0.3)]">
                                </div>
                            </div>
                        </div>
                        <div class="flex -space-x-2">
                            <img alt="Team 4" class="w-8 h-8 rounded-full border-2 border-surface-container-lowest"
                                data-alt="Portrait of a young professional man in a white shirt"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCI-bMBeM4hnaYOVLaP9IMSrW5ONgapXc0igNBgxP9srC1e1MJs4f-MQqTfPZTTxTX4zur011GcDKenoxQ8eyb6SBlTl1lrggngYeX1RMZe6jYY-lw9dpyWx4LZ5l4Je3_cZ86lavw-J4XZ0yHOQBylSRZ0-C4BoTnImE981heN8sy-PGNHZGs8TXTL-AqYK9djcvczsvMDS0rgCKbah9Un_bkEiFaajhvDuSaFyn7qLkfIXritqXl-rdv3AUZtJKb1nG5e2Dt1hqc" />
                        </div>
                        <div class="flex items-center gap-2 min-w-[120px] justify-end">
                            <span class="material-symbols-outlined text-error"
                                style="font-variation-settings: 'FILL' 1;">error</span>
                            <span class="text-xs font-bold text-error uppercase tracking-widest">Delayed</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Detailed Progress Sidebar View (Asymmetric Layout) -->
            <div class="mt-16 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <h3 class="font-headline text-xl font-bold mb-6">Activity Timeline</h3>
                    <div class="bg-surface-container-low rounded-2xl p-8 space-y-8">
                        <div class="flex gap-6 relative">
                            <div class="absolute left-4 top-8 bottom-0 w-px bg-outline-variant opacity-20"></div>
                            <div
                                class="z-10 w-8 h-8 rounded-full bg-primary flex items-center justify-center text-on-primary">
                                <span class="material-symbols-outlined text-sm">history</span>
                            </div>
                            <div>
                                <h5 class="font-bold text-on-surface">Update pushed to Main Branch</h5>
                                <p class="text-sm text-on-surface-variant">2 hours ago • By Ridwan Hakim</p>
                                <div
                                    class="mt-4 p-4 bg-surface-container-lowest rounded-xl border border-outline-variant/10">
                                    <p class="text-xs font-mono text-primary-container">git commit -m "feat: implement
                                        biometric QR verification for mobile"</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-6 relative">
                            <div class="absolute left-4 top-8 bottom-0 w-px bg-outline-variant opacity-20"></div>
                            <div
                                class="z-10 w-8 h-8 rounded-full bg-secondary flex items-center justify-center text-on-secondary">
                                <span class="material-symbols-outlined text-sm">task_alt</span>
                            </div>
                            <div>
                                <h5 class="font-bold text-on-surface">Task "Asset Organization" completed</h5>
                                <p class="text-sm text-on-surface-variant">5 hours ago • By Sarah Chen</p>
                            </div>
                        </div>
                        <div class="flex gap-6">
                            <div
                                class="z-10 w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-sm">comment</span>
                            </div>
                            <div>
                                <h5 class="font-bold text-on-surface">New feedback on "UI Refinement"</h5>
                                <p class="text-sm text-on-surface-variant">Yesterday • From Lead Designer</p>
                                <p class="mt-2 italic text-sm text-on-surface-variant">"The contrast in the status
                                    indicators could be improved for better accessibility."</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-1">
                    <h3 class="font-headline text-xl font-bold mb-6">Interns Breakdown</h3>
                    <div
                        class="bg-surface-container-lowest rounded-2xl p-6 shadow-[0_20_40px_rgba(25,28,30,0.06)] space-y-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold">
                                    RH</div>
                                <div>
                                    <p class="font-bold text-sm">Ridwan Hakim</p>
                                    <p class="text-[10px] uppercase font-bold text-on-surface-variant opacity-60">Mobile
                                        Developer</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-extrabold text-primary">82%</p>
                                <p class="text-[10px] text-on-surface-variant">Efficiency</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold">
                                    SC</div>
                                <div>
                                    <p class="font-bold text-sm">Sarah Chen</p>
                                    <p class="text-[10px] uppercase font-bold text-on-surface-variant opacity-60">UI/UX
                                        Intern</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-extrabold text-secondary">94%</p>
                                <p class="text-[10px] text-on-surface-variant">Efficiency</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-bold">
                                    AM</div>
                                <div>
                                    <p class="font-bold text-sm">Aditya Mahendra</p>
                                    <p class="text-[10px] uppercase font-bold text-on-surface-variant opacity-60">
                                        Backend Eng.</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-extrabold text-on-surface-variant">65%</p>
                                <p class="text-[10px] text-on-surface-variant">Efficiency</p>
                            </div>
                        </div>
                        <button
                            class="w-full py-3 border border-outline-variant/30 rounded-xl text-sm font-bold text-on-surface-variant hover:bg-surface-container-low transition-colors mt-4">View
                            All Reports</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>