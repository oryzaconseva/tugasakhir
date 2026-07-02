<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Millennia - Mentor Dashboard')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-highest": "#e3e2e8",
                        "on-primary": "#ffffff",
                        "outline": "#757682",
                        "inverse-on-surface": "#f1f0f6",
                        "outline-variant": "#c5c6d2",
                        "surface-container": "#efedf3",
                        "on-tertiary-container": "#d37758",
                        "background": "#faf8ff",
                        "surface-container-lowest": "#ffffff",
                        "surface-tint": "#435b9f",
                        "on-tertiary-fixed": "#390b00",
                        "inverse-primary": "#b3c5ff",
                        "primary-container": "#002366",
                        "error": "#ba1a1a",
                        "on-primary-fixed": "#00174a",
                        "on-background": "#1a1b20",
                        "on-secondary-fixed": "#40000a",
                        "surface-container-high": "#e9e7ee",
                        "secondary-fixed-dim": "#ffb3b4",
                        "on-surface": "#1a1b20",
                        "secondary": "#b71032",
                        "on-primary-fixed-variant": "#2a4386",
                        "secondary-fixed": "#ffdad9",
                        "secondary-container": "#da3148",
                        "tertiary-container": "#501300",
                        "on-secondary-container": "#fffbff",
                        "on-error-container": "#93000a",
                        "surface-variant": "#e3e2e8",
                        "on-secondary-fixed-variant": "#920023",
                        "surface-dim": "#dad9e0",
                        "on-error": "#ffffff",
                        "inverse-surface": "#2f3035",
                        "primary-fixed": "#dbe1ff",
                        "tertiary-fixed": "#ffdbd0",
                        "tertiary-fixed-dim": "#ffb59e",
                        "on-tertiary": "#ffffff",
                        "on-surface-variant": "#444650",
                        "surface": "#faf8ff",
                        "tertiary": "#2d0700",
                        "surface-bright": "#faf8ff",
                        "primary-fixed-dim": "#b3c5ff",
                        "on-tertiary-fixed-variant": "#783018",
                        "on-primary-container": "#758dd5",
                        "error-container": "#ffdad6",
                        "primary": "#00113a",
                        "surface-container-low": "#f4f3f9",
                        "on-secondary": "#ffffff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "gutter-mobile": "12px",
                        "md": "16px",
                        "margin-mobile": "16px",
                        "sm": "8px",
                        "xl": "32px",
                        "xs": "4px",
                        "lg": "24px",
                        "base": "4px"
                    },
                    "fontFamily": {
                        "display-lg": ["Poppins", "sans-serif"],
                        "body-md": ["Poppins", "sans-serif"],
                        "label-md": ["Poppins", "sans-serif"],
                        "headline-lg": ["Poppins", "sans-serif"],
                        "headline-lg-mobile": ["Poppins", "sans-serif"],
                        "headline-md": ["Poppins", "sans-serif"],
                        "body-lg": ["Poppins", "sans-serif"]
                    },
                    "fontSize": {
                        "display-lg": ["30px", { "lineHeight": "38px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500" }],
                        "headline-lg": ["24px", { "lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "headline-lg-mobile": ["22px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "headline-md": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }]
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

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c5c6d2;
            border-radius: 10px;
        }

        .glass-effect {
            backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.8);
        }

        .ambient-shadow {
            box-shadow: 0 4px 20px rgba(0, 17, 58, 0.06);
        }
    </style>
</head>

