@props([
    'variant' => 'full', // 'full', 'compact', 'white'
    'height' => 'h-10 sm:h-12'
])

<a href="{{ route('home') }}" class="group inline-flex items-center gap-2.5 transition-all duration-300 hover:opacity-95 focus:outline-none" aria-label="By Zunash Luxury Leather Home">
    @if(file_exists(public_path('images/logo-dark-bg.png')) && file_exists(public_path('images/logo-transparent.png')))
        <!-- Light Mode Logo: Deep rich antique bronze-gold with contrast shadow for pure white backgrounds -->
        <picture class="inline-block dark:hidden">
            @if(file_exists(public_path('images/logo-dark-bg.webp')))
                <source srcset="{{ asset('images/logo-dark-bg.webp') }}" type="image/webp">
            @endif
            <img 
                src="{{ asset('images/logo-dark-bg.png') }}" 
                alt="By Zunash — Luxury at your door step" 
                class="{{ $height }} w-auto max-w-[210px] sm:max-w-[260px] object-contain drop-shadow-[0_2px_8px_rgba(0,0,0,0.18)] group-hover:scale-[1.03] transition-transform duration-300"
                loading="eager"
            >
        </picture>

        <!-- Dark Mode Logo: Radiant polished gold for dark espresso backgrounds -->
        <picture class="hidden dark:inline-block">
            @if(file_exists(public_path('images/logo-transparent.webp')))
                <source srcset="{{ asset('images/logo-transparent.webp') }}" type="image/webp">
            @endif
            <img 
                src="{{ asset('images/logo-transparent.png') }}" 
                alt="By Zunash — Luxury at your door step" 
                class="{{ $height }} w-auto max-w-[210px] sm:max-w-[260px] object-contain drop-shadow-[0_2px_12px_rgba(0,0,0,0.7)] group-hover:scale-[1.03] transition-transform duration-300"
                loading="eager"
            >
        </picture>
    @elseif(file_exists(public_path('images/logo-transparent.png')))
        <img 
            src="{{ asset('images/logo-transparent.png') }}" 
            alt="By Zunash Luxury Leather" 
            class="{{ $height }} w-auto max-w-[210px] sm:max-w-[260px] object-contain drop-shadow-[0_2px_10px_rgba(0,0,0,0.5)] group-hover:scale-[1.03] transition-transform duration-300"
            loading="eager"
        >
    @elseif(file_exists(public_path('images/logo.png')))
        <img src="{{ asset('images/logo.png') }}" alt="By Zunash Luxury Leather" class="{{ $height }} w-auto object-contain">
    @endif
</a>
