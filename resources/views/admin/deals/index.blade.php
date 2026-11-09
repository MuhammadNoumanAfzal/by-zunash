@extends('admin.layouts.app')

@section('title', 'Atelier Deals & Bundles | By Zunash Control Center')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <h1 class="font-cinzel text-2xl sm:text-3xl font-bold text-espresso-950 dark:text-white">
                    Deals & Curated Sets
                </h1>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-widest bg-gold/15 text-gold-700 border border-gold/30">
                    Bundles Module
                </span>
            </div>
            <p class="text-xs text-[#8F8379] dark:text-[#A09387] mt-1">
                Curate multi-product leather bundles, apply bundle discounts, and feature exclusive paired offers for your clients.
            </p>
        </div>

        <a 
            href="{{ route('admin.deals.create') }}" 
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md active:scale-95 transition-all self-start sm:self-center border border-gold-400/20"
        >
            <i data-lucide="plus" class="w-4 h-4 text-gold-400"></i>
            <span>Create New Deal</span>
        </a>
    </div>

    <!-- Quick Metrics -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[#8F8379]">Total Deals</div>
            <div class="font-cinzel text-2xl font-bold text-espresso-950 dark:text-white mt-1">{{ $stats['total'] }}</div>
        </div>
        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-600">Active Deals</div>
            <div class="font-cinzel text-2xl font-bold text-emerald-600 mt-1">{{ $stats['active'] }}</div>
        </div>
        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-gold-600">Featured Sets</div>
            <div class="font-cinzel text-2xl font-bold text-gold-600 mt-1">{{ $stats['featured'] }}</div>
        </div>
        <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-tan-600">Avg Patron Savings</div>
            <div class="font-cinzel text-2xl font-bold text-espresso-950 dark:text-white mt-1">
                <span class="text-xs text-gold-600">PKR</span> {{ number_format($stats['avg_savings']) }}
            </div>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="p-4 rounded-2xl bg-white dark:bg-[#1A1513] border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs">
        <form action="{{ route('admin.deals.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-grow w-full">
                <i data-lucide="search" class="w-4 h-4 text-[#A89C91] absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}"
                    placeholder="Search deals by title, tagline, or badge..." 
                    class="w-full pl-10 pr-4 py-2 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] dark:border-[#2C2420] text-espresso-900 dark:text-ivory focus:outline-hidden focus:border-tan-500"
                >
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <select 
                    name="status" 
                    class="flex-1 sm:w-auto py-2 px-3 text-xs rounded-xl bg-[#FAF8F5] dark:bg-[#120E0C] border border-[#E0D7CB] dark:border-[#2C2420] text-espresso-900 dark:text-ivory focus:outline-hidden focus:border-tan-500"
                >
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                </select>

                <button 
                    type="submit" 
                    class="px-4 py-2 text-xs font-semibold rounded-xl bg-tan-600 hover:bg-tan-700 text-white transition-colors shrink-0"
                >
                    Filter
                </button>

                @if(request()->hasAny(['q', 'status']))
                    <a 
                        href="{{ route('admin.deals.index') }}" 
                        class="p-2 text-[#8F8379] hover:text-espresso-950 dark:hover:text-white transition-colors"
                        title="Reset Filters"
                    >
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Deals Listing Table & Mobile Cards -->
    <div class="bg-white dark:bg-[#1A1513] rounded-2xl border border-[#ECE6DE] dark:border-[#2C2420] shadow-2xs overflow-hidden">
        @if($deals->count() > 0)
            
            <!-- Mobile Deal Cards (< 640px) -->
            <div class="block sm:hidden divide-y divide-[#ECE6DE] dark:divide-[#2C2420]">
                @foreach($deals as $deal)
                    <div class="p-4 hover:bg-[#FAF9F7] dark:hover:bg-[#201A17] transition-colors space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-ivory-100 dark:bg-black/30 border border-[#ECE6DE] dark:border-white/10 shrink-0 relative">
                                <img src="{{ asset($deal->image ?: 'images/brand/artisan-craft.jpg') }}" alt="{{ $deal->title }}" class="w-full h-full object-cover">
                                @if($deal->is_featured)
                                    <span class="absolute top-1 left-1 w-2.5 h-2.5 rounded-full bg-gold border border-black/30" title="Featured Deal"></span>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-1.5">
                                    <h3 class="font-serif text-sm font-bold text-espresso-950 dark:text-white truncate">
                                        {{ $deal->title }}
                                    </h3>
                                    <form action="{{ route('admin.deals.toggle', $deal) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase shrink-0 {{ $deal->is_active ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-300' : 'bg-zinc-100 text-zinc-500 border border-zinc-200' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $deal->is_active ? 'bg-emerald-500' : 'bg-zinc-400' }}"></span>
                                            {{ $deal->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </div>

                                @if($deal->tagline)
                                    <p class="text-[11px] text-[#8F8379] dark:text-[#A09387] truncate mt-0.5">
                                        {{ $deal->tagline }}
                                    </p>
                                @endif

                                <div class="flex items-center gap-2 mt-1">
                                    <span class="font-cinzel text-xs font-bold text-espresso-950 dark:text-white">
                                        PKR {{ number_format($deal->deal_price) }}
                                    </span>
                                    @if($deal->effective_original_price > $deal->deal_price)
                                        <span class="text-[10px] text-gray-400 line-through">
                                            {{ number_format($deal->effective_original_price) }}
                                        </span>
                                    @endif
                                    @if($deal->savings_amount > 0)
                                        <span class="text-[9px] font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-950/40 px-1.5 py-0.2 rounded">
                                            {{ $deal->savings_percentage }}% OFF
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 border-t border-[#F0EAE1] dark:border-[#28201C] flex items-center justify-between text-xs">
                            <span class="text-[11px] text-[#8F8379]">
                                {{ $deal->products->count() }} Handcrafted Items
                            </span>

                            <div class="flex items-center gap-2">
                                <a 
                                    href="{{ route('deal.details', $deal->slug) }}" 
                                    target="_blank"
                                    class="p-1.5 rounded-lg border border-[#DFD6CB] dark:border-[#382D27] text-gray-400 hover:text-tan-600"
                                    title="View Deal"
                                >
                                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                </a>

                                <a 
                                    href="{{ route('admin.deals.edit', $deal) }}" 
                                    class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-espresso-900 hover:bg-tan-600 text-white transition-colors"
                                >
                                    Edit
                                </a>

                                <form action="{{ route('admin.deals.destroy', $deal) }}" method="POST" onsubmit="return confirm('Remove Atelier Deal?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg border border-rose-200 text-rose-600 hover:bg-rose-50" title="Delete Deal">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop / Tablet Table View (>= 640px) -->
            <div class="hidden sm:block overflow-x-auto w-full max-w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-[#ECE6DE] dark:border-[#2C2420] bg-[#FAF8F5] dark:bg-[#120E0C] text-[10px] uppercase font-bold tracking-wider text-[#8F8379] dark:text-[#A09387]">
                            <th class="py-3.5 px-4 sm:px-6">Deal / Set</th>
                            <th class="py-3.5 px-4">Included Creations</th>
                            <th class="py-3.5 px-4">Pricing & Savings</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right pr-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#ECE6DE] dark:divide-[#2C2420] text-xs">
                        @foreach($deals as $deal)
                            <tr class="hover:bg-[#FAF9F7] dark:hover:bg-[#201A17] transition-colors">
                                <!-- Deal Name & Image -->
                                <td class="py-4 px-4 sm:px-6">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-14 h-14 rounded-xl overflow-hidden bg-ivory-100 dark:bg-black/30 border border-[#ECE6DE] dark:border-white/10 shrink-0 relative">
                                            <img 
                                                src="{{ asset($deal->image ?: 'images/brand/artisan-craft.jpg') }}" 
                                                alt="{{ $deal->title }}" 
                                                class="w-full h-full object-cover"
                                            >
                                            @if($deal->is_featured)
                                                <span class="absolute top-1 left-1 w-2 h-2 rounded-full bg-gold" title="Featured Deal"></span>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2">
                                                <h3 class="font-serif text-sm font-bold text-espresso-950 dark:text-white truncate">
                                                    {{ $deal->title }}
                                                </h3>
                                                @if($deal->badge)
                                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-gold-400/20 text-gold-700 dark:text-gold-300 border border-gold-400/30">
                                                        {{ $deal->badge }}
                                                    </span>
                                                @endif
                                            </div>
                                            @if($deal->tagline)
                                                <p class="text-[11px] text-[#8F8379] dark:text-[#A09387] truncate mt-0.5">
                                                    {{ $deal->tagline }}
                                                </p>
                                            @endif
                                            <div class="text-[10px] text-muted font-mono mt-0.5">
                                                /deals#{{ $deal->slug }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Included Creations -->
                                <td class="py-4 px-4">
                                    <div class="flex flex-col gap-1.5">
                                        <span class="text-[11px] font-semibold text-espresso-900 dark:text-ivory-200">
                                            {{ $deal->products->count() }} Handcrafted Items
                                        </span>
                                        <div class="flex items-center -space-x-2">
                                            @foreach($deal->products->take(4) as $p)
                                                <div class="w-8 h-8 rounded-lg overflow-hidden border-2 border-white dark:border-[#1A1513] shadow-xs relative" title="{{ $p->name }} (Qty: {{ $p->pivot->quantity }})">
                                                    <img src="{{ asset($p->image) }}" alt="{{ $p->name }}" class="w-full h-full object-cover">
                                                </div>
                                            @endforeach
                                            @if($deal->products->count() > 4)
                                                <div class="w-8 h-8 rounded-lg bg-ivory-200 text-espresso-900 font-bold text-[10px] flex items-center justify-center border-2 border-white dark:border-[#1A1513]">
                                                    +{{ $deal->products->count() - 4 }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Pricing -->
                                <td class="py-4 px-4">
                                    <div class="flex flex-col">
                                        <div class="flex items-baseline gap-1.5">
                                            <span class="font-cinzel text-sm font-bold text-espresso-950 dark:text-white">
                                                <span class="text-[10px] text-gold-600">PKR</span> {{ number_format($deal->deal_price) }}
                                            </span>
                                            @if($deal->effective_original_price > $deal->deal_price)
                                                <span class="text-[11px] text-[#A89C91] line-through">
                                                    {{ number_format($deal->effective_original_price) }}
                                                </span>
                                            @endif
                                        </div>
                                        @if($deal->savings_amount > 0)
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600 mt-0.5">
                                                <i data-lucide="trending-down" class="w-3 h-3"></i>
                                                <span>Save PKR {{ number_format($deal->savings_amount) }} ({{ $deal->savings_percentage }}% OFF)</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Status Toggle -->
                                <td class="py-4 px-4">
                                    <form action="{{ route('admin.deals.toggle', $deal) }}" method="POST">
                                        @csrf
                                        <button 
                                            type="submit" 
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider transition-colors {{ $deal->is_active ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-300' : 'bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400 border border-zinc-200' }}"
                                        >
                                            <span class="w-1.5 h-1.5 rounded-full {{ $deal->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-zinc-400' }}"></span>
                                            <span>{{ $deal->is_active ? 'Active' : 'Inactive' }}</span>
                                        </button>
                                    </form>
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-4 text-right pr-6">
                                    <div class="inline-flex items-center gap-1">
                                        <a 
                                            href="{{ route('deal.details', $deal->slug) }}" 
                                            target="_blank" 
                                            class="p-1.5 text-[#8F8379] hover:text-tan-600 transition-colors"
                                            title="View Deal Details Page"
                                        >
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                        </a>
                                        <a 
                                            href="{{ route('admin.deals.edit', $deal) }}" 
                                            class="p-1.5 text-[#8F8379] hover:text-tan-600 transition-colors"
                                            title="Edit Deal"
                                        >
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </a>
                                        <form 
                                            action="{{ route('admin.deals.destroy', $deal) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Remove Atelier Deal &quot;{{ $deal->title }}&quot;? Products will not be deleted.');"
                                            class="inline-block"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="p-1.5 text-[#8F8379] hover:text-rose-600 transition-colors"
                                                title="Delete Deal"
                                            >
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($deals->hasPages())
                <div class="p-4 border-t border-[#ECE6DE] dark:border-[#2C2420]">
                    {{ $deals->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="py-16 text-center px-4">
                <div class="w-16 h-16 rounded-2xl bg-gold/10 border border-gold/30 flex items-center justify-center text-gold-600 mx-auto mb-4">
                    <i data-lucide="package" class="w-8 h-8"></i>
                </div>
                <h3 class="font-cinzel text-lg font-bold text-espresso-950 dark:text-white">
                    No Atelier Deals Created Yet
                </h3>
                <p class="text-xs text-[#8F8379] dark:text-[#A09387] max-w-sm mx-auto mt-1 mb-5">
                    Bundle complementary leather goods together into signature deals and provide special pricing for your clientele.
                </p>
                <a 
                    href="{{ route('admin.deals.create') }}" 
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-espresso-900 hover:bg-tan-600 text-white font-semibold text-xs shadow-md transition-colors"
                >
                    <i data-lucide="plus" class="w-4 h-4 text-gold-400"></i>
                    <span>Create First Atelier Deal</span>
                </a>
            </div>
        @endif
    </div>

</div>
@endsection

