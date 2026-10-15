@props([
    'variant' => 'full', // 'full', 'compact', 'white'
    'height' => 'h-10'
])

<a href="{{ route('home') }}" class="group inline-flex items-center gap-3 transition-opacity duration-300 hover:opacity-90 focus:outline-none">
    @if(file_exists(public_path('images/logo.png')))
        <img src="{{ asset('images/logo.png') }}" alt="By Zunash Luxury Leather" class="{{ $height }} w-auto object-contain">
    @else
        <!-- Refined By Zunash Luxury Typographic & Emblem Mark -->
        <div class="flex items-center gap-2.5">
            <!-- Monogram Emblem -->
            <div class="relative flex items-center justify-center w-9 h-9 rounded-full bg-gradient-to-br from-espresso-900 via-chocolate-800 to-espresso-950 border border-gold/40 shadow-sm text-gold">
                <svg viewBox="0 0 100 100" class="w-6 h-6 fill-none stroke-current" stroke-linecap="round" stroke-linejoin="round">
                    <!-- Background subtle ring -->
                    <circle cx="50" cy="50" r="38" stroke="currentColor" stroke-width="1.5" stroke-dasharray="2 3" opacity="0.6"/>
                    <!-- Antique Gold Intertwined Loop -->
                    <ellipse cx="50" cy="50" rx="34" ry="18" transform="rotate(-30 50 50)" stroke="url(#goldGradient)" stroke-width="2.5" fill="none" opacity="0.85"/>
                    <!-- Luxury Serif Z -->
                    <path d="M30 30 H68 L32 70 H70" stroke="url(#goldGradientLight)" stroke-width="7" stroke-linecap="square"/>
                    <defs>
                        <linearGradient id="goldGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#E4D5B1" />
                            <stop offset="50%" stop-color="#C5A16B" />
                            <stop offset="100%" stop-color="#94703B" />
                        </linearGradient>
                        <linearGradient id="goldGradientLight" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#FFFFFF" />
                            <stop offset="40%" stop-color="#E4D5B1" />
                            <stop offset="100%" stop-color="#C5A16B" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>

            <!-- Typographic Lockup -->
            <div class="flex flex-col">
                <div class="flex items-center justify-center gap-1.5 -mb-0.5">
                    <span class="h-[0.5px] w-3 {{ $variant === 'white' ? 'bg-gold/60' : 'bg-gold/80' }}"></span>
                    <span class="text-[9px] tracking-[0.28em] uppercase font-cinzel font-semibold {{ $variant === 'white' ? 'text-gold-200' : 'text-gold-600' }}">BY</span>
                    <span class="h-[0.5px] w-3 {{ $variant === 'white' ? 'bg-gold/60' : 'bg-gold/80' }}"></span>
                </div>
                <span class="font-cinzel tracking-[0.22em] text-[17px] font-bold uppercase leading-none {{ $variant === 'white' ? 'text-ivory' : 'text-espresso-950' }} group-hover:text-gold transition-colors">
                    ZUNASH
                </span>
            </div>
        </div>
    @endif
</a>
