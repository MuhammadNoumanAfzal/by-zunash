@props(['badge'])

@if($badge)
    @php
        $badgeStyles = [
            'Bestseller' => 'bg-espresso text-gold border-gold/40',
            'New Arrival' => 'bg-gold-50 text-chocolate-700 border-gold/30',
            'Limited Edition' => 'bg-chocolate-900 text-ivory border-tan/30',
            'Handcrafted' => 'bg-ivory-200 text-espresso border-muted-light/30',
            'Sold Out' => 'bg-rose-900/90 text-rose-100 border-rose-700/60 font-semibold',
            'Out of Stock' => 'bg-rose-900/90 text-rose-100 border-rose-700/60 font-semibold',
            'On Demand' => 'bg-amber-950/95 text-amber-200 border-amber-600/50 font-semibold',
            'Bespoke' => 'bg-gold-500 text-espresso-950 border-gold-600 font-bold',
        ];
        $style = $badgeStyles[$badge] ?? 'bg-espresso text-gold border-gold/30';
    @endphp

    <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] uppercase tracking-wider font-medium border rounded-full backdrop-blur-md shadow-xs {{ $style }}">
        {{ $badge }}
    </span>
@endif
