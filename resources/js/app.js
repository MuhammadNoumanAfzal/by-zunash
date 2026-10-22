import './bootstrap';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import {
    createIcons,
    ShoppingBag,
    Heart,
    Search,
    User,
    Menu,
    X,
    ChevronDown,
    ChevronRight,
    ChevronLeft,
    ArrowRight,
    Check,
    Truck,
    ShieldCheck,
    Headphones,
    RotateCcw,
    Star,
    SlidersHorizontal,
    Filter,
    Plus,
    Minus,
    Trash2,
    Eye,
    Share2,
    ExternalLink,
    Lock,
    Mail,
    Phone,
    MapPin,
    Clock,
    Award,
    CheckCircle2,
    CheckCircle,
    AlertCircle,
    Sun,
    Moon,
    Feather,
    Scissors,
    GitCommit,
    Banknote,
    Gift,
    Sparkles,
    Layers,
    Ruler,
    Package,
    MessageSquare,
    Maximize2,
    ZoomIn,
    HelpCircle,
    Shield,
    FileText
} from 'lucide';

const iconSet = {
    ShoppingBag,
    Heart,
    Search,
    User,
    Menu,
    X,
    ChevronDown,
    ChevronRight,
    ChevronLeft,
    ArrowRight,
    Check,
    Truck,
    ShieldCheck,
    Headphones,
    RotateCcw,
    Star,
    SlidersHorizontal,
    Filter,
    Plus,
    Minus,
    Trash2,
    Eye,
    Share2,
    ExternalLink,
    Lock,
    Mail,
    Phone,
    MapPin,
    Clock,
    Award,
    CheckCircle2,
    CheckCircle,
    AlertCircle,
    Sun,
    Moon,
    Feather,
    Scissors,
    GitCommit,
    Banknote,
    Gift,
    Sparkles,
    Layers,
    Ruler,
    Package,
    MessageSquare,
    Maximize2,
    ZoomIn,
    HelpCircle,
    Shield,
    FileText
};

window.Alpine = Alpine;
window.Swal = Swal;

