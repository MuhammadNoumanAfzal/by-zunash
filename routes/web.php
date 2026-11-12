<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\SubcategoryController as AdminSubcategoryController;
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\StaffController as AdminStaffController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\DealController as AdminDealController;
use App\Http\Controllers\Admin\AbandonedCartController as AdminAbandonedCartController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\Admin\SearchController as AdminSearchController;

/*
|--------------------------------------------------------------------------
| Customer Storefront Routes - By Zunash
|--------------------------------------------------------------------------
| Clean, RESTful named routes powering the customer-facing luxury leather store.
*/

// Homepage
Route::get('/', [StoreController::class, 'home'])->name('home');

// Shop & Catalog
Route::get('/shop', [StoreController::class, 'shop'])->name('shop');
Route::get('/category/{slug}', [StoreController::class, 'category'])->name('category');
Route::get('/deals', [StoreController::class, 'deals'])->name('deals');
Route::get('/deals/{slug}', [StoreController::class, 'dealDetails'])->name('deal.details');
Route::get('/product/{slug}', [StoreController::class, 'productDetails'])->name('product.details');

// Cart & Checkout
Route::get('/cart', [StoreController::class, 'cart'])->name('cart');
Route::get('/checkout', [StoreController::class, 'checkout'])->name('checkout');
Route::post('/api/checkout/process', [StoreController::class, 'processCheckout'])->name('checkout.process');
Route::post('/api/checkout/track-abandoned', [StoreController::class, 'trackAbandoned'])->name('checkout.track-abandoned');
Route::post('/api/coupon/validate', [StoreController::class, 'validateCoupon'])->name('coupon.validate');

// Wishlist
Route::get('/wishlist', [StoreController::class, 'wishlist'])->name('wishlist');

// Brand Story & Information
Route::get('/about', [StoreController::class, 'about'])->name('about');
Route::get('/reviews', [StoreController::class, 'reviews'])->name('reviews');
Route::post('/reviews', [StoreController::class, 'submitReview'])->name('reviews.submit');
Route::get('/contact', [StoreController::class, 'contact'])->name('contact');
Route::post('/contact', [StoreController::class, 'submitContact'])->name('contact.submit');
Route::get('/faq', [StoreController::class, 'faq'])->name('faq');
Route::get('/search', [StoreController::class, 'search'])->name('search');
Route::get('/search/live', [StoreController::class, 'searchLive'])->name('search.live');

// Policy Pages
Route::prefix('policies')->name('policy.')->group(function () {
    Route::get('/shipping', [StoreController::class, 'shippingPolicy'])->name('shipping');
    Route::get('/returns', [StoreController::class, 'returnsPolicy'])->name('returns');
    Route::get('/privacy', [StoreController::class, 'privacyPolicy'])->name('privacy');
});

// XML Sitemap for Search Engines
Route::get('/sitemap.xml', [StoreController::class, 'sitemap'])->name('sitemap');


