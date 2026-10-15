<footer class="bg-espresso-950 text-ivory border-t border-gold/20 pt-16 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Main Footer Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-14 border-b border-white/10">
            
            <!-- Col 1: Brand & Philosophy -->
            <div class="lg:col-span-2">
                <x-user.components.logo variant="white" height="h-10" />
                <p class="mt-4 text-sm text-ivory-300 max-w-sm leading-relaxed font-light">
                    By Zunash celebrates the art of artisanal leather craftsmanship. Handcrafted in Pakistan using finest grade full-grain hides, designed to mature with quiet grace alongside your everyday journey.
                </p>
                <div class="mt-6 flex items-center space-x-4 text-gold-200">
                    <span class="text-xs uppercase tracking-widest font-serif">Connect With Us:</span>
                    <a href="https://instagram.com" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-espresso-900 border border-gold/30 flex items-center justify-center hover:bg-gold hover:text-espresso-950 transition-colors" title="Instagram">
                        <i data-lucide="share-2" class="w-3.5 h-3.5"></i>
                    </a>
                    <a href="https://facebook.com" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-espresso-900 border border-gold/30 flex items-center justify-center hover:bg-gold hover:text-espresso-950 transition-colors" title="Facebook">
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

            <!-- Col 2: The Collections -->
            <div>
                <h4 class="font-serif text-sm uppercase tracking-widest text-gold font-semibold mb-4">
                    Collections
                </h4>
                <ul class="space-y-2.5 text-xs tracking-wide">
                    <li><a href="{{ route('category', 'belts') }}" class="text-ivory-300 hover:text-gold transition-colors">Leather Belts</a></li>
                    <li><a href="{{ route('category', 'wallets') }}" class="text-ivory-300 hover:text-gold transition-colors">Wallets & Cardholders</a></li>
                    <li><a href="{{ route('category', 'handbags') }}" class="text-ivory-300 hover:text-gold transition-colors">Luxury Handbags</a></li>
                    <li><a href="{{ route('category', 'shoulder-bags') }}" class="text-ivory-300 hover:text-gold transition-colors">Shoulder & Crossbody</a></li>
                    <li><a href="{{ route('category', 'accessories') }}" class="text-ivory-300 hover:text-gold transition-colors">Everyday Accessories</a></li>
                    <li><a href="{{ route('shop', ['sort' => 'latest']) }}" class="text-ivory-300 hover:text-gold transition-colors">New Releases</a></li>
                </ul>
            </div>

            <!-- Col 3: Client Concierge & Policies -->
            <div>
                <h4 class="font-serif text-sm uppercase tracking-widest text-gold font-semibold mb-4">
                    Client Care
                </h4>
                <ul class="space-y-2.5 text-xs tracking-wide">
                    <li><a href="{{ route('policy.shipping') }}" class="text-ivory-300 hover:text-gold transition-colors">Shipping & Delivery</a></li>
                    <li><a href="{{ route('policy.returns') }}" class="text-ivory-300 hover:text-gold transition-colors">Returns & Exchanges</a></li>
                    <li><a href="{{ route('faq') }}" class="text-ivory-300 hover:text-gold transition-colors">Frequently Asked Questions</a></li>
                    <li><a href="{{ route('policy.privacy') }}" class="text-ivory-300 hover:text-gold transition-colors">Privacy & Data Policy</a></li>
                    <li><a href="{{ route('about') }}" class="text-ivory-300 hover:text-gold transition-colors">About Our Atelier</a></li>
                    <li><a href="{{ route('contact') }}" class="text-ivory-300 hover:text-gold transition-colors">Bespoke Inquiries</a></li>
                </ul>
            </div>

            <!-- Col 4: Contact & Hours -->
            <div>
                <h4 class="font-serif text-sm uppercase tracking-widest text-gold font-semibold mb-4">
                    Atelier Care
                </h4>
                <ul class="space-y-3 text-xs text-ivory-300">
                    <li class="flex items-start gap-2.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-gold flex-shrink-0 mt-0.5"></i>
                        <span>Lahore & Karachi, Pakistan</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i data-lucide="phone" class="w-4 h-4 text-gold flex-shrink-0"></i>
                        <span>+92 (300) 123-4567</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i data-lucide="mail" class="w-4 h-4 text-gold flex-shrink-0"></i>
                        <span>concierge@byzunash.com</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i data-lucide="clock" class="w-4 h-4 text-gold flex-shrink-0 mt-0.5"></i>
                        <span>Mon – Sat: 10:00 AM – 8:00 PM PKT</span>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Bottom Bar: Payments & Copyright -->
        <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-ivory-400">
            <div>
                <p>&copy; {{ date('Y') }} By Zunash. All Rights Reserved. Timeless Leather Goods.</p>
            </div>

            <!-- Supported Payment Badges -->
            <div class="flex items-center gap-3">
                <span class="text-[11px] uppercase tracking-wider text-gold-300 font-medium">Accepted In Pakistan:</span>
                <span class="px-2 py-1 bg-espresso-900 border border-gold/30 rounded text-[10px] text-ivory font-mono">
                    Cash on Delivery
                </span>
                <span class="px-2 py-1 bg-espresso-900 border border-gold/30 rounded text-[10px] text-ivory font-mono">
                    Bank Transfer
                </span>
                <span class="px-2 py-1 bg-espresso-900 border border-gold/30 rounded text-[10px] text-ivory font-mono">
                    Visa / Mastercard
                </span>
            </div>
        </div>

    </div>
</footer>
