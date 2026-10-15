<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;

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
Route::get('/product/{slug}', [StoreController::class, 'productDetails'])->name('product.details');

// Cart & Checkout
Route::get('/cart', [StoreController::class, 'cart'])->name('cart');
Route::get('/checkout', [StoreController::class, 'checkout'])->name('checkout');

// Wishlist
Route::get('/wishlist', [StoreController::class, 'wishlist'])->name('wishlist');

// Brand Story & Information
Route::get('/about', [StoreController::class, 'about'])->name('about');
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

