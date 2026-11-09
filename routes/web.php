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
Route::get('/product/{slug}', [StoreController::class, 'productDetails'])->name('product.details');

// Cart & Checkout
Route::get('/cart', [StoreController::class, 'cart'])->name('cart');
Route::get('/checkout', [StoreController::class, 'checkout'])->name('checkout');
Route::post('/api/checkout/process', [StoreController::class, 'processCheckout'])->name('checkout.process');

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

        // Store Orders & Invoices
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('/orders/{order}/invoice', [AdminOrderController::class, 'invoice'])->name('orders.invoice');
        Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

        // VIP Customers
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

        // Staff & Roles (RBAC)
        Route::get('/staff', [AdminStaffController::class, 'index'])->name('staff.index');
        Route::post('/staff', [AdminStaffController::class, 'store'])->name('staff.store');
        Route::put('/staff/{staff}', [AdminStaffController::class, 'update'])->name('staff.update');
        Route::delete('/staff/{staff}', [AdminStaffController::class, 'destroy'])->name('staff.destroy');

        // Store Settings
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
    });
});