/*
|--------------------------------------------------------------------------
| Atelier Executive Admin Backend Routes
|--------------------------------------------------------------------------
| Full administration system matching the Executive Atelier Control Center.
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Authentication Routes
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Protected Admin Panel Routes
    Route::middleware('admin.auth')->group(function () {
        // Executive Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.home');

        // Products Catalog
        Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

        // Deals & Bundles Module
        Route::get('/deals', [AdminDealController::class, 'index'])->name('deals.index');
        Route::get('/deals/create', [AdminDealController::class, 'create'])->name('deals.create');
        Route::post('/deals', [AdminDealController::class, 'store'])->name('deals.store');
        Route::get('/deals/{deal}/edit', [AdminDealController::class, 'edit'])->name('deals.edit');
        Route::put('/deals/{deal}', [AdminDealController::class, 'update'])->name('deals.update');
        Route::delete('/deals/{deal}', [AdminDealController::class, 'destroy'])->name('deals.destroy');
        Route::post('/deals/{deal}/toggle', [AdminDealController::class, 'toggleStatus'])->name('deals.toggle');

        // Categories
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

        // Subcategories
        Route::get('/subcategories', [AdminSubcategoryController::class, 'index'])->name('subcategories.index');
        Route::post('/subcategories', [AdminSubcategoryController::class, 'store'])->name('subcategories.store');
        Route::put('/subcategories/{subcategory}', [AdminSubcategoryController::class, 'update'])->name('subcategories.update');
        Route::delete('/subcategories/{subcategory}', [AdminSubcategoryController::class, 'destroy'])->name('subcategories.destroy');

        // Inventory & Stock
        Route::get('/inventory', [AdminInventoryController::class, 'index'])->name('inventory.index');
        Route::post('/inventory/{product}/update', [AdminInventoryController::class, 'updateStock'])->name('inventory.update');
        Route::post('/inventory/{product}/bespoke', [AdminInventoryController::class, 'switchBespoke'])->name('inventory.bespoke');

        // Store Orders & Printing
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/live-check', [AdminOrderController::class, 'liveCheck'])->name('orders.live-check');
        Route::post('/orders/mark-all-read', [AdminOrderController::class, 'markAllRead'])->name('orders.mark-all-read');
        Route::get('/orders/print-report', [AdminOrderController::class, 'printReport'])->name('orders.print-report');
        Route::post('/orders/bulk-action', [AdminOrderController::class, 'bulkAction'])->name('orders.bulk-action');
        Route::post('/orders/{order}/courier', [AdminOrderController::class, 'updateCourier'])->name('orders.courier');
        Route::post('/orders/{order}/toggle-read', [AdminOrderController::class, 'toggleRead'])->name('orders.toggle-read');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('/orders/{order}/invoice', [AdminOrderController::class, 'invoice'])->name('orders.invoice');
        Route::get('/orders/{order}/packing-slip', [AdminOrderController::class, 'packingSlip'])->name('orders.packing-slip');
        Route::get('/orders/{order}/receipt', [AdminOrderController::class, 'receipt'])->name('orders.receipt');
        Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

        // Abandoned Carts & Drop-off Recovery
        Route::get('/abandoned-carts', [AdminAbandonedCartController::class, 'index'])->name('abandoned-carts.index');
        Route::post('/abandoned-carts/{cart}/whatsapp', [AdminAbandonedCartController::class, 'sendRecovery'])->name('abandoned-carts.whatsapp');
        Route::post('/abandoned-carts/{cart}/recover', [AdminAbandonedCartController::class, 'markRecovered'])->name('abandoned-carts.recover');
        Route::delete('/abandoned-carts/{cart}', [AdminAbandonedCartController::class, 'destroy'])->name('abandoned-carts.destroy');

        // Coupon & Promo Code Engine
        Route::get('/coupons', [AdminCouponController::class, 'index'])->name('coupons.index');
        Route::post('/coupons', [AdminCouponController::class, 'store'])->name('coupons.store');
        Route::put('/coupons/{coupon}', [AdminCouponController::class, 'update'])->name('coupons.update');
        Route::post('/coupons/{coupon}/toggle', [AdminCouponController::class, 'toggle'])->name('coupons.toggle');
        Route::delete('/coupons/{coupon}', [AdminCouponController::class, 'destroy'])->name('coupons.destroy');

        // Customer & Client Dossiers
        Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
        Route::post('/customers/{customer}/vip', [AdminCustomerController::class, 'toggleVip'])->name('customers.vip');
        Route::put('/customers/{customer}', [AdminCustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{customer}', [AdminCustomerController::class, 'destroy'])->name('customers.destroy');

        // Concierge Messages / Inquiries
        Route::get('/messages', [AdminInquiryController::class, 'index'])->name('messages.index');
        Route::post('/messages/{inquiry}/resolve', [AdminInquiryController::class, 'markResolved'])->name('messages.resolve');
        Route::delete('/messages/{inquiry}', [AdminInquiryController::class, 'destroy'])->name('messages.destroy');

        // Customer Reviews
        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::post('/reviews/{review}/publish', [AdminReviewController::class, 'togglePublish'])->name('reviews.publish');
        Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

        // Financial Export & Analytics Dashboard
        Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics.index');
        Route::get('/analytics/export/orders', [AdminAnalyticsController::class, 'exportOrders'])->name('analytics.export.orders');
        Route::get('/analytics/export/tax', [AdminAnalyticsController::class, 'exportTaxSummary'])->name('analytics.export.tax');
        Route::get('/analytics/export/inventory', [AdminAnalyticsController::class, 'exportAgingInventory'])->name('analytics.export.inventory');

        // Staff & Roles (RBAC)
        Route::get('/staff', [AdminStaffController::class, 'index'])->name('staff.index');
        Route::post('/staff', [AdminStaffController::class, 'store'])->name('staff.store');
        Route::put('/staff/{staff}', [AdminStaffController::class, 'update'])->name('staff.update');
        Route::delete('/staff/{staff}', [AdminStaffController::class, 'destroy'])->name('staff.destroy');

        // Store Settings
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

        // Global Unified Search & Live Autocomplete
        Route::get('/search', [AdminSearchController::class, 'index'])->name('search');
        Route::get('/search/live', [AdminSearchController::class, 'live'])->name('search.live');
    });
});
