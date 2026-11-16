<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class DemoTestingProductsSeeder extends Seeder
{
    public function run(): void
    {
        $beltsCat = Category::firstOrCreate(
            ['slug' => 'leather-belts'],
            ['name' => 'Leather Belts', 'tagline' => 'Full-grain vegetable-tanned handcrafted belts.']
        );

        $walletsCat = Category::firstOrCreate(
            ['slug' => 'wallets'],
            ['name' => 'Wallets', 'tagline' => 'Drum-dyed heirloom bifold, trifold, and RFID wallets.']
        );

        $accCat = Category::firstOrCreate(
            ['slug' => 'accessories'],
            ['name' => 'Accessories', 'tagline' => 'Handmade keycases, cardholders, and leather accents.']
        );

        // Base Addon Item (Smart Keycase)
        $keycase = Product::updateOrCreate(
            ['slug' => 'test-smart-keycase-brass'],
            [
                'name' => 'Smart Leather Keycase - Vintage Brass',
                'category_id' => $accCat->id,
                'category_slug' => 'accessories',
                'category_name' => 'Accessories',
                'price' => 1450,
                'original_price' => 1999,
                'sku' => 'TEST-KEYCASE-01',
                'badge' => 'Quick Addon',
                'short_description' => 'Precision laser-cut vegetable-tanned keycase with solid antique brass mechanism. Protects pockets from scratches.',
                'description' => '<p>Engineered for the organized gentleman. Holds 4 to 8 keys in a silent, scratch-free profile. Hand-burnished beeswax edges and durable bonded nylon thread.</p>',
                'image' => '/images/products/prod-key-fob.webp',
                'gallery' => ['/images/products/prod-key-fob.webp'],
                'colors' => [
                    ['name' => 'Pacific Blue', 'hex' => '#203A43'],
                    ['name' => 'Vintage Saddle', 'hex' => '#5C3A21'],
                    ['name' => 'Obsidian Black', 'hex' => '#1A1A1A'],
                ],
                'specifications' => [
                    'Leather' => 'Vegetable-Tanned Full-Grain Cowhide',
                    'Hardware' => 'Solid Antique Brass Swivel Post',
                    'Capacity' => '4–8 Standard Keys',
                    'Origin' => 'Handcrafted in Lahore, Pakistan',
                ],
                'availability' => 'in_stock',
                'in_stock' => true,
                'stock_quantity' => 50,
                'rating' => 5.0,
                'reviews_count' => 22,
                'allowed_payment_methods' => 'all',
                'has_engraving' => false,
                'has_addons' => false,
                'has_gift_set' => false,
            ]
        );

        // Product 1: Advance Payment Only (EasyPaisa / Bank Transfer / Raast)
        Product::updateOrCreate(
            ['slug' => 'test-imperial-wallet-advance-payment'],
            [
                'name' => 'Imperial Bifold Wallet (Advance Payment Only)',
                'category_id' => $walletsCat->id,
                'category_slug' => 'wallets',
                'category_name' => 'Wallets',
                'price' => 3850,
                'original_price' => 4950,
                'sku' => 'TEST-PREPAID-01',
                'badge' => 'Advance Payment Only',
                'short_description' => 'Bespoke full-grain bifold wallet. Exclusively crafted upon order confirmation — available only via Bank Transfer, Raast, or EasyPaisa/JazzCash.',
                'description' => '<p>Crafted from drum-dyed full-grain steer hide. Dual currency dividers sized for full-length PKR 5,000 notes without folding. Eight precision-cut card slots with concealed security compartments.</p><p><strong>Notice:</strong> This bespoke item requires advance payment via Meezan Bank, Raast, or EasyPaisa/JazzCash. Cash on Delivery is disabled for this creation.</p>',
                'image' => '/images/products/prod-bifold-wallet.webp',
                'gallery' => [
                    '/images/products/prod-bifold-wallet.webp',
                    '/images/products/prod-bifold-wallet-thumb.webp',
                ],
                'colors' => [
                    ['name' => 'Espresso Brown', 'hex' => '#3B2219'],
                    ['name' => 'Obsidian Black', 'hex' => '#1A1A1A'],
                    ['name' => 'Cognac Tan', 'hex' => '#8B5A2B'],
                ],
                'specifications' => [
                    'Leather' => '100% Full-Grain Drum-Dyed Hide',
                    'Slots' => '8 Card Pockets, 2 Hidden Slots, 2 Currency Separators',
                    'Payment Rule' => 'Prepaid Only (Bank Transfer / EasyPaisa / JazzCash)',
                    'Origin' => 'Handcrafted in Lahore, Pakistan',
                ],
                'availability' => 'in_stock',
                'in_stock' => true,
                'stock_quantity' => 25,
                'rating' => 4.9,
                'reviews_count' => 34,
                'allowed_payment_methods' => 'prepaid_only',
                'has_engraving' => true,
                'engraving_price' => 250,
                'engraving_placeholder' => 'e.g. M. NOUMAN / ZUNASH',
                'engraving_note' => 'Advance payment required. Personalised debossed items cannot be returned for change of mind.',
                'has_addons' => false,
                'has_gift_set' => false,
            ]
        );

        // Product 2: COD Available (Standard All Payment Methods)
        Product::updateOrCreate(
            ['slug' => 'test-royal-reversible-belt-cod'],
            [
                'name' => 'The Royal Reversible Belt (COD Available)',
                'category_id' => $beltsCat->id,
                'category_slug' => 'belts',
                'category_name' => 'Leather Belts',
                'price' => 4650,
                'original_price' => 5900,
                'sku' => 'TEST-COD-02',
                'badge' => 'Cash on Delivery',
                'short_description' => 'Two belts in one. Obsidian Black on one side and Cognac Brown on the other with a solid 360° antique brass swivel buckle. Nationwide Cash on Delivery.',
                'description' => '<p>Seamlessly transition between boardroom tailored suits and weekend denim with a single pull and twist of the solid brass swivel buckle. Open parcel doorstep inspection allowed prior to paying cash.</p>',
                'image' => '/images/products/prod-dress-belt.webp',
                'gallery' => [
                    '/images/products/prod-dress-belt.webp',
                    '/images/products/prod-reversible-belt-thumb.webp',
                ],
                'colors' => [
                    ['name' => 'Obsidian Black / Cognac Brown', 'hex' => '#1A1A1A'],
                    ['name' => 'Mocha / Espresso Brown', 'hex' => '#4A2F1B'],
                ],
                'specifications' => [
                    'Leather' => '100% Full-Grain Vegetable-Tanned Calfskin',
                    'Hardware' => 'Solid Antique Brass 360° Swivel Buckle',
                    'Width' => '35mm (1.38 in) — Universal Tailored Width',
                    'Sizes Available' => '32″, 34″, 36″, 38″, 40″, 42″',
                    'Delivery' => 'Nationwide Cash on Delivery (COD) + Open Box Inspection',
                    'Origin' => 'Handcrafted in Lahore, Pakistan',
                ],
                'availability' => 'in_stock',
                'in_stock' => true,
                'stock_quantity' => 40,
                'rating' => 5.0,
                'reviews_count' => 58,
                'allowed_payment_methods' => 'all',
                'is_free_shipping' => true,
                'has_engraving' => false,
                'has_addons' => false,
                'has_gift_set' => false,
            ]
        );

        // Product 3: Name Engraving / Personalisation
        $cardholder = Product::updateOrCreate(
            ['slug' => 'test-laser-engraved-rfid-cardholder'],
            [
                'name' => 'Laser-Debossed RFID Cardholder (Custom Name Engraving)',
                'category_id' => $accCat->id,
                'category_slug' => 'accessories',
                'category_name' => 'Accessories',
                'price' => 1950,
                'original_price' => 2750,
                'sku' => 'TEST-ENGRAVE-03',
                'badge' => 'Free Name Engraving',
                'short_description' => 'Precision RFID pop-up card ejector wrapped in full-grain cowhide. Complimentary laser-debossed monogramming of your name or initials.',
                'description' => '<p>One-touch card ejector triggers 5 credit or debit cards in an ergonomic graded cascade. RFID frequency blocking protects your bank cards against wireless skimming.</p><p><strong>Personalisation:</strong> Check the box above to add your custom name or monogram debossed permanently in gold foil or blind heat stamp.</p>',
                'image' => '/images/products/prod-cardholder.webp',
                'gallery' => ['/images/products/prod-cardholder.webp'],
                'colors' => [
                    ['name' => 'Pacific Navy Blue', 'hex' => '#1B2A4A'],
                    ['name' => 'Vintage Caramel', 'hex' => '#9E5B32'],
                    ['name' => 'Matte Charcoal', 'hex' => '#222222'],
                ],
                'specifications' => [
                    'Leather' => 'Full-Grain Vegetable-Tanned Cowhide',
                    'Mechanism' => 'Aviation-Grade RFID Aluminum Pop-up',
                    'Capacity' => '5 Mechanism Cards + 3 Exterior Slots + Cash',
                    'Custom Engraving' => 'Complimentary (Up to 14 Characters)',
                    'Origin' => 'Handcrafted in Lahore, Pakistan',
                ],
                'availability' => 'in_stock',
                'in_stock' => true,
                'stock_quantity' => 35,
                'rating' => 4.9,
                'reviews_count' => 41,
                'allowed_payment_methods' => 'all',
                'has_engraving' => true,
                'engraving_price' => 0.00,
                'engraving_placeholder' => 'e.g. M. NOUMAN / ZUNASH',
                'engraving_note' => 'Personalised engraved pieces are custom crafted exclusively for you and require advance payment (Bank Transfer / EasyPaisa).',
                'has_addons' => false,
                'has_gift_set' => false,
            ]
        );

        // Product 4: Cross-Sell Add-ons & Gift Set Bundle
        Product::updateOrCreate(
            ['slug' => 'test-artisan-weekender-bundle-addons'],
            [
                'name' => 'Executive Artisan Satchel (Add-ons & Gift Deal)',
                'category_id' => $accCat->id,
                'category_slug' => 'accessories',
                'category_name' => 'Accessories',
                'price' => 8900,
                'original_price' => 11500,
                'sku' => 'TEST-BUNDLE-04',
                'badge' => '15% Off Add-on Deal',
                'short_description' => 'Sculpted full-grain leather messenger satchel with solid brass buckles. Includes cross-sell add-on deals with 15% instant savings.',
                'description' => '<p>Handcrafted by master saddlers in Lahore. Accommodates a 14-inch laptop, notebooks, and travel essentials with ease. Water-resistant waxed canvas lining and reinforced gussets.</p>',
                'image' => '/images/products/prod-signature-satchel.webp',
                'gallery' => [
                    '/images/products/prod-signature-satchel.webp',
                    '/images/products/prod-key-fob.webp',
                ],
                'colors' => [
                    ['name' => 'Antique Cognac', 'hex' => '#7B4A23'],
                    ['name' => 'Espresso Walnut', 'hex' => '#3D2817'],
                ],
                'specifications' => [
                    'Leather' => 'Full-Grain Oil-Pullup Steer Hide',
                    'Dimensions' => '38cm × 28cm × 9cm',
                    'Capacity' => '14″ Laptop + Tablets & Documents',
                    'Add-on Offer' => 'Select matching Keycase or Cardholder for 15% Off',
                    'Origin' => 'Handcrafted in Lahore, Pakistan',
                ],
                'availability' => 'in_stock',
                'in_stock' => true,
                'stock_quantity' => 15,
                'rating' => 5.0,
                'reviews_count' => 29,
                'allowed_payment_methods' => 'all',
                'custom_shipping_charge' => 250,
                'has_engraving' => false,
                'has_addons' => true,
                'addon_discount_percent' => 15,
                'addon_product_ids' => [$keycase->id, $cardholder->id],
                'has_gift_set' => true,
                'gift_set_title' => "Upgrade to the Executive Connoisseur Box instead",
                'gift_set_subtitle' => 'Includes Satchel + Cardholder + Brass Keycase separately',
                'gift_set_price' => 10900,
                'gift_set_original_price' => 14500,
                'gift_set_image' => '/images/products/prod-cardholder.webp',
            ]
        );
    }
}
