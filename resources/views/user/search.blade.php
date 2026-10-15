@extends('user.layouts.app')

@section('title', (!empty($query) ? 'Search: "' . $query . '"' : 'Search Catalog') . ' | By Zunash Luxury Leather')
@section('meta_description', 'Search handcrafted Pakistani leather belts, bifold wallets, handbags, and accessories at By Zunash.')
@section('robots', 'noindex, follow')
@section('canonical', route('search'))

@section('content')
<div class="bg-white min-h-screen py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Search Input Bar -->
        <div class="max-w-2xl mx-auto text-center mb-12">
            <span class="text-gold-600 text-xs uppercase tracking-widest font-serif font-bold">Catalog Search</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-900 mt-2 mb-6">
                Find Your Leather Companion
            </h1>

            <form action="{{ route('search') }}" method="GET" class="relative flex items-center">
                <i data-lucide="search" class="absolute left-4 w-5 h-5 text-muted pointer-events-none"></i>
                <input 
                    type="search" 
                    name="q" 
                    value="{{ $query }}" 
                    placeholder="Search by product name, leather type, or category..." 
                    class="w-full pl-12 pr-28 py-3.5 bg-ivory-50 border border-ivory-300 rounded-xl text-sm text-espresso-900 placeholder-muted focus:outline-none focus:ring-2 focus:ring-gold/60 focus:border-gold"
                    autofocus
                >
                <button 
                    type="submit" 
                    class="absolute right-2 px-5 py-2 bg-espresso hover:bg-chocolate-700 text-ivory text-xs uppercase tracking-wider font-semibold rounded-lg shadow-sm transition-all"
                >
                    Search
                </button>
            </form>
        </div>

        <!-- Results Counter & Status -->
        <div class="mb-8 pb-4 border-b border-ivory-200 flex items-center justify-between">
            <div>
                @if(!empty($query))
                    <h2 class="font-serif text-lg font-bold text-espresso-900">
                        Results for <span class="italic text-chocolate-700">"{{ $query }}"</span> ({{ count($products) }})
                    </h2>
                @else
                    <h2 class="font-serif text-lg font-bold text-espresso-900">
                        Enter a keyword above to search our catalog
                    </h2>
                @endif
            </div>

            <a href="{{ route('shop') }}" class="text-xs uppercase tracking-wider text-muted hover:text-gold-600 flex items-center gap-1 font-medium">
                <span>View All Creations</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <!-- Product Grid or Empty State -->
        @if(count($products) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <x-user.components.product-card :product="$product" />
                @endforeach
            </div>
        @else
            <!-- No Results State -->
            <div class="bg-ivory-50 rounded-2xl border border-ivory-300 p-12 text-center max-w-lg mx-auto shadow-xs my-8">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-ivory-200 flex items-center justify-center text-muted">
                    <i data-lucide="search" class="w-8 h-8"></i>
                </div>
                <h3 class="font-serif text-xl font-bold text-espresso-900 mb-2">
                    No results found
                </h3>
                <p class="text-xs text-muted leading-relaxed mb-6">
                    @if(!empty($query))
                        We couldn't find any leather goods matching "{{ $query }}". Please check your spelling or explore our popular collections.
                    @else
                        Try searching for "Reversible Belt", "Bifold Wallet", "Satchel", or "Passport Folio".
                    @endif
                </p>

                <div class="flex flex-wrap justify-center gap-2 mb-8">
                    <a href="{{ route('category', 'belts') }}" class="px-3 py-1.5 bg-white border border-ivory-300 rounded-full text-xs text-espresso-800 hover:border-gold">Leather Belts</a>
                    <a href="{{ route('category', 'wallets') }}" class="px-3 py-1.5 bg-white border border-ivory-300 rounded-full text-xs text-espresso-800 hover:border-gold">Wallets</a>
                    <a href="{{ route('category', 'handbags') }}" class="px-3 py-1.5 bg-white border border-ivory-300 rounded-full text-xs text-espresso-800 hover:border-gold">Handbags</a>
                    <a href="{{ route('category', 'accessories') }}" class="px-3 py-1.5 bg-white border border-ivory-300 rounded-full text-xs text-espresso-800 hover:border-gold">Key Fobs & Folios</a>
                </div>

                <a 
                    href="{{ route('shop') }}" 
                    class="inline-flex items-center gap-2 px-8 py-3 bg-espresso hover:bg-chocolate-700 text-ivory text-xs uppercase tracking-widest font-semibold rounded-lg shadow-sm transition-all"
                >
                    <span>Browse All Products</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        @endif

    </div>
</div>
@endsection
