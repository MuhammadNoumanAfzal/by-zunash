@props(['badge'])

@if($badge)
    @php
        $badgeStyles = [
            'Bestseller' => 'bg-espresso text-gold border-gold/40',
            'New Arrival' => 'bg-gold-50 text-chocolate-700 border-gold/30',
            'Limited Edition' => 'bg-chocolate-900 text-ivory border-tan/30',
            'Handcrafted' => 'bg-ivory-200 text-espresso border-muted-light/30',
        ];
        $style = $badgeStyles[$badge] ?? 'bg-espresso text-gold border-gold/30';
    @endphp

    <span class="inline-flex items-center px-2.5 py-0.5 text-[10px] uppercase tracking-wider font-medium border rounded-full backdrop-blur-md shadow-xs {{ $style }}">
        {{ $badge }}
    </span>
@endif
