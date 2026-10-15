@extends('user.layouts.app')

@section('title', $category['name'] . ' | Luxury Leather Pakistan | By Zunash')
@section('meta_description', $category['tagline'] . ' Handcrafted pure full-grain ' . $category['name'] . ' with nationwide delivery and Cash on Delivery across Pakistan.')
@section('meta_keywords', $category['name'] . ' Pakistan, pure leather ' . $category['name'] . ', buy ' . $category['name'] . ' online Lahore Karachi Islamabad, By Zunash')
@section('canonical', route('category', $category['slug']))
@section('og_image', $category['image'])

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "CollectionPage",
            "@id": "{{ route('category', $category['slug']) }}/#collection",
            "name": "{{ addslashes($category['name']) }}",
            "description": "{{ addslashes($category['tagline']) }}",
            "url": "{{ route('category', $category['slug']) }}",
            "mainEntity": {
                "@type": "ItemList",
                "itemListElement": [
                    @foreach($products as $idx => $item)
                    {
                        "@type": "ListItem",
                        "position": {{ $loop->iteration }},
                        "url": "{{ route('product.details', $item['slug']) }}",
                        "name": "{{ addslashes($item['name']) }}"
                    }{{ !$loop->last ? ',' : '' }}
                    @endforeach
                ]
            }
        },
        {
            "@type": "BreadcrumbList",
            "@id": "{{ route('category', $category['slug']) }}/#breadcrumb",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "{{ route('home') }}"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Catalog",
                    "item": "{{ route('shop') }}"
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": "{{ addslashes($category['name']) }}",
                    "item": "{{ route('category', $category['slug']) }}"
                }
            ]
        }
    ]
}
</script>
@endpush

@section('content')
<div class="bg-white min-h-screen">
    
    <!-- Category Hero Header -->
    <div class="relative bg-espresso-950 text-ivory py-16 lg:py-24 overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-30">
            <img 
                src="{{ $category['image'] }}" 
                alt="{{ $category['name'] }}" 
                class="w-full h-full object-cover filter contrast-125"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-espresso-950 via-espresso-950/70 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Breadcrumbs -->
            <div class="flex items-center justify-center gap-2 text-xs text-gold-200 mb-4 uppercase tracking-widest font-serif">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <span>/</span>
                <a href="{{ route('shop') }}" class="hover:text-white">Catalog</a>
                <span>/</span>
                <span class="text-white font-semibold">{{ $category['name'] }}</span>
            </div>

            <h1 class="font-serif text-3xl sm:text-5xl font-bold text-white mb-4">
                {{ $category['name'] }}
            </h1>
            <p class="text-sm sm:text-base text-ivory-200 font-light max-w-xl mx-auto leading-relaxed">
                {{ $category['tagline'] }}
            </p>
        </div>
    </div>

    <!-- Category Filter Tabs -->
    <div class="bg-ivory-50 border-b border-ivory-200 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-center gap-2 sm:gap-4 overflow-x-auto hide-scrollbar">
            <a 
                href="{{ route('shop') }}" 
                class="px-4 py-2 rounded-full text-xs uppercase tracking-wider font-medium text-espresso-800 bg-white border border-ivory-300 hover:border-gold transition-colors whitespace-nowrap"
            >
                All Collections
            </a>
            @foreach($categories as $slug => $cat)
                <a 
                    href="{{ route('category', $slug) }}" 
                    class="px-4 py-2 rounded-full text-xs uppercase tracking-wider font-medium transition-colors whitespace-nowrap {{ $category['slug'] === $slug ? 'bg-espresso text-gold border border-gold/40 font-semibold shadow-xs' : 'bg-white text-espresso-800 border border-ivory-300 hover:border-gold' }}"
                >
                    {{ $cat['name'] }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Products Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="mb-8 flex items-center justify-between">
            <h2 class="font-serif text-xl font-bold text-espresso-900">
                Available In {{ $category['name'] }} ({{ count($products) }})
            </h2>
            <a href="{{ route('shop') }}" class="text-xs uppercase tracking-wider text-muted hover:text-gold-600 flex items-center gap-1">
                <span>View Full Shop</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        @if(count($products) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <x-user.components.product-card :product="$product" />
                @endforeach
            </div>
        @else
            <div class="py-16 text-center bg-ivory-50 rounded-xl border border-ivory-200">
                <p class="text-sm text-muted">No items currently cataloged in this line.</p>
            </div>
        @endif
    </div>

</div>
@endsection
