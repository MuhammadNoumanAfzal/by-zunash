<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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
     * Shop Catalog with filtering, sorting, and pagination (12 per page)
     */
    public function shop(Request $request)
    {
        $allProducts = $this->getProducts();
        $products = clone $allProducts;
        $categories = $this->getCategories();

        // Calculate counts per category
        $categoryCounts = $allProducts->groupBy('category')->map->count();
        $totalAllCount = $allProducts->count();

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

        // Filter by curated tag / badge
        if ($request->filled('tag')) {
            $tag = $request->input('tag');
            if ($tag === 'bestseller') {
                $products = $products->where('is_bestseller', true);
            } elseif ($tag === 'new') {
                $products = $products->where('is_new', true);
            }
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
                $products = $products->sortBy('price')->values();
                break;
            case 'price_high':
                $products = $products->sortByDesc('price')->values();
                break;
            case 'latest':
                $products = $products->sortByDesc('is_new')->values();
                break;
            case 'popularity':
                $products = $products->sortByDesc('reviews_count')->values();
                break;
            default:
                // Featured order: Show our flagship creations with bespoke studio photography on Page 1
                $featuredOrder = [1, 5, 9, 13, 2, 6, 10, 17, 14, 15, 18, 19, 3, 4, 7, 8, 11, 12, 16, 20];
                $products = $products->sortBy(function ($item) use ($featuredOrder) {
                    $pos = array_search($item['id'], $featuredOrder);
                    return $pos !== false ? $pos : 999;
                })->values();
                break;
        }

        $activeCategory = $request->input('category', 'all');

        // Pagination: Exactly 12 items per page
        $perPage = 12;
        $currentPage = (int) $request->input('page', 1);
        if ($currentPage < 1) {
            $currentPage = 1;
        }
        $totalItems = $products->count();
        $currentPageItems = $products->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedProducts = new LengthAwarePaginator(
            $currentPageItems,
            $totalItems,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('user.shop', [
            'products' => $paginatedProducts,
            'categories' => $categories,
            'activeCategory' => $activeCategory,
            'categoryCounts' => $categoryCounts,
            'totalAllCount' => $totalAllCount,
            'filteredTotal' => $totalItems,
        ]);
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
     * Client Reviews & Testimonials page
     */
    public function reviews()
    {
        $reviews = [
            [
                'id' => 1,
                'author' => 'Dr. Hamza Khan',
                'city' => 'Lahore (DHA Phase 5)',
                'initials' => 'HK',
                'category' => 'belts',
                'product_name' => 'The Royal Reversible Calfskin Belt',
                'product_slug' => 'the-royal-reversible-calfskin-belt',
                'rating' => 5,
                'date' => 'October 14, 2026',
                'verified' => true,
                'title' => 'The swivel buckle mechanism is sheer mechanical perfection',
                'comment' => 'Without question the finest leather belt I have purchased in Pakistan. The swivel mechanism has a solid, authoritative click that transitions between obsidian black and rich espresso calfskin effortlessly. The beveled wax-burnished edge does not crease under daily wear.',
                'image' => '/images/products/prod-reversible-belt.jpg',
                'helpful' => 48,
            ],
            [
                'id' => 2,
                'author' => 'Ayesha Tariq',
                'city' => 'Islamabad (F-7/2)',
                'initials' => 'AT',
                'category' => 'handbags',
                'product_name' => 'The Zunash Signature Satchel',
                'product_slug' => 'the-zunash-signature-satchel',
                'rating' => 5,
                'date' => 'October 08, 2026',
                'verified' => true,
                'title' => 'Rivals European luxury fashion houses in every detail',
                'comment' => 'I was initially hesitant to order fine leather online, but the doorstep Cash on Delivery made it risk-free. The packaging alone was regal—a magnetic rigid box with a linen dust pouch. The aroma of genuine vegetable-tanned hide and custom 24k gold hardware are exceptional.',
                'image' => '/images/products/prod-signature-satchel.jpg',
                'helpful' => 39,
            ],
            [
                'id' => 3,
                'author' => 'Bilal Mansoor',
                'city' => 'Karachi (Clifton Block 4)',
                'initials' => 'BM',
                'category' => 'wallets',
                'product_name' => 'The Heritage Bifold Leather Wallet',
                'product_slug' => 'the-heritage-bifold-leather-wallet',
                'rating' => 5,
                'date' => 'September 29, 2026',
                'verified' => true,
                'title' => 'Calibrated perfectly for PKR 5000 banknotes',
                'comment' => 'Most imported bifold wallets crush Pakistani currency notes or bulge awkwardly in tailored suit breast pockets. This wallet is sized with dual compartments for PKR 5000 notes and receipts while maintaining an ultra-slim profile. The RFID lining adds genuine peace of mind.',
                'image' => '/images/products/prod-bifold-wallet.jpg',
                'helpful' => 52,
            ],
            [
                'id' => 4,
                'author' => 'Barrister Daniyal Qureshi',
                'city' => 'Rawalpindi (Cantt)',
                'initials' => 'DQ',
                'category' => 'belts',
                'product_name' => 'Hand-Burnished Classic Dress Belt',
                'product_slug' => 'hand-burnished-classic-dress-belt',
                'rating' => 5,
                'date' => 'September 22, 2026',
                'verified' => true,
                'title' => 'Subtle domed profile and gorgeous natural patina',
                'comment' => 'Pairs impeccably with tailored bespoke suiting. The feather-edge craftsmanship and warm cognac patina look even richer in person than in the studio photos. Priority courier arrived in Rawalpindi within 28 hours.',
                'image' => '/images/products/prod-dress-belt.jpg',
                'helpful' => 31,
            ],
            [
                'id' => 5,
                'author' => 'Fatima Jahangir',
                'city' => 'Lahore (Gulberg III)',
                'initials' => 'FJ',
                'category' => 'handbags',
                'product_name' => 'The Empress Structured Leather Tote',
                'product_slug' => 'the-empress-structured-leather-tote',
                'rating' => 5,
                'date' => 'September 15, 2026',
                'verified' => true,
                'title' => 'Carries my 14" laptop with seamless grace',
                'comment' => 'As a corporate consultant, finding a work carryall that does not sag after months of heavy use is nearly impossible. The structured calfskin holds its silhouette upright on the solid brass base studs. Highly recommend.',
                'image' => '/images/products/prod-leather-tote.jpg',
                'helpful' => 27,
            ],
            [
                'id' => 6,
                'author' => 'Capt. Usman Raza',
                'city' => 'Peshawar',
                'initials' => 'UR',
                'category' => 'accessories',
                'product_name' => 'The Atelier Solid Brass Key Fob',
                'product_slug' => 'the-atelier-solid-brass-key-fob',
                'rating' => 5,
                'date' => 'September 04, 2026',
                'verified' => true,
                'title' => 'Heavy antique brass hardware and thick steer hide',
                'comment' => 'The solid brass hardware is reassuringly heavy and rugged. Ordered as a personal gift for my vehicle keys. Outstanding craftsmanship from the Lahore workshop.',
                'image' => '/images/products/prod-key-fob.jpg',
                'helpful' => 22,
            ],
            [
                'id' => 7,
                'author' => 'Zainab Malik',
                'city' => 'Faisalabad',
                'initials' => 'ZM',
                'category' => 'shoulder-bags',
                'product_name' => 'The Regent Saddle Crossbody',
                'product_slug' => 'the-regent-saddle-crossbody',
                'rating' => 5,
                'date' => 'August 28, 2026',
                'verified' => true,
                'title' => 'Effortless crossbody drape and rich pull-up leather',
                'comment' => 'The contrast ivory stitching against warm saddle tan is breathtaking. The strap length is versatile for casual evenings and travel.',
                'image' => '/images/products/prod-flap-bag.jpg',
                'helpful' => 19,
            ],
            [
                'id' => 8,
                'author' => 'Saadullah Sheikh',
                'city' => 'Multan',
                'initials' => 'SS',
                'category' => 'wallets',
                'product_name' => 'Minimalist Slim Cardholder',
                'product_slug' => 'minimalist-slim-cardholder',
                'rating' => 5,
                'date' => 'August 19, 2026',
                'verified' => true,
                'title' => 'Front pocket perfection for daily cards',
                'comment' => 'Holds 6 cards and folded cash in the center slip pocket without any pocket bulge. The leather has already darkened into a stunning vintage luster.',
                'image' => '/images/products/prod-cardholder.jpg',
                'helpful' => 24,
            ],
        ];

        return view('user.reviews', compact('reviews'));
    }

    /**
     * Submit client review
     */
    public function submitReview(Request $request)
    {
        $request->validate([
            'author' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'product_name' => 'required|string|max:150',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:150',
            'comment' => 'required|string|min:10|max:2000',
        ]);

        return back()->with('review_success', 'Thank you for sharing your experience. Your client review has been verified and recorded.');
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
