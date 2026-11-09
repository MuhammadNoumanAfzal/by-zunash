@extends('user.layouts.app')

@section('title', 'My Saved Pieces | By Zunash Luxury Leather')
@section('meta_description', 'View your saved wishlist items, manage your favorites, or move them into your shopping bag.')
@section('robots', 'noindex, follow')

@section('content')
<div x-data class="bg-ivory-50 min-h-screen py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-10 text-center sm:text-left">
            <span class="text-xs uppercase tracking-widest text-gold-600 font-serif font-bold">Curated By You</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-900 mt-1">
                Your Saved Wishlist (<span x-text="$store.wishlist.count"></span>)
            </h1>
        </div>

        <!-- Empty State -->
        <template x-if="$store.wishlist.items.length === 0">
            <div class="bg-white rounded-2xl border border-ivory-300 p-12 text-center max-w-lg mx-auto shadow-xs">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-ivory-100 flex items-center justify-center text-muted">
                    <i data-lucide="heart" class="w-10 h-10"></i>
                </div>
                <h2 class="font-serif text-2xl font-bold text-espresso-900 mb-2">Your Wishlist is Empty</h2>
                <p class="text-xs text-muted mb-8 leading-relaxed">
                    Save your favorite belts, wallets, and bags to keep track of heirloom leather pieces you love.
                </p>
                <a 
                    href="{{ route('shop') }}" 
                    class="inline-flex items-center gap-2 px-8 py-3.5 bg-espresso hover:bg-chocolate-700 text-ivory text-xs uppercase tracking-widest font-semibold rounded-lg shadow-md transition-all border border-gold/30"
                >
                    <span>Discover Catalog</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </template>

        <!-- Wishlist Items Grid -->
        <div x-show="$store.wishlist.items.length > 0" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
            <template x-for="item in $store.wishlist.items" :key="item.id">
                <div class="bg-white rounded-xl border border-ivory-300 overflow-hidden shadow-xs hover:shadow-luxury transition-all flex flex-col justify-between">
                    <!-- Image -->
                    <div class="relative aspect-square sm:aspect-[4/5] bg-ivory-100 overflow-hidden">
                        <img :src="item.image" :alt="item.name" class="w-full h-full object-cover">
                        <!-- Remove button -->
                        <button 
                            type="button" 
                            @click="$store.wishlist.remove(item.id)" 
                            class="absolute top-2 right-2 sm:top-3 sm:right-3 w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white/90 text-espresso-900 hover:text-red-500 shadow-xs flex items-center justify-center transition-colors"
                            title="Remove from wishlist"
                        >
                            <i data-lucide="trash-2" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                        </button>
                    </div>

                    <!-- Details & Actions -->
                    <div class="p-3 sm:p-4 flex flex-col flex-1 justify-between">
                        <div>
                            <span class="text-[9px] sm:text-[10px] uppercase tracking-wider text-muted font-medium block mb-1" x-text="item.category"></span>
                            <h3 class="font-serif text-xs sm:text-base font-semibold text-espresso-900 line-clamp-1 mb-1.5 sm:mb-2">
                                <a :href="'/product/' + item.slug" x-text="item.name" class="hover:text-gold-600"></a>
                            </h3>
                            <div class="font-serif text-xs sm:text-sm font-bold text-espresso-900 mb-2 sm:mb-4">
                                PKR <span x-text="item.price.toLocaleString()"></span>
                            </div>
                        </div>

                        <div class="space-y-1.5 sm:space-y-2 pt-2 border-t border-ivory-200">
                            <button 
                                type="button" 
                                @click="$store.cart.addItem(item); $store.wishlist.remove(item.id);" 
                                class="w-full py-2 px-2 sm:px-4 bg-espresso hover:bg-chocolate-700 text-ivory text-[10px] sm:text-xs uppercase tracking-wider font-semibold rounded-lg flex items-center justify-center gap-1.5 transition-all shadow-xs"
                            >
                                <i data-lucide="shopping-bag" class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gold"></i>
                                <span>Move to Bag</span>
                            </button>
                            <a 
                                :href="'/product/' + item.slug" 
                                class="w-full py-1.5 px-2 sm:px-4 bg-ivory-50 hover:bg-ivory-100 text-espresso-800 text-[10px] sm:text-xs uppercase tracking-wider font-medium rounded-lg text-center block transition-colors border border-ivory-300"
                            >
                                View Piece
                            </a>
                        </div>
                    </div>
                </div>
            </template>
        </div>

    </div>
</div>
@endsection
