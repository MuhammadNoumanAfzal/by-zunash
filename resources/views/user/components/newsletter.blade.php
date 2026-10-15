<div 
    x-data="{ 
        email: '', 
        submitted: false, 
        error: '',
        validateEmail(e) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(e);
        },
        handleSubmit() {
            this.error = '';
            if (!this.email || !this.validateEmail(this.email)) {
                this.error = 'Please enter a valid email address.';
                window.ZunashAlert.toast('Please enter a valid email address.', 'error');
                return;
            }
            // Trigger SweetAlert2 Luxury Modal
            this.submitted = true;
            window.ZunashAlert.success(
                'Welcome to The Zunash Circle', 
                'Thank you for subscribing to The Zunash Journal. You will be the first to receive private release previews and bespoke leather care notes.'
            );
            this.email = '';
        }
    }" 
    class="relative overflow-hidden bg-espresso-950 py-16 px-6 lg:px-12 text-center text-ivory rounded-2xl border border-gold/30 shadow-luxury"
>
    <!-- Background Luxury Pattern -->
    <div class="absolute inset-0 opacity-5 pointer-events-none">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
            <path d="M50 0 L100 50 L50 100 L0 50 Z" fill="none" stroke="#C5A16B" stroke-width="1"></path>
        </svg>
    </div>

    <div class="relative z-10 max-w-2xl mx-auto">
        <!-- Subheading -->
        <span class="inline-flex items-center gap-2 text-gold text-xs tracking-widest uppercase font-serif mb-3">
            <span class="w-6 h-[1px] bg-gold"></span>
            The Zunash Journal
            <span class="w-6 h-[1px] bg-gold"></span>
        </span>

        <h2 class="font-serif text-3xl md:text-4xl font-bold tracking-tight text-white mb-4">
            Curated Stories, Private Previews
        </h2>

        <p class="text-sm md:text-base text-ivory-300 font-light max-w-lg mx-auto mb-8 leading-relaxed">
            Be the first to discover small-batch leather releases, bespoke design notes, and private seasonal invitations delivered straight to your inbox.
        </p>

        <!-- Newsletter Form -->
        <div x-show="!submitted">
            <form @submit.prevent="handleSubmit" class="flex flex-col sm:flex-row items-center gap-3 max-w-md mx-auto">
                <div class="relative w-full">
                    <input 
                        type="email" 
                        x-model="email" 
                        placeholder="Enter your email address" 
                        class="w-full px-5 py-3.5 bg-espresso-900/90 border border-gold/40 text-ivory placeholder-muted-light rounded-lg focus:outline-none focus:ring-2 focus:ring-gold/60 focus:border-gold transition-all text-sm"
                        :class="error ? 'border-red-400 focus:ring-red-400' : ''"
                        required
                    >
                    <div x-show="error" x-text="error" class="text-red-300 text-xs text-left mt-1.5 pl-1 absolute -bottom-5 left-0"></div>
                </div>

                <button 
                    type="submit" 
                    class="w-full sm:w-auto px-8 py-3.5 bg-gold hover:bg-gold-light text-espresso-950 font-bold text-xs uppercase tracking-widest rounded-lg transition-all shadow-md hover:shadow-gold-glow flex items-center justify-center gap-2 whitespace-nowrap active:scale-95"
                >
                    <span>Subscribe</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>
            <p class="text-[11px] text-ivory-400 mt-4">
                We respect your privacy. Unsubscribe at any time. No spam, ever.
            </p>
        </div>

        <!-- Success Confirmation State -->
        <div x-show="submitted" x-cloak class="p-6 bg-espresso-900/80 border border-gold/40 rounded-xl text-center max-w-md mx-auto animate-fade-in">
            <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-gold/20 flex items-center justify-center text-gold">
                <i data-lucide="check" class="w-6 h-6"></i>
            </div>
            <h3 class="font-serif text-lg font-semibold text-white mb-1">Welcome to Our Circle</h3>
            <p class="text-xs text-ivory-300">
                You have been subscribed to The Zunash Journal. Please check your inbox for our welcome note.
            </p>
        </div>
    </div>
</div>
