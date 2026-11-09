<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atelier Executive Login | By Zunash Control Center</title>

    <!-- Google Fonts: Cinzel, Cormorant Garamond, Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
                        cinzel: ['"Cinzel"', 'serif'],
                        serif: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
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
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-espresso-900 to-espresso-800 text-white mx-auto flex items-center justify-center shadow-lg border border-gold-400/30 mb-4">
                    <span class="font-cinzel text-xl font-bold tracking-widest text-gold-400">BZ</span>
                </div>
                <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-900 tracking-wider">
                    BY ZUNASH
                </h1>
                <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-tan-600 mt-1">
                    Atelier Control Center • Artisanal Leather
                </p>
                <div class="h-0.5 w-16 bg-gradient-to-r from-transparent via-gold-400 to-transparent mx-auto mt-3"></div>
            </div>

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
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4 relative z-10">
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
                            value="{{ old('email', 'admin@byzunash.com') }}" 
                            required 
                            autofocus
                            placeholder="admin@byzunash.com"
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
                        <span class="text-[10px] text-tan-600 font-medium">Encrypted TLS</span>
                    </div>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-[#A89C91] absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="password" 
                            id="admin-password" 
                            name="password" 
                            value="password"
                            required 
                            placeholder="••••••••"
                            class="w-full pl-10 pr-4 py-2.5 text-xs rounded-xl bg-[#FAF8F5] border border-[#E0D7CB] focus:outline-hidden focus:border-tan-500 focus:bg-white transition-all text-espresso-900"
                        >
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-[#7A6E64]">
                        <input type="checkbox" name="remember" class="rounded border-[#DFD6CB] text-tan-600 focus:ring-tan-500" checked>
                        <span>Keep me authenticated</span>
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
        lucide.createIcons();
    </script>

</body>
</html>
