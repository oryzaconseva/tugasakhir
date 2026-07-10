<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>MSI Internship Portal - Masuk</title>
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <!-- Material Symbols -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet">
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
                        "label-md": ["Poppins", "sans-serif"],
                        "headline-lg-mobile": ["Poppins", "sans-serif"],
                        "headline-md": ["Poppins", "sans-serif"],
                        "body-md": ["Poppins", "sans-serif"],
                        "display-lg": ["Poppins", "sans-serif"],
                        "headline-lg": ["Poppins", "sans-serif"],
                        "body-lg": ["Poppins", "sans-serif"]
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
            font-family: 'Poppins', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .hero-gradient {
            background: linear-gradient(135deg, rgba(0, 17, 58, 0.93) 0%, rgba(0, 23, 70, 0.82) 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.45);
            box-shadow: 0 12px 40px 0 rgba(0, 17, 58, 0.08);
        }

        .glow-blob {
            position: absolute;
            width: 450px;
            height: 450px;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.16;
            z-index: 0;
            pointer-events: none;
            animation: float-blob 22s infinite alternate ease-in-out;
        }

        .glow-blob-1 {
            background: #435b9f;
            top: -120px;
            right: -120px;
        }

        .glow-blob-2 {
            background: #b71032;
            bottom: -120px;
            left: -120px;
            animation-delay: -11s;
        }

        @keyframes float-blob {
            0% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(50px, 40px) scale(1.12);
            }

            100% {
                transform: translate(-30px, -50px) scale(0.92);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .input-glow:focus-within {
            box-shadow: 0 0 0 4px rgba(0, 35, 102, 0.08);
        }
    </style>
</head>

<body class="bg-surface selection:bg-primary-fixed selection:text-on-primary-fixed overflow-hidden">
    <main class="min-h-screen w-full flex flex-col md:flex-row">
        <!-- Left Side: Hero Section -->
        <section class="hidden md:flex md:w-1/2 relative overflow-hidden group">
            <div
                class="absolute inset-0 z-0 scale-105 group-hover:scale-110 transition-transform duration-[10000ms] ease-out">
                <img class="w-full h-full object-cover"
                    data-alt="Professional IT teamwork and mentorship environment at Millennia Solusi Informatika."
                    src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1200&q=80">
            </div>
            <div class="absolute inset-0 z-10 hero-gradient backdrop-blur-[2px]"></div>
            <div class="relative z-20 flex flex-col justify-center px-xl lg:px-24 w-full h-full animate-fade-in-up">
                <div class="mb-lg">
                    <span
                        class="inline-block px-md py-xs bg-secondary-container text-on-secondary-container font-label-md text-label-md rounded-full uppercase tracking-widest mb-md shadow-sm">
                        Millennia Internship
                    </span>
                    <h1
                        class="font-display-lg text-[48px] leading-[1.1] text-white max-w-lg mb-md font-bold tracking-tight">
                        Membentuk<br>Ahli IT Masa Depan</h1>
                    <p class="font-body-lg text-body-lg text-primary-fixed-dim max-w-md opacity-90 leading-relaxed">
                        Portal
                        magang resmi untuk admin Millennia Solusi Informatika.</p>
                </div>
            </div>
            <!-- Footer for Left Side (Branding/Copyright) -->
            <div class="absolute bottom-xl left-xl z-20 text-white/50 font-label-md text-label-md">
                © 2024 Millennia Solusi Informatika. Semua hak dilindungi.
            </div>
        </section>
        <!-- Right Side: Login Form -->
        <section
            class="flex-1 flex flex-col justify-center items-center bg-surface-container-low px-margin-mobile md:px-xl relative overflow-hidden">
            <!-- Glowing background elements -->
            <div class="glow-blob glow-blob-1"></div>
            <div class="glow-blob glow-blob-2"></div>

            <!-- Mobile Logo Only -->
            <div class="md:hidden absolute top-lg left-margin-mobile z-10">
                <img alt="Millennia Logo" class="h-10 w-auto object-contain" src="{{ asset('images/logo.png') }}">
            </div>

            <div class="w-full max-w-[440px] z-10 animate-fade-in-up">
                <!-- Glassmorphic Card Container -->
                <div class="glass-card p-xl md:p-10 rounded-2xl border border-white/40">
                    <!-- Branding Header -->
                    <div class="flex flex-col items-center mb-8">
                        <div
                            class="p-3 bg-white/60 rounded-2xl shadow-sm border border-outline-variant/20 mb-4 transition-transform hover:scale-105 duration-300">
                            <img alt="Millennia Logo" class="h-12 w-auto object-contain"
                                src="{{ asset('images/logo.png') }}">
                        </div>
                        <div class="text-center">
                            <h2
                                class="font-headline-lg text-headline-lg text-on-background mb-1 font-semibold tracking-tight">
                                Selamat Datang di Millennia</h2>
                            <p class="font-body-md text-body-md text-on-surface-variant/80">Silakan masuk untuk
                                mengakses Portal Magang.</p>
                        </div>
                    </div>

                    <!-- Error Notification -->
                    @if ($errors->any())
                        <div
                            class="mb-6 flex items-start gap-3 p-4 bg-error/10 text-error rounded-xl border border-error/20 backdrop-blur-md animate-fade-in-up">
                            <span class="material-symbols-outlined text-error mt-0.5">error</span>
                            <div class="flex flex-col text-left">
                                <span class="text-xs font-semibold uppercase tracking-wider">Akses Ditolak</span>
                                <span
                                    class="text-sm opacity-90">{{ $errors->first('email') ?: 'Email atau kata sandi tidak valid.' }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('admin.login.post') }}" class="space-y-6" method="POST" id="loginForm">
                        @csrf
                        <!-- Email Address -->
                        <div class="space-y-2">
                            <label class="block font-label-md text-label-md text-on-surface-variant font-medium"
                                for="email">Alamat Email</label>
                            <div class="relative group input-glow rounded-xl transition-all duration-300">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline/70 group-focus-within:text-primary transition-colors text-[20px]">mail</span>
                                <input
                                    class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-outline-variant bg-white/70 backdrop-blur-sm focus:border-primary focus:ring-0 font-body-md text-body-md outline-none transition-all placeholder:text-outline-variant/60 shadow-sm"
                                    id="email" name="email" placeholder="intern@millennia-solusi.id" required=""
                                    type="email" value="{{ old('email') }}">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <label class="block font-label-md text-label-md text-on-surface-variant font-medium"
                                    for="password">Kata Sandi</label>
                                <a class="font-label-md text-label-md text-secondary hover:text-secondary-container transition-colors font-semibold"
                                    href="#">Lupa Kata Sandi?</a>
                            </div>
                            <div class="relative group input-glow rounded-xl transition-all duration-300">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline/70 group-focus-within:text-primary transition-colors text-[20px]">lock</span>
                                <input
                                    class="w-full pl-11 pr-12 py-3.5 rounded-xl border border-outline-variant bg-white/70 backdrop-blur-sm focus:border-primary focus:ring-0 font-body-md text-body-md outline-none transition-all placeholder:text-outline-variant/60 shadow-sm"
                                    id="password" name="password" placeholder="••••••••" required="" type="password">
                                <button type="button" id="togglePassword"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-outline/70 hover:text-on-surface-variant transition-colors flex items-center justify-center p-1 rounded-full hover:bg-black/5">
                                    <span class="material-symbols-outlined text-[20px]"
                                        id="passwordIcon">visibility</span>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me & Keep Signed In -->
                        <div class="flex items-center space-x-2">
                            <input
                                class="w-4.5 h-4.5 rounded border-outline-variant text-primary focus:ring-primary/20 bg-white/50 cursor-pointer"
                                id="remember" type="checkbox" name="remember">
                            <label
                                class="font-label-md text-label-md text-on-surface-variant/80 cursor-pointer font-medium select-none"
                                for="remember">Ingat perangkat ini</label>
                        </div>

                        <!-- Submit Button -->
                        <button
                            class="w-full bg-gradient-to-r from-primary-container to-primary text-white py-3.5 px-6 rounded-xl font-headline-md text-headline-md hover:shadow-lg hover:shadow-primary/20 hover:scale-[1.01] active:scale-[0.98] transition-all duration-200 flex justify-center items-center group cursor-pointer"
                            type="submit">
                            <span>Masuk</span>
                            <span
                                class="material-symbols-outlined ml-2 group-hover:translate-x-1 transition-transform text-[20px]"
                                data-icon="arrow_forward">arrow_forward</span>
                        </button>
                    </form>


                </div>

                <!-- Global Footer Links -->
                <nav
                    class="mt-8 flex flex-wrap justify-center gap-x-6 gap-y-2 font-label-md text-label-md text-outline/80">
                    <a class="hover:text-primary transition-colors flex items-center gap-1" href="#">
                        <span class="material-symbols-outlined text-[14px]">help</span>
                        Pusat Bantuan
                    </a>
                </nav>
            </div>
        </section>
    </main>

    <!-- Interactive logic & Micro-interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

            if (togglePassword && passwordInput && passwordIcon) {
                togglePassword.addEventListener('click', () => {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    passwordIcon.textContent = type === 'password' ? 'visibility' : 'visibility_off';
                });
            }

            // Add soft scale effect on input focus
            const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
            inputs.forEach(input => {
                const container = input.closest('.relative');
                if (container) {
                    input.addEventListener('focus', () => {
                        container.classList.add('scale-[1.015]');
                    });
                    input.addEventListener('blur', () => {
                        container.classList.remove('scale-[1.015]');
                    });
                }
            });
            // Pesan validasi HTML5 dalam bahasa Indonesia
            const validationMessages = {
                email: {
                    valueMissing: 'Alamat email wajib diisi.',
                    typeMismatch: 'Masukkan alamat email yang valid.',
                },
                password: {
                    valueMissing: 'Kata sandi wajib diisi.',
                },
            };

            document.querySelectorAll('input[required]').forEach(input => {
                input.addEventListener('invalid', (e) => {
                    const messages = validationMessages[input.name] || {};
                    if (input.validity.valueMissing) {
                        input.setCustomValidity(messages.valueMissing || 'Field ini wajib diisi.');
                    } else if (input.validity.typeMismatch) {
                        input.setCustomValidity(messages.typeMismatch || 'Format tidak valid.');
                    } else {
                        input.setCustomValidity('');
                    }
                });
                input.addEventListener('input', () => input.setCustomValidity(''));
            });
        });
    </script>
</body>

</html>