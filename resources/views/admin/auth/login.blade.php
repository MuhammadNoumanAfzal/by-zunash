<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atelier Executive Login | By Zunash Control Center</title>

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Tailwind Play CDN & Lucide -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        espresso: {
                            50: '#F5F5F5',
                            100: '#E8E6E3',
                            200: '#D2CEC8',
                            300: '#A9A39A',
                            400: '#736B61',
                            700: '#2A201A',
                            800: '#1C1512',
                            900: '#120E0C',
                            950: '#0A0807',
                        },
                        tan: {
                            400: '#C99E74',
                            500: '#B07D4E',
                            600: '#976239',
                            700: '#7A4B27',
                        },
                        gold: {
                            300: '#DAC694',
                            400: '#C5A16B',
                            500: '#B38D4F',
                        }
                    },
                    fontFamily: {
                        cinzel: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                        serif: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body, button, input, select, textarea {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .font-cinzel {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            letter-spacing: -0.015em;
        }
    </style>
</head>
<body class="bg-[#FAF8F5] text-espresso-900 font-sans min-h-screen flex items-center justify-center p-4 selection:bg-gold-400 selection:text-white">

    <div class="w-full max-w-md">

        <!-- Luxury Card Container -->
        <div class="bg-white rounded-3xl border border-[#ECE6DE] shadow-2xl p-8 sm:p-10 relative overflow-hidden">
            
            <!-- Top Gradient Accent Bar (Espresso to Cognac to Gold) -->
            <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-espresso-900 via-tan-600 to-gold-400"></div>
            
            <!-- Ambient Background Glows -->
            <div class="absolute -top-16 -right-16 w-44 h-44 bg-tan-500/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-44 h-44 bg-gold-400/15 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Brand Header -->
            <div class="text-center mb-8 relative z-10">
                <div class="relative flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-espresso-950 via-espresso-900 to-chocolate-800 border border-gold/50 shadow-xl text-gold mx-auto mb-4">
                    <svg viewBox="0 0 100 100" class="w-10 h-10 fill-none stroke-current" stroke-linecap="round" stroke-linejoin="round">
                        <!-- Background subtle ring -->
                        <circle cx="50" cy="50" r="38" stroke="currentColor" stroke-width="1.5" stroke-dasharray="2 3" opacity="0.6"/>
                        <!-- Antique Gold Intertwined Loop -->
                        <ellipse cx="50" cy="50" rx="34" ry="18" transform="rotate(-30 50 50)" stroke="url(#loginGoldGrad)" stroke-width="2.5" fill="none" opacity="0.85"/>
                        <!-- Luxury Serif Z -->
                        <path d="M30 30 H68 L32 70 H70" stroke="url(#loginGoldGradLight)" stroke-width="7" stroke-linecap="square"/>
                        <defs>
                            <linearGradient id="loginGoldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#E4D5B1" />
                                <stop offset="50%" stop-color="#C5A16B" />
                                <stop offset="100%" stop-color="#94703B" />
                            </linearGradient>
                            <linearGradient id="loginGoldGradLight" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#FFFFFF" />
                                <stop offset="40%" stop-color="#E4D5B1" />
                                <stop offset="100%" stop-color="#C5A16B" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="flex items-center justify-center gap-1.5 -mb-0.5">
                    <span class="h-[0.5px] w-3 bg-gold/80"></span>
                    <span class="text-[9px] tracking-[0.28em] uppercase font-cinzel font-semibold text-gold-600">BY</span>
                    <span class="h-[0.5px] w-3 bg-gold/80"></span>
                </div>
                <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-900 tracking-wider">
                    ZUNASH
                </h1>
                <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-tan-600 mt-1">
                    Atelier Control Center • Artisanal Leather
                </p>
                <div class="h-0.5 w-16 bg-gradient-to-r from-transparent via-gold-400 to-transparent mx-auto mt-3"></div>
            </div>

            <!-- Session Flash Alerts -->
            @if(session('error'))
                <div class="mb-5 p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-xs text-amber-900 flex items-start gap-2.5">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-600 shrink-0 mt-0.5"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-xs text-rose-800 flex items-start gap-2.5">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-600 shrink-0 mt-0.5"></i>
                    <div>
                        @foreach($errors->all() as $err)
                            <div>{{ $err }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4 relative z-10" autocomplete="off">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-xs font-semibold text-espresso-900 mb-1.5" for="admin-email">
                        Executive Atelier Email
                    </label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-4 h-4 text-[#A89C91] absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="email" 
                            id="admin-email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                            autocomplete="username"
                            spellcheck="false"
                            placeholder="Enter executive email address"
                            class="w-full pl-10 pr-4 py-2.5 text-xs rounded-xl bg-[#FAF8F5] border border-[#E0D7CB] focus:outline-hidden focus:border-tan-500 focus:bg-white transition-all text-espresso-900"
                        >
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-semibold text-espresso-900" for="admin-password">
                            Password
                        </label>
                        <span class="text-[10px] text-tan-600 font-medium flex items-center gap-1">
                            <i data-lucide="shield-check" class="w-3 h-3 text-gold-500"></i>
                            <span>Encrypted TLS</span>
                        </span>
                    </div>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-[#A89C91] absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="password" 
                            id="admin-password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            placeholder="Enter secure password"
                            class="w-full pl-10 pr-10 py-2.5 text-xs rounded-xl bg-[#FAF8F5] border border-[#E0D7CB] focus:outline-hidden focus:border-tan-500 focus:bg-white transition-all text-espresso-900"
                        >
                        <button 
                            type="button" 
                            onclick="togglePasswordVisibility()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-espresso-900 focus:outline-none p-1 cursor-pointer"
                            tabindex="-1"
                            aria-label="Toggle password visibility"
                        >
                            <i data-lucide="eye" id="eye-icon" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-[#7A6E64] select-none">
                        <input type="checkbox" name="remember" class="rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500">
                        <span>Keep me authenticated on this device</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-3 px-4 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs tracking-wider uppercase shadow-md hover:shadow-lg transition-all duration-200 active:scale-98 flex items-center justify-center gap-2 border border-gold-400/20"
                >
                    <span>Authenticate By Zunash Access</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 text-gold-400"></i>
                </button>
            </form>

            <!-- Return to Live Storefront -->
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-[#8F8379] hover:text-tan-600 transition-colors">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Return to By Zunash Storefront</span>
                </a>
            </div>

        </div>

    </div>

    <script>
        function togglePasswordVisibility() {
            const input = document.getElementById('admin-password');
            const icon = document.getElementById('eye-icon');
            if (input) {
                const isPass = input.type === 'password';
                input.type = isPass ? 'text' : 'password';
                if (icon) {
                    icon.setAttribute('data-lucide', isPass ? 'eye-off' : 'eye');
                    if (window.lucide) {
                        lucide.createIcons();
                    }
                }
            }
        }
        lucide.createIcons();
    </script>

</body>
</html>
