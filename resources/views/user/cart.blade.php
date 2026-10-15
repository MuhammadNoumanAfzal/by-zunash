@extends('user.layouts.app')

@section('title', 'Shopping Bag | By Zunash Luxury Leather')
@section('meta_description', 'Review your selected luxury leather goods, adjust quantities, and proceed to checkout.')

@section('content')
<div x-data class="bg-ivory-50 min-h-screen py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-10 text-center sm:text-left">
            <span class="text-xs uppercase tracking-widest text-gold-600 font-serif font-bold">Your Selection</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-900 mt-1">
                Shopping Bag (<span x-text="$store.cart.count"></span>)
            </h1>
        </div>

        <!-- Empty State -->
        <template x-if="$store.cart.items.length === 0">
            <div class="bg-white rounded-2xl border border-ivory-300 p-12 text-center max-w-lg mx-auto shadow-xs">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-ivory-100 flex items-center justify-center text-muted">
                    <i data-lucide="shopping-bag" class="w-10 h-10"></i>
                </div>
                <h2 class="font-serif text-2xl font-bold text-espresso-900 mb-2">Your Bag is Empty</h2>
                <p class="text-xs text-muted mb-8 leading-relaxed">
                    You haven't added any luxury leather creations yet. Discover our handcrafted belts, wallets, and bags made for enduring distinction.
                </p>
                <a 
                    href="{{ route('shop') }}" 
                    class="inline-flex items-center gap-2 px-8 py-3.5 bg-espresso hover:bg-chocolate-700 text-ivory text-xs uppercase tracking-widest font-semibold rounded-lg shadow-md transition-all border border-gold/30"
                >
                    <span>Explore Catalog</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </template>

        <!-- Active Bag Grid (Items on left, Summary on right) -->
        <div x-show="$store.cart.items.length > 0" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Items Table/Card Column (8 Cols) -->
            <div class="lg:col-span-8 bg-white rounded-xl border border-ivory-300 shadow-xs divide-y divide-ivory-200 overflow-hidden">
                <div class="p-4 bg-ivory-100/60 hidden sm:grid sm:grid-cols-12 text-xs uppercase tracking-wider font-semibold text-espresso-800">
                    <div class="sm:col-span-6">Creation</div>
                    <div class="sm:col-span-2 text-center">Price</div>
                    <div class="sm:col-span-2 text-center">Quantity</div>
                    <div class="sm:col-span-2 text-right">Subtotal</div>
                </div>

                <template x-for="item in $store.cart.items" :key="item.key">
                    <div class="p-6 sm:grid sm:grid-cols-12 sm:items-center gap-4 flex flex-col">
                        <!-- Product Info (6 cols) -->
                        <div class="sm:col-span-6 flex items-center gap-4">
                            <img 
                                :src="item.image" 
                                :alt="item.name" 
                                class="w-20 h-24 object-cover rounded bg-ivory-100 border border-ivory-300 flex-shrink-0"
                            >
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-muted font-medium block" x-text="item.category"></span>
                                <h3 class="font-serif text-base font-semibold text-espresso-900" x-text="item.name"></h3>
                                <p class="text-xs text-muted-dark mt-0.5" x-show="item.variant" x-text="'Tone: ' + item.variant"></p>
                                <button 
                                    type="button" 
                                    @click="$store.cart.removeItem(item.key)" 
                                    class="text-xs text-red-500 hover:text-red-700 mt-2 flex items-center gap-1 focus:outline-none"
                                >
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    <span>Remove</span>
                                </button>
                            </div>
                        </div>

                        <!-- Price (2 cols) -->
                        <div class="sm:col-span-2 text-left sm:text-center text-xs font-semibold text-espresso-900">
                            PKR <span x-text="item.price.toLocaleString()"></span>
                        </div>

                        <!-- Quantity Selector (2 cols) -->
                        <div class="sm:col-span-2 flex items-center sm:justify-center">
                            <div class="flex items-center border border-ivory-300 rounded overflow-hidden">
                                <button 
                                    type="button" 
                                    @click="$store.cart.updateQuantity(item.key, item.quantity - 1)" 
                                    class="w-7 h-8 flex items-center justify-center bg-ivory-50 hover:bg-ivory-200 text-espresso-900"
                                    :disabled="item.quantity <= 1"
                                >
                                    <i data-lucide="minus" class="w-3 h-3"></i>
                                </button>
                                <span class="w-8 text-center text-xs font-bold text-espresso-900" x-text="item.quantity"></span>
                                <button 
                                    type="button" 
                                    @click="$store.cart.updateQuantity(item.key, item.quantity + 1)" 
                                    class="w-7 h-8 flex items-center justify-center bg-ivory-50 hover:bg-ivory-200 text-espresso-900"
                                >
                                    <i data-lucide="plus" class="w-3 h-3"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Subtotal (2 cols) -->
                        <div class="sm:col-span-2 text-right font-serif text-sm font-bold text-espresso-950">
                            PKR <span x-text="(item.price * item.quantity).toLocaleString()"></span>
                        </div>
                    </div>
                </template>

                <div class="p-4 bg-ivory-50 flex items-center justify-between">
                    <a href="{{ route('shop') }}" class="text-xs uppercase tracking-wider text-muted hover:text-gold-600 flex items-center gap-1 font-medium">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                        <span>Continue Shopping</span>
                    </a>
                    <button 
                        type="button" 
                        @click="$store.cart.confirmClear()" 
                        class="text-xs text-muted hover:text-red-500 underline transition-colors"
                    >
                        Clear Bag
                    </button>
                </div>
            </div>

            <!-- Order Summary Sidebar (4 Cols) -->
            <div class="lg:col-span-4 bg-white rounded-xl border border-ivory-300 shadow-xs p-6 space-y-6">
                <h2 class="font-serif text-lg font-bold text-espresso-900 uppercase tracking-wider pb-3 border-b border-ivory-200">
                    Order Summary
                </h2>

                <div class="space-y-3 text-xs text-espresso-800">
                    <div class="flex justify-between">
                        <span>Items Subtotal</span>
                        <span class="font-semibold">PKR <span x-text="$store.cart.subtotal.toLocaleString()"></span></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Courier Delivery (Pakistan)</span>
                        <span class="font-semibold" x-text="$store.cart.shipping === 0 ? 'FREE' : 'PKR ' + $store.cart.shipping"></span>
                    </div>
                    <div class="p-2.5 bg-ivory-50 rounded border border-ivory-200 text-[11px] text-muted-dark">
                        <span x-show="$store.cart.shipping === 0" class="text-chocolate-700 font-medium">
                            ✓ Complimentary shipping unlocked on this order!
                        </span>
                        <span x-show="$store.cart.shipping > 0">
                            Orders above PKR 6,000 enjoy free nationwide courier shipping.
                        </span>
                    </div>
                    <div class="pt-3 border-t border-ivory-300 flex justify-between text-base font-bold text-espresso-950 font-serif">
                        <span>Total Due</span>
                        <span>PKR <span x-text="$store.cart.total.toLocaleString()"></span></span>
                    </div>
                </div>

                <a 
                    href="{{ route('checkout') }}" 
                    class="w-full py-4 bg-espresso hover:bg-chocolate-700 text-ivory text-xs uppercase tracking-widest font-semibold rounded-lg text-center block shadow-md transition-all border border-gold/30"
                >
                    Proceed to Checkout
                </a>

                <div class="space-y-2 pt-2 border-t border-ivory-200 text-[11px] text-muted">
                    <div class="flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4 text-gold-600"></i>
                        <span>Cash on Delivery across Pakistan</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="rotate-ccw" class="w-4 h-4 text-gold-600"></i>
                        <span>7-Day easy exchange guarantee</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