<body class="bg-background text-on-surface flex overflow-hidden h-screen">

    @php
        $currentRoute = Route::currentRouteName();
    @endphp

    <!-- Sidebar -->
    <aside
        class="hidden md:flex h-screen w-[300px] fixed left-0 top-0 bg-surface-container-low border-r border-outline-variant flex-col p-lg z-50"
        id="sidebar">
        <!-- Logo Section with nice padding at top to avoid being squeezed to the top -->
        <div class="pt-4 pb-6 px-md border-b border-outline-variant/30 mb-6">
            <div class="flex items-center gap-sm">
                <div class="w-10 h-10 flex items-center justify-center">
                    <img alt="Millennia Logo" class="w-full h-full object-contain" src="{{ asset('images/logo.png') }}">
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-primary tracking-tight text-headline-md leading-none">Millennia</span>
                    <p class="font-label-md text-[10px] text-on-surface-variant tracking-widest uppercase mt-1">MENTOR PORTAL</p>
                </div>
            </div>
        </div>

        <!-- Sidebar Navigation grouped by category -->
        <nav class="flex-1 space-y-6 overflow-y-auto custom-scrollbar pr-1">
            <!-- Group 1: Overview -->
            <div class="space-y-1.5">
                <p class="px-md text-[10px] font-bold text-on-surface-variant/40 uppercase tracking-widest leading-none mb-2">Overview</p>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-md px-md py-3 rounded-xl transition-all cursor-pointer active:scale-95 {{ $currentRoute === 'admin.dashboard' ? 'bg-primary text-on-primary font-semibold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-highest font-medium' }}">
                    <span class="material-symbols-outlined text-[20px]" data-icon="dashboard">dashboard</span>
                    <span class="font-label-md text-[14px]">Dashboard</span>
                </a>
            </div>

            <!-- Group 2: Internship Management -->
            <div class="space-y-1.5">
                <p class="px-md text-[10px] font-bold text-on-surface-variant/40 uppercase tracking-widest leading-none mb-2">Internship</p>
                <a href="{{ route('admin.students.index') }}"
                    class="flex items-center gap-md px-md py-3 rounded-xl transition-all cursor-pointer active:scale-95 {{ $currentRoute === 'admin.students.index' ? 'bg-primary text-on-primary font-semibold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-highest font-medium' }}">
                    <span class="material-symbols-outlined text-[20px]" data-icon="group">group</span>
                    <span class="font-label-md text-[14px]">Students</span>
                </a>
                <a href="{{ route('admin.attendances.index') }}"
                    class="flex items-center gap-md px-md py-3 rounded-xl transition-all cursor-pointer active:scale-95 {{ $currentRoute === 'admin.attendances.index' ? 'bg-primary text-on-primary font-semibold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-highest font-medium' }}">
                    <span class="material-symbols-outlined text-[20px]" data-icon="event_available">event_available</span>
                    <span class="font-label-md text-[14px]">Attendance</span>
                </a>
                <a href="{{ route('admin.leave_requests.index') }}"
                    class="flex items-center gap-md px-md py-3 rounded-xl transition-all cursor-pointer active:scale-95 {{ $currentRoute === 'admin.leave_requests.index' ? 'bg-primary text-on-primary font-semibold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-highest font-medium' }}">
                    <span class="material-symbols-outlined text-[20px]" data-icon="event_note">event_note</span>
                    <span class="font-label-md text-[14px]">Leave Request</span>
                </a>
            </div>

            <!-- Group 3: Activity & Reports -->
            <div class="space-y-1.5">
                <p class="px-md text-[10px] font-bold text-on-surface-variant/40 uppercase tracking-widest leading-none mb-2">Activity & Reports</p>
                <a href="{{ route('admin.tasks.index') }}"
                    class="flex items-center gap-md px-md py-3 rounded-xl transition-all cursor-pointer active:scale-95 {{ $currentRoute === 'admin.tasks.index' ? 'bg-primary text-on-primary font-semibold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-highest font-medium' }}">
                    <span class="material-symbols-outlined text-[20px]" data-icon="task">task</span>
                    <span class="font-label-md text-[14px]">Tasks</span>
                </a>
                <a href="{{ route('admin.daily_activities.index') }}"
                    class="flex items-center gap-md px-md py-3 rounded-xl transition-all cursor-pointer active:scale-95 {{ $currentRoute === 'admin.daily_activities.index' ? 'bg-primary text-on-primary font-semibold shadow-sm' : 'text-on-surface-variant hover:bg-surface-container-highest font-medium' }}">
                    <span class="material-symbols-outlined text-[20px]" data-icon="analytics">analytics</span>
                    <span class="font-label-md text-[14px]">Reports</span>
                </a>
            </div>
        </nav>

        <!-- Bottom Actions -->
        <div class="mt-auto pt-md border-t border-outline-variant space-y-sm">
            <button
                class="w-full bg-secondary text-on-secondary px-md py-3 rounded-xl font-bold text-[14px] flex items-center justify-center gap-sm hover:opacity-90 transition-all active:scale-95 mb-lg shadow-lg">
                <span class="material-symbols-outlined" data-icon="add">add</span>
                New Report
            </button>
            <div class="space-y-xs">
                <div
                    class="flex items-center gap-md text-on-surface-variant px-md py-2.5 hover:bg-surface-container-highest rounded-lg transition-colors cursor-pointer active:scale-95">
                    <span class="material-symbols-outlined" data-icon="help">help</span>
                    <span class="font-label-md text-[14px]">Help Center</span>
                </div>
                <form action="{{ route('admin.logout') ?? '#' }}" method="POST" class="w-full m-0 p-0">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-md text-on-surface-variant px-md py-2.5 hover:bg-surface-container-highest rounded-lg transition-colors cursor-pointer active:scale-95 text-left">
                        <span class="material-symbols-outlined" data-icon="logout">logout</span>
                        <span class="font-label-md text-[14px]">Sign Out</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>
    <!-- Top Navigation Bar -->
    <header
        class="w-full md:w-[calc(100%-300px)] h-16 fixed top-0 right-0 z-40 bg-surface-container-lowest shadow-sm flex justify-between items-center px-lg">
        <div class="flex items-center flex-1 max-w-xl">
            <div class="relative w-full hidden sm:block">
                <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline"
                    data-icon="search">search</span>
                <input
                    class="w-full bg-surface-container-low border-none rounded-full py-2.5 pl-10 pr-md text-sm focus:ring-2 focus:ring-primary"
                    placeholder="Search interns or records..." type="text">
            </div>
            <div class="md:hidden">
                <span class="material-symbols-outlined text-primary cursor-pointer">menu</span>
            </div>
        </div>
        <div class="flex items-center gap-md ml-lg">
            <button
                class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all relative"><span
                    class="material-symbols-outlined">notifications</span></button>
            <button
                class="p-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-all"><span
                    class="material-symbols-outlined">settings</span></button>
            <div class="h-8 w-px bg-outline-variant mx-sm hidden sm:block"></div>
            <div
                class="flex items-center gap-sm cursor-pointer hover:bg-surface-container-high p-1 pr-4 rounded-full transition-all border border-outline-variant/20">
                <img alt="Mentor avatar" class="w-8 h-8 rounded-full object-cover shadow-sm"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuAFHHbzG7TyI2q65J2NUxNuUnR3nHHZvClEXCxPgt9V5LiPkxfmwbiWjVV-WnmZKnUt2gXs16kbGndAbXw23Ny9d6uiXStavfPkmc8d4oVckCg_e9emzs3uAau_0F_7VZgu4Qs5PiFi0pma-8wVH4veZl9JPtK_zIV7kljcyaVIBkvWaQyIgWY261xz8FWVTXBcCZ6c-8_OiLtuBpOEV6IpPty3cjAWRX1GA3wWp7Y1VpsbWoq5R8vLnaZCS4pCSclwkwmkMTFiukCc"><span
                    class="font-label-md text-label-md text-on-surface font-bold hidden sm:block">{{ auth()->user()->name ?? 'Administrator' }}</span>
            </div>
        </div>
    </header>

    <!-- Main Content Canvas -->
    <main class="flex-1 md:ml-[300px] mt-16 p-xl overflow-y-auto custom-scrollbar h-[calc(100vh-4rem)] w-full">
        @yield('content')
    </main>

    <script>
        document.querySelectorAll('.active\\:scale-95').forEach(el => {
            el.addEventListener('mousedown', function () {
                this.classList.add('scale-95');
            });
            el.addEventListener('mouseup', function () {
                this.classList.remove('scale-95');
            });
            el.addEventListener('mouseleave', function () {
                this.classList.remove('scale-95');
            });
        });
    </script>

    @stack('scripts')
</body>

</html>