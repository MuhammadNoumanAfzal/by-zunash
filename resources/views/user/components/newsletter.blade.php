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
    class="relative overflow-hidden bg-gradient-to-br from-espresso-950 via-[#180f0a] to-black py-10 sm:py-12 px-6 lg:px-12 text-ivory rounded-3xl border border-gold/40 shadow-2xl"
>
    <!-- Ambient Gold Glow -->
    <div class="absolute -top-32 -right-32 w-80 h-80 bg-gold/15 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-gold/10 rounded-full blur-[100px] pointer-events-none"></div>

    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5 pointer-events-none">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80">
            <path d="M40 0 L80 40 L40 80 L0 40 Z" fill="none" stroke="#C5A16B" stroke-width="0.8"></path>
        </svg>
    </div>

    <div class="relative z-10 max-w-4xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            
            <!-- Left Info -->
            <div class="lg:col-span-6 text-center lg:text-left">
                <span class="inline-flex items-center gap-2 px-3 py-1 bg-gold/15 border border-gold/40 text-gold-300 text-[11px] uppercase tracking-widest font-serif rounded-full mb-3 shadow-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-gold"></span>
                    <span>The Zunash Journal</span>
                </span>

                <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight text-white mb-3">
                    Curated Stories, <br class="hidden sm:inline">Private Previews
                </h2>

                <p class="text-xs sm:text-sm text-ivory-300 font-light leading-relaxed mb-5 max-w-md mx-auto lg:mx-0">
                    Be the first to discover small-batch leather releases, bespoke design notes, and private seasonal invitations.
                </p>

                <!-- Perks checklist -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 text-xs text-gold-200">
                    <span class="flex items-center gap-1.5">
                        <i data-lucide="check" class="w-3.5 h-3.5 text-gold"></i>
                        <span>Private Drops</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i data-lucide="check" class="w-3.5 h-3.5 text-gold"></i>
                        <span>Atelier Care Notes</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i data-lucide="check" class="w-3.5 h-3.5 text-gold"></i>
                        <span>No Spam</span>
                    </span>
                </div>
            </div>

            <!-- Right Form -->
            <div class="lg:col-span-6">
                <!-- Newsletter Form -->
                <div x-show="!submitted">
                    <form @submit.prevent="handleSubmit" class="flex flex-col sm:flex-row items-stretch gap-2.5 bg-espresso-900/80 p-2 sm:p-2.5 rounded-2xl border border-gold/40 shadow-xl backdrop-blur-md">
                        <div class="relative flex-grow">
                            <input 
                                type="email" 
                                x-model="email" 
                                placeholder="Enter your email address" 
                                class="w-full px-4 py-3 bg-transparent text-ivory placeholder-ivory-400/60 focus:outline-none text-sm"
                                required
                            >
                        </div>

                        <button 
                            type="submit" 
                            class="px-7 py-3 bg-gold hover:bg-gold-light text-espresso-950 font-bold text-xs uppercase tracking-widest rounded-xl transition-all shadow-md hover:shadow-gold-glow flex items-center justify-center gap-2 whitespace-nowrap active:scale-95 group"
                        >
                            <span>Subscribe</span>
                            <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
                        </button>
                    </form>
                    
                    <div x-show="error" x-text="error" class="text-red-300 text-xs text-center mt-2"></div>

                    <p class="text-[11px] text-ivory-400/70 text-center lg:text-left mt-3">
                        <i data-lucide="lock" class="w-3 h-3 inline mr-1 text-gold"></i>
                        We respect your privacy. Unsubscribe anytime with 1 click.
                    </p>
                </div>

                <!-- Success Confirmation State -->
                <div x-show="submitted" x-cloak class="p-6 bg-espresso-900/90 border border-gold/50 rounded-2xl text-center animate-fade-in shadow-xl">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-gold/20 border border-gold/40 flex items-center justify-center text-gold">
                        <i data-lucide="check" class="w-6 h-6"></i>
                    </div>
                    <h3 class="font-serif text-lg font-semibold text-white mb-1">Welcome to Our Circle</h3>
                    <p class="text-xs text-ivory-300">
                        You have been subscribed to The Zunash Journal. Please check your inbox for our welcome note.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
