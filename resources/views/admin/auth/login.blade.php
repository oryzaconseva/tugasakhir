<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Millennia Internship Portal | Sign In</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-container": "#501300",
                        "on-secondary-fixed": "#40000a",
                        "on-background": "#1a1b20",
                        "secondary": "#b71032",
                        "on-tertiary-container": "#d37758",
                        "surface-dim": "#dad9e0",
                        "on-primary": "#ffffff",
                        "primary-fixed": "#dbe1ff",
                        "on-error": "#ffffff",
                        "primary": "#00113a",
                        "inverse-surface": "#2f3035",
                        "inverse-on-surface": "#f1f0f6",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-fixed-dim": "#ffb59e",
                        "secondary-container": "#da3148",
                        "surface-bright": "#faf8ff",
                        "on-primary-fixed-variant": "#2a4386",
                        "on-primary-fixed": "#00174a",
                        "surface-container": "#efedf3",
                        "outline": "#757682",
                        "error": "#ba1a1a",
                        "surface-container-low": "#f4f3f9",
                        "surface-variant": "#e3e2e8",
                        "on-primary-container": "#758dd5",
                        "on-secondary-fixed-variant": "#920023",
                        "primary-container": "#002366",
                        "on-tertiary-fixed-variant": "#783018",
                        "background": "#faf8ff",
                        "secondary-fixed-dim": "#ffb3b4",
                        "primary-fixed-dim": "#b3c5ff",
                        "inverse-primary": "#b3c5ff",
                        "secondary-fixed": "#ffdad9",
                        "on-error-container": "#93000a",
                        "on-secondary-container": "#fffbff",
                        "tertiary": "#2d0700",
                        "on-tertiary-fixed": "#390b00",
                        "on-tertiary": "#ffffff",
                        "on-surface-variant": "#444650",
                        "error-container": "#ffdad6",
                        "on-secondary": "#ffffff",
                        "surface-container-high": "#e9e7ee",
                        "tertiary-fixed": "#ffdbd0",
                        "surface-tint": "#435b9f",
                        "outline-variant": "#c5c6d2",
                        "surface": "#faf8ff",
                        "on-surface": "#1a1b20",
                        "surface-container-highest": "#e3e2e8"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "xs": "4px",
                        "margin-mobile": "16px",
                        "base": "4px",
                        "xl": "32px",
                        "md": "16px",
                        "gutter-mobile": "12px",
                        "sm": "8px",
                        "lg": "24px"
                    },
                    "fontFamily": {
                        "label-md": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "headline-md": ["Inter"],
                        "body-md": ["Inter"],
                        "display-lg": ["Inter"],
                        "headline-lg": ["Inter"],
                        "body-lg": ["Inter"]
                    },
                    "fontSize": {
                        "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500" }],
                        "headline-lg-mobile": ["22px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "headline-md": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "display-lg": ["30px", { "lineHeight": "38px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "headline-lg": ["24px", { "lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }]
                    }
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .hero-gradient {
            background: linear-gradient(135deg, rgba(0, 17, 58, 0.9) 0%, rgba(0, 35, 102, 0.75) 100%);
        }

        .login-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>

<body class="bg-surface selection:bg-primary-fixed selection:text-on-primary-fixed overflow-hidden">
    <main class="min-h-screen w-full flex flex-col md:flex-row">
        <!-- Left Side: Hero Section -->
        <section class="hidden md:flex md:w-1/2 relative overflow-hidden group">
            <div class="absolute inset-0 z-0 scale-105 group-hover:scale-110 transition-transform duration-[10000ms] ease-out">
                <img class="w-full h-full object-cover" data-alt="Professional IT teamwork and mentorship environment at Millennia Solusi Informatika." src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1200&q=80">
            </div>
            <div class="absolute inset-0 z-10 hero-gradient backdrop-blur-[2px]"></div>
            <div class="relative z-20 flex flex-col justify-center px-xl lg:px-24 w-full h-full">
                <div class="mb-lg">
                    <span class="inline-block px-md py-xs bg-secondary-container text-on-secondary-container font-label-md text-label-md rounded-full uppercase tracking-widest mb-md">
                        Millennia Internship
                    </span>
                    <h1 class="font-display-lg text-[48px] leading-[1.1] text-white max-w-lg mb-md">Developing the Future IT Experts</h1>
                    <p class="font-body-lg text-body-lg text-primary-fixed-dim max-w-md opacity-90">The official management portal for Millennia Solusi Informatika mentors and administrators.</p>
                </div>
            </div>
            <!-- Footer for Left Side (Branding/Copyright) -->
            <div class="absolute bottom-xl left-xl z-20 text-white/50 font-label-md text-label-md">
                © 2024 Millennia Solusi Informatika. All rights reserved.
            </div>
        </section>
        <!-- Right Side: Login Form -->
        <section class="flex-1 flex flex-col justify-center items-center bg-surface-container-low px-margin-mobile md:px-xl relative">
            <!-- Mobile Logo Only -->
            <div class="md:hidden absolute top-lg left-margin-mobile">
                <img alt="Millennia Logo" class="h-10 w-auto object-contain" src="{{ asset('images/logo.png') }}">
            </div>
            <div class="w-full max-w-[420px]">
                <div class="bg-surface-container-lowest p-xl md:p-12 rounded-xl shadow-sm border border-outline-variant/30">
                    <!-- Branding Header -->
                    <div class="flex flex-col items-center mb-10">
                        <img alt="Millennia Logo" class="h-14 w-auto mb-md object-contain" src="{{ asset('images/logo.png') }}">
                        <div class="text-center">
                            <h2 class="font-headline-lg text-headline-lg text-on-background mb-base">Welcome to Millennia</h2>
                            <p class="font-body-md text-body-md text-on-surface-variant">Please sign in to access the Internship Portal.</p>
                        </div>
                    </div>

                    <!-- Error Notification -->
                    @if ($errors->any())
                        <div class="mb-6 flex items-start gap-3 p-4 bg-error/10 text-error rounded-xl border border-error/20 backdrop-blur-md">
                            <span class="material-symbols-outlined text-error mt-0.5">error</span>
                            <div class="flex flex-col">
                                <span class="text-xs font-semibold uppercase tracking-wider">Access Denied</span>
                                <span class="text-sm opacity-90">{{ $errors->first('email') ?: 'Invalid email or password.' }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('admin.login.post') }}" class="space-y-lg" method="POST">
                        @csrf
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface-variant mb-sm" for="email">Email Address</label>
                            <input class="w-full px-md py-lg rounded-lg border border-outline-variant bg-surface-bright focus:border-primary focus:ring-2 focus:ring-primary/10 font-body-md text-body-md outline-none transition-all placeholder:text-outline-variant" id="email" name="email" placeholder="name@company.com" required="" type="email" value="{{ old('email') }}">
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-sm">
                                <label class="block font-label-md text-label-md text-on-surface-variant" for="password">Password</label>
                                <a class="font-label-md text-label-md text-secondary hover:text-secondary-container transition-colors font-medium" href="#">Forgot Password?</a>
                            </div>
                            <div class="relative">
                                <input class="w-full px-md py-lg rounded-lg border border-outline-variant bg-surface-bright focus:border-primary focus:ring-2 focus:ring-primary/10 font-body-md text-body-md outline-none transition-all placeholder:text-outline-variant" id="password" name="password" placeholder="••••••••" required="" type="password">
                            </div>
                        </div>
                        <div class="flex items-center space-x-sm mb-md">
                            <input class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary" id="remember" type="checkbox" name="remember">
                            <label class="font-label-md text-label-md text-on-surface-variant cursor-pointer" for="remember">Keep me signed in</label>
                        </div>
                        <button class="w-full bg-primary-container text-on-secondary-container py-lg px-xl rounded-lg font-headline-md text-headline-md hover:bg-primary transition-all duration-200 flex justify-center items-center group active:scale-[0.98]" type="submit">
                            <span class="">Sign In</span>
                            <span class="material-symbols-outlined ml-sm group-hover:translate-x-1 transition-transform" data-icon="arrow_forward">arrow_forward</span>
                        </button>
                    </form>
                    <!-- Footer Link inside card (Mobile focused) -->
                    <div class="mt-lg pt-lg border-t border-outline-variant/30 text-center">
                        <p class="font-body-md text-body-md text-on-surface-variant">Don't have an account? <a class="text-primary font-semibold hover:underline" href="#">Register Account</a></p>
                    </div>
                </div>
                <!-- Global Footer Links -->
                <nav class="mt-xl flex flex-wrap justify-center gap-lg font-label-md text-label-md text-outline">
                    <a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
                    <a class="hover:text-primary transition-colors" href="#">Terms of Service</a>
                    <a class="hover:text-primary transition-colors" href="#">Help Center</a>
                </nav>
            </div>
        </section>
    </main>
    <!-- Micro-interaction script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    input.parentElement.classList.add('scale-[1.01]');
                });
                input.addEventListener('blur', () => {
                    input.parentElement.classList.remove('scale-[1.01]');
                });
            });
        });
    </script>
</body>

</html>