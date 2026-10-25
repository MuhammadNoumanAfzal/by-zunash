<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Inquiry;
use App\Models\Review;
use App\Models\StoreSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admins (By Zunash Executive Team)
        Admin::updateOrCreate(
            ['email' => 'admin@byzunash.com'],
            [
                'name' => 'Zunash Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'avatar' => null,
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'admin@mehaaj.de'],
            [
                'name' => 'Zunash Executive',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'avatar' => null,
            ]
        );

        // 2. Categories & Subcategories
        $categoriesConfig = config('products.categories', []);
        $categoryModelMap = [];

        $sort = 1;
        foreach ($categoriesConfig as $slug => $data) {
            $cat = Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'] ?? ucfirst($slug),
                    'tagline' => $data['tagline'] ?? null,
                    'image' => $data['image'] ?? null,
                    'sort_order' => $sort++,
                ]
            );
            $categoryModelMap[$slug] = $cat;

            // Seed subcategories
            $subcats = match ($slug) {
                'belts' => ['Formal Dress Belts', 'Casual Jean Belts', 'Reversible Belts'],
                'wallets' => ['Classic Bifolds', 'Cardholders & Sliders', 'Passport Wallets'],
                'handbags' => ['Structured Totes', 'Satchel Bags', 'Evening Clutches'],
                'shoulder-bags' => ['Crossbody Bags', 'Saddle Bags', 'Messenger Bags'],
                'accessories' => ['Solid Brass Key Fobs', 'Desk Mats & Trays', 'Travel Folios'],
                'on-demand' => ['Monogrammed Editions', 'Custom Bespoke Hides'],
                default => ['Signature Creations']
            };

            foreach ($subcats as $subName) {
                Subcategory::firstOrCreate([
                    'category_id' => $cat->id,
                    'slug' => \Illuminate\Support\Str::slug($subName),
                ], [
                    'name' => $subName,
                    'description' => "Curated selection of {$subName} in fine leather."
                ]);
            }
        }

        // 3. Products
        $items = config('products.items', []);
        $lowStockProductIds = [3, 7, 14, 21]; // exactly 4 low stock items for "4 Low" badge

        foreach ($items as $index => $item) {
            $catSlug = $item['category'] ?? 'belts';
            $categoryId = isset($categoryModelMap[$catSlug]) ? $categoryModelMap[$catSlug]->id : null;
            $isLowStock = in_array($item['id'] ?? ($index + 1), $lowStockProductIds);
            $stock = $isLowStock ? rand(2, 4) : rand(12, 38);

            Product::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'name' => $item['name'],
                    'category_id' => $categoryId,
                    'category_slug' => $catSlug,
                    'category_name' => $item['category_name'] ?? ucfirst($catSlug),
                    'price' => $item['price'] ?? 4950,
                    'original_price' => $item['original_price'] ?? null,
                    'sku' => 'BZ-' . strtoupper(substr($catSlug, 0, 3)) . '-' . str_pad($item['id'] ?? ($index + 1), 3, '0', STR_PAD_LEFT),
                    'badge' => $item['badge'] ?? null,
                    'is_bestseller' => $item['is_bestseller'] ?? false,
                    'is_new' => $item['is_new'] ?? false,
                    'in_stock' => ($item['availability'] ?? 'in_stock') !== 'out_of_stock',
                    'availability' => $item['availability'] ?? 'in_stock',
                    'stock_quantity' => $stock,
                    'rating' => $item['rating'] ?? 5.0,
                    'reviews_count' => $item['reviews_count'] ?? 10,
                    'short_description' => $item['short_description'] ?? null,
                    'description' => $item['description'] ?? null,
                    'image' => $item['image'] ?? null,
                    'gallery' => $item['gallery'] ?? [],
                    'features' => $item['features'] ?? [],
                    'specifications' => $item['specifications'] ?? [],
                    'colors' => $item['colors'] ?? [],
                ]
            );
        }

        // Additional luxury creations to reach exact 27 products (matching Executive Control Center)
        $extraProducts = [
            [
                'name' => 'The Grand Weekender Leather Holdall',
                'slug' => 'the-grand-weekender-leather-holdall',
                'category_slug' => 'handbags',
                'category_name' => 'Handbags',
                'price' => 14850,
                'original_price' => 17500,
                'badge' => 'Masterpiece',
                'is_bestseller' => true,
                'is_new' => true,
                'in_stock' => true,
                'availability' => 'in_stock',
                'stock_quantity' => 8,
                'image' => '/images/products/prod-signature-satchel.jpg',
                'short_description' => 'Cabin-approved full-grain leather weekender duffle bag with brass hardware.',
            ],
            [
                'name' => 'Alligator-Grain Watch Collector Roll',
                'slug' => 'alligator-grain-watch-collector-roll',
                'category_slug' => 'accessories',
                'category_name' => 'Everyday Accessories',
                'price' => 6400,
                'original_price' => 7500,
                'badge' => 'New',
                'is_bestseller' => false,
                'is_new' => true,
                'in_stock' => true,
                'availability' => 'in_stock',
                'stock_quantity' => 14,
                'image' => '/images/products/prod-cardholder.jpg',
                'short_description' => 'Triple-cushion horology travel case lined in micro-suede.',
            ],
            [
                'name' => 'Bespoke Monogrammed Heritage Desk Blotter',
                'slug' => 'bespoke-monogrammed-heritage-desk-blotter',
                'category_slug' => 'on-demand',
                'category_name' => 'On Demand & Bespoke',
                'price' => 8900,
                'original_price' => 9900,
                'badge' => 'Bespoke',
                'is_bestseller' => false,
                'is_new' => false,
                'in_stock' => false,
                'availability' => 'on_demand',
                'stock_quantity' => 0,
                'image' => '/images/brand/artisan-craft.jpg',
                'short_description' => 'Hand-cut steerhide desk protector tailored with gold-foiled edge stamping.',
            ],
            [
                'name' => 'Executive Calfskin Document Folio',
                'slug' => 'executive-calfskin-document-folio',
                'category_slug' => 'on-demand',
                'category_name' => 'On Demand & Bespoke',
                'price' => 7200,
                'original_price' => 8200,
                'badge' => 'Bespoke',
                'is_bestseller' => false,
                'is_new' => false,
                'in_stock' => false,
                'availability' => 'on_demand',
                'stock_quantity' => 0,
                'image' => '/images/brand/stitch-detail.jpg',
                'short_description' => 'Slim zippered A4 conference folio with solid brass pull.',
            ],
        ];

        foreach ($extraProducts as $extra) {
            Product::updateOrCreate(
                ['slug' => $extra['slug']],
                array_merge($extra, [
                    'category_id' => isset($categoryModelMap[$extra['category_slug']]) ? $categoryModelMap[$extra['category_slug']]->id : null,
                    'sku' => 'BZ-' . strtoupper(substr($extra['category_slug'], 0, 3)) . '-' . rand(100, 999),
                    'rating' => 5.0,
                    'reviews_count' => 6,
                    'description' => $extra['short_description'],
                    'gallery' => [$extra['image']],
                    'features' => ['Hand-burnished edges', 'Solid brass details'],
                    'specifications' => ['Leather' => 'Full-Grain Calfskin'],
                    'colors' => [['name' => 'Burgundy Brown', 'hex' => '#4A1D1A']],
                ])
            );
        }

        // 4. Customers (Authentic By Zunash Pakistani VIP & Patron Roster)
        $customersData = [
            [
                'name' => 'Dr. Hamza Khan',
                'email' => 'hamza.khan@lahore.pk',
                'phone' => '+92 300 8472910',
                'city' => 'Lahore',
                'address' => 'Sector Y, Phase 5, DHA, Lahore',
                'is_vip' => true,
                'total_orders' => 4,
                'total_spent' => 48650.00,
            ],
            [
                'name' => 'Ayesha Tariq',
                'email' => 'ayesha.tariq@islamabad.pk',
                'phone' => '+92 321 5567890',
                'city' => 'Islamabad',
                'address' => 'Street 14, Sector F-7/2, Islamabad',
                'is_vip' => false,
                'total_orders' => 2,
                'total_spent' => 32650.00,
            ],
            [
                'name' => 'Bilal Mansoor',
                'email' => 'bilal.mansoor@karachi.pk',
                'phone' => '+92 333 2244668',
                'city' => 'Karachi',
                'address' => 'Block 4, Clifton, Karachi',
                'is_vip' => false,
                'total_orders' => 2,
                'total_spent' => 19800.00,
            ],
            [
                'name' => 'Barrister Daniyal Qureshi',
                'email' => 'daniyal.qureshi@chambers.pk',
                'phone' => '+92 301 9876543',
                'city' => 'Rawalpindi',
                'address' => 'Mall Road, Cantt, Rawalpindi',
                'is_vip' => false,
                'total_orders' => 2,
                'total_spent' => 11900.00,
            ],
            [
                'name' => 'Fatima Jahangir',
                'email' => 'fatima.j@lahore-corp.pk',
                'phone' => '+92 300 1238899',
                'city' => 'Lahore',
                'address' => 'Ali Block, New Garden Town, Lahore',
                'is_vip' => false,
                'total_orders' => 1,
                'total_spent' => 18900.00,
            ],
            [
                'name' => 'Capt. Usman Raza',
                'email' => 'usman.raza@paf.pk',
                'phone' => '+92 345 8899770',
                'city' => 'Peshawar',
                'address' => 'Saddar Road, Cantt, Peshawar',
                'is_vip' => false,
                'total_orders' => 1,
                'total_spent' => 4950.00,
            ],
        ];

        foreach ($customersData as $c) {
            Customer::updateOrCreate(['email' => $c['email']], $c);
        }

        // 5. Orders (By Zunash Handcrafted Orders)
        $orders = [
            [
                'order_number' => 'BZ-202610-0101',
                'customer_name' => 'Dr. Hamza Khan',
                'customer_email' => 'hamza.khan@lahore.pk',
                'customer_phone' => '+92 300 8472910',
                'shipping_address' => 'Sector Y, Phase 5, DHA, Lahore',
                'city' => 'Lahore',
                'postal_code' => '54000',
                'order_notes' => 'Priority wax-sealed presentation box delivery requested.',
                'payment_method' => 'COD',
                'payment_status' => 'paid',
                'order_status' => 'completed',
                'subtotal' => 14850.00,
                'shipping_fee' => 0.00,
                'discount' => 0.00,
                'total' => 14850.00,
                'items' => [
                    ['name' => 'The Grand Weekender Leather Holdall', 'qty' => 1, 'price' => 14850.00, 'sku' => 'BZ-HAN-024', 'color' => 'Cognac Tan'],
                ],
                'created_at' => now()->subHours(4),
            ],
            [
                'order_number' => 'BZ-202610-0102',
                'customer_name' => 'Ayesha Tariq',
                'customer_email' => 'ayesha.tariq@islamabad.pk',
                'customer_phone' => '+92 321 5567890',
                'shipping_address' => 'Street 14, Sector F-7/2, Islamabad',
                'city' => 'Islamabad',
                'postal_code' => '44000',
                'order_notes' => 'Gift packaging with custom gold-foiled note.',
                'payment_method' => 'BANK_TRANSFER',
                'payment_status' => 'paid',
                'order_status' => 'completed',
                'subtotal' => 17800.00,
                'shipping_fee' => 0.00,
                'discount' => 0.00,
                'total' => 17800.00,
                'items' => [
                    ['name' => 'The Zunash Signature Satchel', 'qty' => 1, 'price' => 17800.00, 'sku' => 'BZ-HAN-002', 'color' => 'Bordeaux Burgundy'],
                ],
                'created_at' => now()->subDay(),
            ],
            [
                'order_number' => 'BZ-202610-0103',
                'customer_name' => 'Bilal Mansoor',
                'customer_email' => 'bilal.mansoor@karachi.pk',
                'customer_phone' => '+92 333 2244668',
                'shipping_address' => 'Block 4, Clifton, Karachi',
                'city' => 'Karachi',
                'postal_code' => '75600',
                'order_notes' => 'Double-compartment bifold wallet for PKR 5000 notes.',
                'payment_method' => 'CREDIT_CARD',
                'payment_status' => 'paid',
                'order_status' => 'completed',
                'subtotal' => 9900.00,
                'shipping_fee' => 0.00,
                'discount' => 0.00,
                'total' => 9900.00,
                'items' => [
                    ['name' => 'The Heritage Bifold Leather Wallet', 'qty' => 2, 'price' => 4950.00, 'sku' => 'BZ-WAL-003', 'color' => 'Havana Brown'],
                ],
                'created_at' => now()->subDays(2),
            ],
            [
                'order_number' => 'BZ-202610-0104',
                'customer_name' => 'Barrister Daniyal Qureshi',
                'customer_email' => 'daniyal.qureshi@chambers.pk',
                'customer_phone' => '+92 301 9876543',
                'shipping_address' => 'Mall Road, Cantt, Rawalpindi',
                'city' => 'Rawalpindi',
                'postal_code' => '46000',
                'order_notes' => 'Belt sized for 34-inch waist suit trousers.',
                'payment_method' => 'COD',
                'payment_status' => 'paid',
                'order_status' => 'completed',
                'subtotal' => 5950.00,
                'shipping_fee' => 0.00,
                'discount' => 0.00,
                'total' => 5950.00,
                'items' => [
                    ['name' => 'The Royal Reversible Calfskin Belt', 'qty' => 1, 'price' => 5950.00, 'sku' => 'BZ-BEL-001', 'color' => 'Espresso & Obsidian Black'],
                ],
                'created_at' => now()->subDays(3),
            ],
            [
                'order_number' => 'BZ-202610-0105',
                'customer_name' => 'Fatima Jahangir',
                'customer_email' => 'fatima.j@lahore-corp.pk',
                'customer_phone' => '+92 300 1238899',
                'shipping_address' => 'Ali Block, New Garden Town, Lahore',
                'city' => 'Lahore',
                'postal_code' => '54000',
                'order_notes' => 'Call before arrival on corporate mobile.',
                'payment_method' => 'BANK_TRANSFER',
                'payment_status' => 'paid',
                'order_status' => 'completed',
                'subtotal' => 18900.00,
                'shipping_fee' => 0.00,
                'discount' => 0.00,
                'total' => 18900.00,
                'items' => [
                    ['name' => 'The Empress Structured Leather Tote', 'qty' => 1, 'price' => 18900.00, 'sku' => 'BZ-HAN-005', 'color' => 'Cognac Tan'],
                ],
                'created_at' => now()->subDays(4),
            ],
            [
                'order_number' => 'BZ-202610-0106',
                'customer_name' => 'Capt. Usman Raza',
                'customer_email' => 'usman.raza@paf.pk',
                'customer_phone' => '+92 345 8899770',
                'shipping_address' => 'Saddar Road, Cantt, Peshawar',
                'city' => 'Peshawar',
                'postal_code' => '25000',
                'order_notes' => 'Verification call pending.',
                'payment_method' => 'COD',
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'subtotal' => 4950.00,
                'shipping_fee' => 0.00,
                'discount' => 0.00,
                'total' => 4950.00,
                'items' => [
                    ['name' => 'Hand-Burnished Classic Dress Belt', 'qty' => 1, 'price' => 4950.00, 'sku' => 'BZ-BEL-004', 'color' => 'Burnished Tan'],
                ],
                'created_at' => now()->subDays(5),
            ],
            [
                'order_number' => 'BZ-202610-0107',
                'customer_name' => 'Zainab Malik',
                'customer_email' => 'zainab.malik@fsd-textile.pk',
                'customer_phone' => '+92 300 7654321',
                'shipping_address' => 'Kohinoor City, Jaranwala Road, Faisalabad',
                'city' => 'Faisalabad',
                'postal_code' => '38000',
                'order_notes' => 'Dispatched via priority courier.',
                'payment_method' => 'BANK_TRANSFER',
                'payment_status' => 'paid',
                'order_status' => 'completed',
                'subtotal' => 12500.00,
                'shipping_fee' => 0.00,
                'discount' => 0.00,
                'total' => 12500.00,
                'items' => [
                    ['name' => 'The Regent Saddle Crossbody', 'qty' => 1, 'price' => 12500.00, 'sku' => 'BZ-SHO-007', 'color' => 'Saddle Tan'],
                ],
                'created_at' => now()->subDays(6),
            ],
            [
                'order_number' => 'BZ-202610-0108',
                'customer_name' => 'Saadullah Sheikh',
                'customer_email' => 'saad.sheikh@multan.pk',
                'customer_phone' => '+92 312 9090900',
                'shipping_address' => 'Bosan Road, Cantt, Multan',
                'city' => 'Multan',
                'postal_code' => '60000',
                'order_notes' => 'Packed in embossed magnetic presentation box.',
                'payment_method' => 'COD',
                'payment_status' => 'paid',
                'order_status' => 'completed',
                'subtotal' => 4200.00,
                'shipping_fee' => 0.00,
                'discount' => 0.00,
                'total' => 4200.00,
                'items' => [
                    ['name' => 'Minimalist Slim Cardholder', 'qty' => 2, 'price' => 2100.00, 'sku' => 'BZ-WAL-008', 'color' => 'Obsidian Black'],
                ],
                'created_at' => now()->subDays(8),
            ],
            [
                'order_number' => 'BZ-202610-0109',
                'customer_name' => 'Mian Tariq Mehmood',
                'customer_email' => 'tariq.mehmood@sialkot.pk',
                'customer_phone' => '+92 300 5544332',
                'shipping_address' => 'Paris Road, Model Town, Sialkot',
                'city' => 'Sialkot',
                'postal_code' => '51310',
                'order_notes' => 'Bespoke corporate heirloom gift.',
                'payment_method' => 'BANK_TRANSFER',
                'payment_status' => 'paid',
                'order_status' => 'completed',
                'subtotal' => 21300.00,
                'shipping_fee' => 0.00,
                'discount' => 0.00,
                'total' => 21300.00,
                'items' => [
                    ['name' => 'The Grand Weekender Leather Holdall', 'qty' => 1, 'price' => 14850.00, 'sku' => 'BZ-HAN-024', 'color' => 'Havana Brown'],
                    ['name' => 'Alligator-Grain Watch Collector Roll', 'qty' => 1, 'price' => 6450.00, 'sku' => 'BZ-ACC-025', 'color' => 'Espresso'],
                ],
                'created_at' => now()->subDays(10),
            ],
            [
                'order_number' => 'BZ-202610-0110',
                'customer_name' => 'Dr. Zohra Qazi',
                'customer_email' => 'zohra.qazi@quetta.pk',
                'customer_phone' => '+92 334 1122334',
                'shipping_address' => 'Serena Residency, Club Road, Quetta',
                'city' => 'Quetta',
                'postal_code' => '87300',
                'order_notes' => 'White-glove priority express courier.',
                'payment_method' => 'COD',
                'payment_status' => 'paid',
                'order_status' => 'completed',
                'subtotal' => 8450.00,
                'shipping_fee' => 0.00,
                'discount' => 0.00,
                'total' => 8450.00,
                'items' => [
                    ['name' => 'Alligator-Grain Watch Collector Roll', 'qty' => 1, 'price' => 6450.00, 'sku' => 'BZ-ACC-025', 'color' => 'Bordeaux Burgundy'],
                    ['name' => 'The Atelier Solid Brass Key Fob', 'qty' => 1, 'price' => 2000.00, 'sku' => 'BZ-ACC-006', 'color' => 'Antique Brass'],
                ],
                'created_at' => now()->subDays(12),
            ],
            [
                'order_number' => 'BZ-202610-0111',
                'customer_name' => 'Shehryar Afridi',
                'customer_email' => 'shehryar.a@enclave.pk',
                'customer_phone' => '+92 300 9998877',
                'shipping_address' => 'Sector G-5/2, Diplomatic Enclave, Islamabad',
                'city' => 'Islamabad',
                'postal_code' => '44000',
                'order_notes' => 'VIP personal concierge delivery.',
                'payment_method' => 'VIP_CONCIERGE',
                'payment_status' => 'paid',
                'order_status' => 'completed',
                'subtotal' => 32500.00,
                'shipping_fee' => 0.00,
                'discount' => 0.00,
                'total' => 32500.00,
                'items' => [
                    ['name' => 'Bespoke Monogrammed Heritage Desk Blotter', 'qty' => 2, 'price' => 8900.00, 'sku' => 'BZ-BES-026', 'color' => 'Deep Mahogany'],
                    ['name' => 'The Grand Weekender Leather Holdall', 'qty' => 1, 'price' => 14700.00, 'sku' => 'BZ-HAN-024', 'color' => 'Cognac Tan'],
                ],
                'created_at' => now()->subDays(15),
            ],
        ];

        foreach ($orders as $order) {
            Order::updateOrCreate(['order_number' => $order['order_number']], $order);
        }

        // 6. Concierge Inquiries (Empty or few read inquiries as shown in screenshot)
        Inquiry::updateOrCreate(
            ['email' => 'sarah.jenkins@consultant.co.uk'],
            [
                'name' => 'Sarah Jenkins',
                'phone' => '+44 7700 900123',
                'subject' => 'Bespoke Corporate Monogramming for 25 Satchels',
                'message' => 'Good day, We are seeking bespoke gold-foil debossed corporate gifting for our senior leadership retreat next month. Kindly provide lead time and leather swatch samples.',
                'status' => 'resolved',
                'is_read' => true,
                'created_at' => now()->subDays(3),
            ]
        );

        // 7. Verified Reviews
        $reviews = [
            [
                'author' => 'Dr. Hamza Khan',
                'city' => 'Lahore (DHA Phase 5)',
                'initials' => 'HK',
                'category' => 'belts',
                'product_name' => 'The Royal Reversible Calfskin Belt',
                'product_slug' => 'the-royal-reversible-calfskin-belt',
                'rating' => 5,
                'verified' => true,
                'title' => 'The swivel buckle mechanism is sheer mechanical perfection',
                'comment' => 'Without question the finest leather belt I have purchased in Pakistan. The swivel mechanism has a solid, authoritative click that transitions between obsidian black and rich espresso calfskin effortlessly.',
                'image' => '/images/products/prod-reversible-belt.jpg',
                'helpful' => 48,
                'status' => 'published',
            ],
            [
                'author' => 'Ayesha Tariq',
                'city' => 'Islamabad (F-7/2)',
                'initials' => 'AT',
                'category' => 'handbags',
                'product_name' => 'The Zunash Signature Satchel',
                'product_slug' => 'the-zunash-signature-satchel',
                'rating' => 5,
                'verified' => true,
                'title' => 'Rivals European luxury fashion houses in every detail',
                'comment' => 'I was initially hesitant to order fine leather online, but the doorstep Cash on Delivery made it risk-free. The packaging alone was regal—a magnetic rigid box with a linen dust pouch.',
                'image' => '/images/products/prod-signature-satchel.jpg',
                'helpful' => 39,
                'status' => 'published',
            ],
            [
                'author' => 'Bilal Mansoor',
                'city' => 'Karachi (Clifton Block 4)',
                'initials' => 'BM',
                'category' => 'wallets',
                'product_name' => 'The Heritage Bifold Leather Wallet',
                'product_slug' => 'the-heritage-bifold-leather-wallet',
                'rating' => 5,
                'verified' => true,
                'title' => 'Calibrated perfectly for PKR 5000 banknotes',
                'comment' => 'Most imported bifold wallets crush Pakistani currency notes or bulge awkwardly in tailored suit breast pockets. This wallet is sized with dual compartments for PKR 5000 notes and receipts.',
                'image' => '/images/products/prod-bifold-wallet.jpg',
                'helpful' => 52,
                'status' => 'published',
            ],
        ];

        foreach ($reviews as $rev) {
            Review::updateOrCreate(
                ['author' => $rev['author'], 'product_name' => $rev['product_name']],
                $rev
            );
        }

        // 7. Store Settings
        $settings = [
            'store_name' => 'BY ZUNASH ATELIER',
            'store_tagline' => 'Luxury Pakistani Leather Goods — Heirloom Craftsmanship',
            'currency_symbol' => 'Rs. ',
            'currency_code' => 'PKR',
            'contact_email' => 'concierge@byzunash.com',
            'contact_phone' => '+92 300 1234567',
            'warehouse_city' => 'Lahore',
            'tax_rate_percent' => '0',
            'free_shipping_threshold' => '3000',
        ];

        foreach ($settings as $k => $v) {
            StoreSetting::set($k, $v);
        }
    }
}
