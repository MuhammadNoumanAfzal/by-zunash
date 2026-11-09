<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class StoreController extends Controller
{
    /**
     * Retrieve all products collection from database with fallback to config
     */
    protected function getProducts(): Collection
    {
        $dbProducts = \App\Models\Product::all();
        if ($dbProducts->isNotEmpty()) {
            return $dbProducts->map(function ($p) {
                return [
                    'id' => $p->id,
                    'slug' => $p->slug,
                    'name' => $p->name,
                    'category' => $p->category_slug,
                    'category_name' => $p->category_name,
                    'price' => (float) $p->price,
                    'original_price' => $p->original_price ? (float) $p->original_price : null,
                    'badge' => $p->badge,
                    'is_bestseller' => (bool) $p->is_bestseller,
                    'is_new' => (bool) $p->is_new,
                    'in_stock' => (bool) $p->in_stock,
                    'availability' => $p->availability,
                    'stock_quantity' => $p->stock_quantity,
                    'sku' => $p->sku,
                    'rating' => (float) $p->rating,
                    'reviews_count' => (int) $p->reviews_count,
                    'short_description' => $p->short_description,
                    'description' => $p->description,
                    'image' => $p->image,
                    'gallery' => is_array($p->gallery) ? $p->gallery : [],
                    'features' => is_array($p->features) ? $p->features : [],
                    'specifications' => is_array($p->specifications) ? $p->specifications : [],
                    'colors' => is_array($p->colors) ? $p->colors : [],
                ];
            });
        }

        return collect(config('products.items', []));
    }

    /**
     * Retrieve all categories from database with fallback to config
     */
    protected function getCategories(): array
    {
        $dbCategories = \App\Models\Category::withCount('products')->orderBy('sort_order')->get();
        if ($dbCategories->isNotEmpty()) {
            $result = [];
            foreach ($dbCategories as $cat) {
                $result[$cat->slug] = [
                    'id' => $cat->id,
                    'slug' => $cat->slug,
                    'name' => $cat->name,
                    'tagline' => $cat->tagline,
                    'image' => $cat->image,
                    'count' => $cat->products_count,
                ];
            }
            return $result;
        }

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
            } elseif ($tag === 'on_demand') {
                $products = $products->where('availability', 'on_demand');
            } elseif ($tag === 'deal') {
                $dealProductIds = \App\Models\Deal::active()->with('products')->get()->pluck('products')->flatten()->pluck('id')->unique()->toArray();
                $products = $products->whereIn('id', $dealProductIds);
            } elseif ($tag === 'out_of_stock') {
                $products = $products->filter(function ($p) {
                    return ($p['availability'] ?? '') === 'out_of_stock' || (isset($p['in_stock']) && !$p['in_stock']);
                });
            }
        }

        // Filter by stock availability
        if ($request->filled('availability')) {
            $avail = $request->input('availability');
            if ($avail === 'in_stock') {
                $products = $products->filter(function ($p) {
                    return ($p['availability'] ?? 'in_stock') === 'in_stock' && ($p['in_stock'] ?? true);
                });
            } elseif ($avail === 'out_of_stock') {
                $products = $products->filter(function ($p) {
                    return ($p['availability'] ?? '') === 'out_of_stock' || (isset($p['in_stock']) && !$p['in_stock']);
                });
            } elseif ($avail === 'on_demand') {
                $products = $products->where('availability', 'on_demand');
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
                // Featured order: Show flagship creations on Page 1
                $featuredOrder = [1, 5, 9, 13, 2, 6, 10, 17, 22, 23, 14, 15, 18, 19, 3, 4, 7, 8, 11, 12, 16, 20, 21];
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
            'dealsCount' => \App\Models\Deal::active()->count(),
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

        // Find active companion deals/bundles that include this product
        $companionDeals = \App\Models\Deal::active()
            ->whereHas('products', function ($q) use ($product) {
                $q->where('products.id', $product['id']);
            })
            ->with('products')
            ->get();

        return view('user.product-details', compact('product', 'relatedProducts', 'companionDeals'));
    }

    /**
     * Deals & Curated Bundles page
     */
    public function deals(Request $request)
    {
        $deals = \App\Models\Deal::active()
            ->with('products')
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $categories = $this->getCategories();

        return view('user.deals', compact('deals', 'categories'));
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
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:150',
            'message' => 'required|string|min:10|max:2000',
        ]);

        \App\Models\Inquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'unread',
            'is_read' => false,
        ]);

        return back()->with('success', 'Thank you for reaching out to By Zunash. Our client care team will respond within 24 business hours.');
    }

    /**
     * Client Reviews & Testimonials page
     */
    public function reviews()
    {
        $dbReviews = \App\Models\Review::where('status', 'published')->latest()->get();

        if ($dbReviews->isNotEmpty()) {
            $reviews = $dbReviews->map(function ($r) {
                return [
                    'id' => $r->id,
                    'author' => $r->author,
                    'city' => $r->city,
                    'initials' => $r->initials ?: strtoupper(substr($r->author, 0, 2)),
                    'category' => $r->category ?: 'belts',
                    'product_name' => $r->product_name,
                    'product_slug' => $r->product_slug ?: \Illuminate\Support\Str::slug($r->product_name),
                    'rating' => $r->rating,
                    'date' => $r->created_at ? $r->created_at->format('F d, Y') : 'Recent',
                    'verified' => (bool) $r->verified,
                    'title' => $r->title,
                    'comment' => $r->comment,
                    'image' => $r->image ?: '/images/products/prod-reversible-belt.jpg',
                    'helpful' => (int) $r->helpful,
                ];
            })->toArray();
        } else {
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
            ];
        }

        return view('user.reviews', compact('reviews'));
    }

    /**
     * Submit client review
     */
    public function submitReview(Request $request)
    {
        $validated = $request->validate([
            'author' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'product_name' => 'required|string|max:150',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:150',
            'comment' => 'required|string|min:10|max:2000',
        ]);

        \App\Models\Review::create([
            'author' => $validated['author'],
            'city' => $validated['city'],
            'initials' => strtoupper(substr($validated['author'], 0, 2)),
            'product_name' => $validated['product_name'],
            'product_slug' => \Illuminate\Support\Str::slug($validated['product_name']),
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'comment' => $validated['comment'],
            'status' => 'published',
            'verified' => true,
        ]);

        return back()->with('review_success', 'Thank you for sharing your experience. Your client review has been verified and recorded.');
    }

    /**
     * Process checkout submission via API or Form
     */
    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required|string|max:30',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'order_notes' => 'nullable|string|max:500',
            'payment_method' => 'nullable|string|max:50',
            'items' => 'required|array',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        $orderNumber = 'BZ-' . date('Ym') . '-' . rand(1000, 9999);
        $fullName = trim($validated['first_name'] . ' ' . $validated['last_name']);

        $order = \App\Models\Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $fullName,
            'customer_email' => $validated['email'],
            'customer_phone' => $validated['phone'],
            'shipping_address' => $validated['address'],
            'city' => $validated['city'],
            'postal_code' => $validated['postal_code'] ?? null,
            'order_notes' => $validated['order_notes'] ?? null,
            'payment_method' => strtoupper($validated['payment_method'] ?? 'COD'),
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'subtotal' => $validated['subtotal'],
            'shipping_fee' => 0.00,
            'discount' => 0.00,
            'total' => $validated['total'],
            'items' => $validated['items'],
        ]);

        // Customer auto sync
        $customer = \App\Models\Customer::firstOrNew(['email' => $validated['email']]);
        $customer->name = $fullName;
        $customer->phone = $validated['phone'];
        $customer->city = $validated['city'];
        $customer->address = $validated['address'];
        $customer->total_orders = ($customer->total_orders ?? 0) + 1;
        $customer->total_spent = ($customer->total_spent ?? 0) + $validated['total'];
        $customer->save();

        return response()->json([
            'success' => true,
            'order_number' => $orderNumber,
            'message' => 'Order successfully placed!',
        ]);
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
