<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class StoreController extends Controller
{
    /**
     * Retrieve all products collection from config
     */
    protected function getProducts(): Collection
    {
        return collect(config('products.items', []));
    }

    /**
     * Retrieve all categories from config
     */
    protected function getCategories(): array
    {
        return config('products.categories', []);
    }

    /**
     * Homepage
     */
    public function home()
    {
        $products = $this->getProducts();
        $categories = $this->getCategories();

        $featuredBestsellerIds = [1, 5, 9, 13, 2, 6, 10, 17];
        $bestsellers = $products->whereIn('id', $featuredBestsellerIds)
            ->sortBy(function ($p) use ($featuredBestsellerIds) {
                return array_search($p['id'], $featuredBestsellerIds);
            })
            ->values();

        if ($bestsellers->count() < 8) {
            $bestsellers = $products->take(8);
        }
        $newArrivals = $products->where('is_new', true)->take(4);

        return view('user.home', compact('bestsellers', 'newArrivals', 'categories'));
    }

    /**
     * Shop Catalog with filtering and sorting
     */
    public function shop(Request $request)
    {
        $products = $this->getProducts();
        $categories = $this->getCategories();

        // Filter by category
        if ($request->filled('category')) {
            $catSlug = $request->input('category');
            if ($catSlug !== 'all') {
                $products = $products->where('category', $catSlug);
            }
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $minPrice = (int) $request->input('min_price');
            $products = $products->where('price', '>=', $minPrice);
        }
        if ($request->filled('max_price')) {
            $maxPrice = (int) $request->input('max_price');
            $products = $products->where('price', '<=', $maxPrice);
        }

        // Filter by search query
        if ($request->filled('q')) {
            $query = strtolower(trim($request->input('q')));
            $products = $products->filter(function ($item) use ($query) {
                return str_contains(strtolower($item['name']), $query)
                    || str_contains(strtolower($item['short_description']), $query)
                    || str_contains(strtolower($item['category_name']), $query);
            });
        }

        // Sorting
        $sort = $request->input('sort', 'featured');
        switch ($sort) {
            case 'price_low':
                $products = $products->sortBy('price');
                break;
            case 'price_high':
                $products = $products->sortByDesc('price');
                break;
            case 'latest':
                $products = $products->sortByDesc('is_new');
                break;
            case 'popularity':
                $products = $products->sortByDesc('reviews_count');
                break;
            default:
                // Default featured order
                break;
        }

        $activeCategory = $request->input('category', 'all');

        return view('user.shop', compact('products', 'categories', 'activeCategory'));
    }

    /**
     * Category page
     */
    public function category($slug)
    {
        $categories = $this->getCategories();

        if (!isset($categories[$slug])) {
            abort(404, 'Category not found.');
        }

        $category = $categories[$slug];
        $products = $this->getProducts()->where('category', $slug);

        return view('user.category', compact('category', 'products', 'categories'));
    }

    /**
     * Product details page
     */
    public function productDetails($slug)
    {
        $product = $this->getProducts()->firstWhere('slug', $slug);

        if (!$product) {
            abort(404, 'Product not found.');
        }

        // Related products in same category
        $relatedProducts = $this->getProducts()
            ->where('category', $product['category'])
            ->where('id', '!=', $product['id'])
            ->take(4);

        return view('user.product-details', compact('product', 'relatedProducts'));
    }

    /**
     * Cart page
     */
    public function cart()
    {
        return view('user.cart');
    }

    /**
     * Checkout page
     */
    public function checkout()
    {
        $pakistaniCities = [
            'Karachi', 'Lahore', 'Islamabad', 'Rawalpindi', 'Faisalabad',
            'Peshawar', 'Multan', 'Gujranwala', 'Quetta', 'Sialkot',
            'Hyderabad', 'Bahawalpur', 'Sargodha', 'Abbottabad', 'Sukkur',
            'Larkana', 'Sheikhupura', 'Jhelum', 'Gujrat', 'Mardan'
        ];

        return view('user.checkout', compact('pakistaniCities'));
    }

    /**
     * Wishlist page
     */
    public function wishlist()
    {
        return view('user.wishlist');
    }

    /**
     * About page
     */
    public function about()
    {
        return view('user.about');
    }

    /**
     * Contact page
     */
    public function contact()
    {
        return view('user.contact');
    }

    /**
     * Process contact form submission (frontend simulation with validation)
     */
    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|min:10|max:2000',
        ]);

        return back()->with('success', 'Thank you for reaching out to By Zunash. Our client care team will respond within 24 business hours.');
    }

    /**
     * FAQ page
     */
    public function faq()
    {
        return view('user.faq');
    }

    /**
     * Search page
     */
    public function search(Request $request)
    {
        $query = trim($request->input('q', ''));
        $products = collect();

        if (!empty($query)) {
            $lowerQuery = strtolower($query);
            $products = $this->getProducts()->filter(function ($item) use ($lowerQuery) {
                return str_contains(strtolower($item['name']), $lowerQuery)
                    || str_contains(strtolower($item['short_description']), $lowerQuery)
                    || str_contains(strtolower($item['category_name']), $lowerQuery);
            });
        }

        return view('user.search', compact('products', 'query'));
    }

    /**
     * Shipping Policy
     */
    public function shippingPolicy()
    {
        return view('user.policies.shipping');
    }

    /**
     * Returns Policy
     */
    public function returnsPolicy()
    {
        return view('user.policies.returns');
    }

    /**
     * Privacy Policy
     */
    public function privacyPolicy()
    {
        return view('user.policies.privacy');
    }

    /**
     * XML Sitemap for Google, Bing, and search crawlers
     */
    public function sitemap()
    {
        $products = $this->getProducts();
        $categories = $this->getCategories();

        $xml = view('user.sitemap', compact('products', 'categories'))->render();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
}