// ========================================================
// BESPOKE LUXURY SWEETALERT2 ENGINE FOR BY ZUNASH
// ========================================================
window.ZunashAlert = {
    // Elegant Luxury Toast
    toast(title, icon = 'success') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            customClass: {
                popup: 'byzunash-swal-toast',
                title: 'text-xs font-serif'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        return Toast.fire({
            icon: icon,
            title: title
        });
    },

    // Modal Alert
    success(title, html) {
        return Swal.fire({
            icon: 'success',
            title: title,
            html: html,
            customClass: {
                popup: 'byzunash-swal-popup',
                title: 'byzunash-swal-title',
                htmlContainer: 'byzunash-swal-html',
                confirmButton: 'byzunash-swal-confirm-btn'
            },
            confirmButtonText: 'Understood'
        });
    },

    // Confirmation Modal (e.g. for clearing bag)
    confirm(title, html, confirmText = 'Yes, Proceed', cancelText = 'Cancel') {
        return Swal.fire({
            icon: 'question',
            title: title,
            html: html,
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: cancelText,
            customClass: {
                popup: 'byzunash-swal-popup',
                title: 'byzunash-swal-title',
                htmlContainer: 'byzunash-swal-html',
                confirmButton: 'byzunash-swal-confirm-btn',
                cancelButton: 'byzunash-swal-cancel-btn'
            }
        });
    },

    // Cart Notification with Action
    cartAdded(product) {
        return Swal.fire({
            title: 'Added to Shopping Bag',
            html: `
                <div style="display: flex; align-items: center; gap: 14px; text-align: left; padding: 10px 0;">
                    <img src="${product.image}" style="width: 60px; height: 75px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(197, 161, 107, 0.4);" />
                    <div>
                        <div style="font-family: 'Playfair Display', serif; font-weight: 600; font-size: 15px; color: #FFFFFF;">${product.name}</div>
                        <div style="color: #C5A16B; font-weight: 700; margin-top: 4px; font-size: 14px;">PKR ${Number(product.price).toLocaleString()}</div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Checkout Now',
            cancelButtonText: 'Continue Browsing',
            customClass: {
                popup: 'byzunash-swal-popup',
                title: 'byzunash-swal-title',
                htmlContainer: 'byzunash-swal-html',
                confirmButton: 'byzunash-swal-confirm-btn',
                cancelButton: 'byzunash-swal-cancel-btn'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/checkout';
            }
        });
    }
};

// ========================================================
// ALPINE THEME STORE (Light / Warm Dark Atelier)
// ========================================================
Alpine.store('theme', {
    current: localStorage.getItem('byzunash_theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'),

    init() {
        this.apply(this.current);
    },

    toggle() {
        this.current = this.current === 'dark' ? 'light' : 'dark';
        this.apply(this.current);
        setTimeout(() => {
            if (window.refreshLucideIcons) window.refreshLucideIcons();
        }, 50);
    },

    apply(theme) {
        this.current = theme;
        localStorage.setItem('byzunash_theme', theme);
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
});

// ========================================================
// ALPINE CART STORE
// ========================================================
Alpine.store('cart', {
    items: JSON.parse(localStorage.getItem('byzunash_cart') || '[]'),
    isOpen: false,

    save() {
        localStorage.setItem('byzunash_cart', JSON.stringify(this.items));
    },

    addItem(product, variant = null, quantity = 1, showPrompt = false) {
        const itemKey = `${product.id}-${variant || 'default'}`;
        const existing = this.items.find(item => item.key === itemKey);

        if (existing) {
            existing.quantity += quantity;
        } else {
            this.items.push({
                key: itemKey,
                id: product.id,
                name: product.name,
                price: Number(product.price),
                originalPrice: product.original_price ? Number(product.original_price) : null,
                image: product.image,
                category: product.category_name || product.category,
                variant: variant || (product.colors && product.colors[0]?.name) || null,
                quantity: quantity
            });
        }
        this.save();
        this.refreshIcons();

        if (showPrompt) {
            window.ZunashAlert.cartAdded(product);
        } else {
            window.ZunashAlert.toast(`"${product.name}" added to shopping bag.`, 'success');
            this.isOpen = true;
        }
    },

    updateQuantity(key, quantity) {
        const item = this.items.find(i => i.key === key);
        if (item) {
            item.quantity = Math.max(1, quantity);
            this.save();
        }
    },

    removeItem(key) {
        this.items = this.items.filter(i => i.key !== key);
        this.save();
        window.ZunashAlert.toast('Item removed from shopping bag.', 'info');
    },

    confirmClear() {
        window.ZunashAlert.confirm(
            'Clear Shopping Bag?',
            'Are you sure you want to remove all handcrafted pieces from your bag?',
            'Yes, Clear Bag',
            'Keep Items'
        ).then((result) => {
            if (result.isConfirmed) {
                this.items = [];
                this.save();
                window.ZunashAlert.toast('Your shopping bag has been cleared.', 'info');
            }
        });
    },

    clear() {
        this.items = [];
        this.save();
    },

    get count() {
        return this.items.reduce((total, item) => total + item.quantity, 0);
    },

    get subtotal() {
        return this.items.reduce((total, item) => total + (item.price * item.quantity), 0);
    },

    get shipping() {
        if (this.subtotal === 0) return 0;
        return this.subtotal >= 6000 ? 0 : 250;
    },

    get total() {
        return this.subtotal + this.shipping;
    },

    refreshIcons() {
        setTimeout(() => {
            createIcons({ icons: iconSet });
        }, 50);
    }
});

// ========================================================
// ALPINE WISHLIST STORE
// ========================================================
Alpine.store('wishlist', {
    items: JSON.parse(localStorage.getItem('byzunash_wishlist') || '[]'),

    save() {
        localStorage.setItem('byzunash_wishlist', JSON.stringify(this.items));
    },

    has(id) {
        return this.items.some(item => item.id === id);
    },

    toggle(product) {
        if (this.has(product.id)) {
            this.items = this.items.filter(item => item.id !== product.id);
            this.save();
            window.ZunashAlert.toast(`"${product.name}" removed from wishlist.`, 'info');
        } else {
            this.items.push({
                id: product.id,
                name: product.name,
                price: Number(product.price),
                originalPrice: product.original_price ? Number(product.original_price) : null,
                image: product.image,
                category: product.category_name || product.category,
                slug: product.slug
            });
            this.save();
            window.ZunashAlert.toast(`"${product.name}" saved to your wishlist.`, 'success');
        }
    },

    remove(id) {
        this.items = this.items.filter(item => item.id !== id);
        this.save();
        window.ZunashAlert.toast('Item removed from wishlist.', 'info');
    },

    get count() {
        return this.items.length;
    }
});

// Toast notification store fallback
Alpine.store('toast', {
    show(msg, type = 'success') {
        window.ZunashAlert.toast(msg, type);
    },
    hide() {}
});

// Start Alpine
Alpine.start();

// ========================================================
// SCROLL REVEAL INTERSECTION OBSERVER
// ========================================================
function initScrollReveal() {
    const revealElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
    
    if (!('IntersectionObserver' in window)) {
        revealElements.forEach(el => el.classList.add('revealed'));
        return;
    }

    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -60px 0px',
        threshold: 0.12
    };

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                obs.unobserve(entry.target);
            }
        });
    }, observerOptions);

    revealElements.forEach(el => observer.observe(el));
}

// Initialize Lucide Icons & Scroll Reveal on DOM Load
document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons: iconSet });
    initScrollReveal();
});

// Global icon refresh function
window.refreshLucideIcons = () => {
    createIcons({ icons: iconSet });
};

window.refreshScrollReveal = initScrollReveal;
