@extends('user.layouts.app')

@section('title', 'Secure Checkout | By Zunash Luxury Leather')
@section('meta_description', 'Complete your order with nationwide Cash on Delivery or direct bank transfer across Pakistan.')
@section('robots', 'noindex, nofollow')

@section('content')
<div 
    x-data="checkoutForm()" 
    class="bg-ivory-50 min-h-screen py-12 lg:py-16"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-10 text-center">
            <span class="text-xs uppercase tracking-widest text-gold-600 font-serif font-bold">Atelier Checkout</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-espresso-900 mt-1">
                Finalize Your Order
            </h1>
        </div>

        <!-- Success Order Confirmation View (Shown when order placed) -->
        <div x-show="orderPlaced" x-cloak class="max-w-2xl mx-auto bg-white p-8 sm:p-12 rounded-2xl border border-gold/40 shadow-luxury text-center">
            <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-gold/20 flex items-center justify-center text-gold">
                <i data-lucide="check" class="w-8 h-8"></i>
            </div>
            
            <span class="text-xs uppercase tracking-widest text-gold-600 font-serif font-semibold">Order Confirmed</span>
            <h2 class="font-serif text-3xl font-bold text-espresso-950 mt-1 mb-2">
                Shukriya, <span x-text="firstName"></span>!
            </h2>
            <p class="text-xs text-muted mb-6 leading-relaxed">
                Your order reference is <strong class="text-espresso-900 font-mono" x-text="orderNumber"></strong>. Our client concierge team will call or WhatsApp your contact number (<span class="font-medium text-espresso-900" x-text="phone"></span>) to verify shipping coordinates before dispatch.
            </p>

            <div class="bg-ivory-50 p-6 rounded-xl border border-ivory-300 text-left text-xs text-espresso-800 space-y-3 mb-8">
                <div class="flex justify-between border-b border-ivory-200 pb-2">
                    <span class="text-muted">Payment Mode:</span>
                    <span class="font-semibold" x-text="paymentMethod === 'cod' ? 'Cash on Delivery (COD)' : 'Direct Bank Transfer'"></span>
                </div>
                <div class="flex justify-between border-b border-ivory-200 pb-2">
                    <span class="text-muted">Delivery City:</span>
                    <span class="font-semibold" x-text="city + ', Pakistan'"></span>
                </div>
                <div class="flex justify-between border-b border-ivory-200 pb-2">
                    <span class="text-muted">Delivery Address:</span>
                    <span class="font-semibold text-right" x-text="address"></span>
                </div>
                <div class="flex justify-between pt-1 font-serif text-sm font-bold text-espresso-950">
                    <span>Estimated Arrival:</span>
                    <span>2–4 Business Days</span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a 
                    href="{{ route('home') }}" 
                    class="w-full sm:w-auto px-8 py-3.5 bg-espresso hover:bg-chocolate-700 text-ivory text-xs uppercase tracking-widest font-semibold rounded-lg shadow-md transition-all"
                >
                    Return to Atelier Home
                </a>
                <a 
                    href="{{ route('shop') }}" 
                    class="w-full sm:w-auto px-8 py-3.5 bg-ivory-100 hover:bg-ivory-200 text-espresso-900 text-xs uppercase tracking-widest font-semibold rounded-lg transition-colors border border-ivory-300"
                >
                    Explore More Pieces
                </a>
            </div>
        </div>

        <!-- Checkout Form Grid -->
        <div x-show="!orderPlaced" class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- Left: Shipping Information Form (7 Cols) -->
            <div class="lg:col-span-7 bg-white p-6 sm:p-8 rounded-xl border border-ivory-300 shadow-xs space-y-8">
                
                <!-- Error banner if validation fails -->
                <div x-show="error" x-cloak class="p-4 bg-red-50 border border-red-200 rounded-lg text-xs text-red-700 flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0 text-red-500"></i>
                    <span x-text="error"></span>
                </div>

                <!-- Contact & Shipping Details -->
                <div>
                    <h2 class="font-serif text-lg font-bold text-espresso-900 uppercase tracking-wider pb-3 border-b border-ivory-200 mb-6 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-espresso text-gold text-xs flex items-center justify-center font-sans font-bold">1</span>
                        <span>Delivery Address in Pakistan</span>
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1.5">First Name *</label>
                            <input 
                                type="text" 
                                x-model="firstName" 
                                placeholder="e.g. Bilal" 
                                class="w-full px-4 py-2.5 bg-ivory-50 border border-ivory-300 rounded text-xs text-espresso-900 focus:outline-none focus:ring-1 focus:ring-gold"
                                required
                            >
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1.5">Last Name *</label>
                            <input 
                                type="text" 
                                x-model="lastName" 
                                placeholder="e.g. Mansoor" 
                                class="w-full px-4 py-2.5 bg-ivory-50 border border-ivory-300 rounded text-xs text-espresso-900 focus:outline-none focus:ring-1 focus:ring-gold"
                                required
                            >
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1.5">Phone (WhatsApp for Dispatch) *</label>
                            <input 
                                type="tel" 
                                x-model="phone" 
                                placeholder="0300 1234567" 
                                class="w-full px-4 py-2.5 bg-ivory-50 border border-ivory-300 rounded text-xs text-espresso-900 focus:outline-none focus:ring-1 focus:ring-gold"
                                required
                            >
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1.5">Email Address</label>
                            <input 
                                type="email" 
                                x-model="email" 
                                placeholder="client@example.com" 
                                class="w-full px-4 py-2.5 bg-ivory-50 border border-ivory-300 rounded text-xs text-espresso-900 focus:outline-none focus:ring-1 focus:ring-gold"
                            >
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1.5">Street Address / House / Plaza *</label>
                        <input 
                            type="text" 
                            x-model="address" 
                            placeholder="House #, Street #, Sector / Phase / Mohallah" 
                            class="w-full px-4 py-2.5 bg-ivory-50 border border-ivory-300 rounded text-xs text-espresso-900 focus:outline-none focus:ring-1 focus:ring-gold"
                            required
                        >
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1.5">City *</label>
                            <select 
                                x-model="city" 
                                class="w-full px-4 py-2.5 bg-ivory-50 border border-ivory-300 rounded text-xs text-espresso-900 focus:outline-none focus:ring-1 focus:ring-gold font-medium"
                            >
                                @foreach($pakistaniCities as $cityName)
                                    <option value="{{ $cityName }}">{{ $cityName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1.5">Postal Code (Optional)</label>
                            <input 
                                type="text" 
                                x-model="postalCode" 
                                placeholder="54000" 
                                class="w-full px-4 py-2.5 bg-ivory-50 border border-ivory-300 rounded text-xs text-espresso-900 focus:outline-none focus:ring-1 focus:ring-gold"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-wider font-semibold text-espresso-900 mb-1.5">Special Packaging / Delivery Instructions</label>
                        <textarea 
                            x-model="orderNotes" 
                            rows="2" 
                            placeholder="e.g. Please leave with building receptionist or ring front bell." 
                            class="w-full px-4 py-2.5 bg-ivory-50 border border-ivory-300 rounded text-xs text-espresso-900 focus:outline-none focus:ring-1 focus:ring-gold"
                        ></textarea>
                    </div>
                </div>

                <!-- Payment Method Section -->
                <div>
                    <h2 class="font-serif text-lg font-bold text-espresso-900 uppercase tracking-wider pb-3 border-b border-ivory-200 mb-6 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-espresso text-gold text-xs flex items-center justify-center font-sans font-bold">2</span>
                        <span>Payment Method</span>
                    </h2>

                    <div class="space-y-3">
                        <!-- Cash on Delivery -->
                        <label 
                            class="flex items-start gap-4 p-4 rounded-xl border cursor-pointer transition-all"
                            :class="paymentMethod === 'cod' ? 'border-gold bg-ivory-50 shadow-xs' : 'border-ivory-300 hover:border-ivory-400'"
                        >
                            <input 
                                type="radio" 
                                name="payment_method" 
                                value="cod" 
                                x-model="paymentMethod" 
                                class="mt-1 text-gold focus:ring-gold"
                            >
                            <div>
                                <div class="font-serif text-sm font-bold text-espresso-900">Cash on Delivery (Nationwide COD)</div>
                                <p class="text-xs text-muted leading-relaxed mt-0.5">
                                    Pay the exact order amount in cash to the courier representative when the parcel arrives at your doorstep.
                                </p>
                            </div>
                        </label>

                        <!-- Direct Bank Transfer -->
                        <label 
                            class="flex items-start gap-4 p-4 rounded-xl border cursor-pointer transition-all"
                            :class="paymentMethod === 'bank' ? 'border-gold bg-ivory-50 shadow-xs' : 'border-ivory-300 hover:border-ivory-400'"
                        >
                            <input 
                                type="radio" 
                                name="payment_method" 
                                value="bank" 
                                x-model="paymentMethod" 
                                class="mt-1 text-gold focus:ring-gold"
                            >
                            <div>
                                <div class="font-serif text-sm font-bold text-espresso-900">Direct Bank Transfer / IBFT</div>
                                <p class="text-xs text-muted leading-relaxed mt-0.5">
                                    Transfer funds directly to our corporate bank account via your mobile banking app (Meezan / HBL / Alfalah). Coordinates will be provided on confirmation.
                                </p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="button" 
                    @click="placeOrder()" 
                    class="w-full py-4 bg-espresso hover:bg-chocolate-700 text-ivory text-xs uppercase tracking-widest font-semibold rounded-lg shadow-md transition-all border border-gold/30 active:scale-98"
                >
                    Confirm & Place Order
                </button>
            </div>

            <!-- Right: Order Summary Sidebar (5 Cols) -->
            <div class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-xl border border-ivory-300 shadow-xs space-y-6">
                <h2 class="font-serif text-lg font-bold text-espresso-900 uppercase tracking-wider pb-3 border-b border-ivory-200">
                    Order Summary (<span x-text="$store.cart.count"></span>)
                </h2>

                <!-- Items in Cart -->
                <div class="space-y-4 max-h-80 overflow-y-auto pr-1">
                    <template x-for="item in $store.cart.items" :key="item.key">
                        <div class="flex items-center gap-3 py-2 border-b border-ivory-100">
                            <img :src="item.image" :alt="item.name" class="w-14 h-16 object-cover rounded bg-ivory-100 border border-ivory-200 flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-serif text-xs font-semibold text-espresso-900 truncate" x-text="item.name"></h4>
                                <p class="text-[11px] text-muted" x-show="item.variant" x-text="'Tone: ' + item.variant"></p>
                                <span class="text-[11px] text-muted">Qty: <span x-text="item.quantity"></span></span>
                            </div>
                            <div class="text-xs font-bold text-espresso-900">
                                PKR <span x-text="(item.price * item.quantity).toLocaleString()"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Price breakdown -->
                <div class="space-y-2.5 text-xs text-espresso-800 pt-2 border-t border-ivory-200">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span class="font-semibold">PKR <span x-text="$store.cart.subtotal.toLocaleString()"></span></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Courier Shipping</span>
                        <span class="font-semibold" x-text="$store.cart.shipping === 0 ? 'FREE' : 'PKR ' + $store.cart.shipping"></span>
                    </div>
                    <div class="pt-3 border-t border-ivory-300 flex justify-between text-base font-bold text-espresso-950 font-serif">
                        <span>Total Due</span>
                        <span>PKR <span x-text="$store.cart.total.toLocaleString()"></span></span>
                    </div>
                </div>

                <!-- Guarantee Notice -->
                <div class="p-3.5 bg-ivory-50 rounded border border-ivory-200 text-[11px] text-muted-dark space-y-1">
                    <p class="font-medium text-espresso-900">Protected Customer Guarantee</p>
                    <p>All parcels are sealed in tamper-evident security bags and dispatched through registered national couriers.</p>
                </div>
            </div>

        </div>

    </div>
</div>

@push('scripts')
<script>
function checkoutForm() {
    return {
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        address: '',
        city: 'Lahore',
        postalCode: '',
        orderNotes: '',
        paymentMethod: 'cod',
        orderPlaced: false,
        orderNumber: '',
        error: '',
        placeOrder() {
            this.error = '';
            if (!this.firstName || !this.lastName || !this.phone || !this.address || !this.city) {
                this.error = 'Please fill out all mandatory shipping details (Name, Phone, City, Address).';
                window.ZunashAlert.toast(this.error, 'error');
                return;
            }
            if (Alpine.store('cart').items.length === 0) {
                this.error = 'Your bag is empty. Please add items before placing an order.';
                window.ZunashAlert.toast(this.error, 'error');
                return;
            }
            
            this.orderNumber = 'BZ-' + Math.floor(100000 + Math.random() * 900000);
            
            window.ZunashAlert.success(
                'Order Placed Successfully!',
                'Shukriya, <strong>' + this.firstName + '</strong>! Your order reference <strong style="color: #C5A16B; font-family: monospace;">' + this.orderNumber + '</strong> has been recorded. Our client concierge will contact you at <strong>' + this.phone + '</strong> prior to courier dispatch.'
            ).then(() => {
                this.orderPlaced = true;
                Alpine.store('cart').clear();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    };
}
</script>
@endpush
@endsection
