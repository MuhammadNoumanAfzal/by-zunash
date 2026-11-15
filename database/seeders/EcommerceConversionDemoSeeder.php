<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Deal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EcommerceConversionDemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure Categories Exist
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

        // 2. Product 4: Key Fob & Keycase (Add-on item)
        $prod4 = Product::updateOrCreate(
            ['slug' => 'smart-keycase-pacific-blue'],
            [
                'name' => 'Smart Keycase - Pacific Blue & Vintage Brass',
                'category_id' => $accCat->id,
                'price' => 1450,
                'original_price' => 1999,
                'short_description' => 'Precision laser-cut vegetable tanned keycase with solid antique brass mechanism. Protects pockets and phone screens from key scratches.',
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
                    'Dimensions' => '85mm × 22mm × 18mm',
                    'Origin' => 'Handcrafted in Lahore, Pakistan',
                ],
                'availability' => 'in_stock',
                'in_stock' => true,
                'stock_quantity' => 45,
                'rating' => 4.9,
                'reviews_count' => 18,
                'has_engraving' => false,
                'has_addons' => false,
                'has_gift_set' => false,
            ]
        );

        // 3. Product 3: Leather Smart Wallet Pro (Add-on item)
        $prod3 = Product::updateOrCreate(
            ['slug' => 'leather-smart-wallet-pro'],
            [
                'name' => 'Leather Smart Wallet Pro - RFID Pop-up',
                'category_id' => $walletsCat->id,
                'price' => 2850,
                'original_price' => 3600,
                'short_description' => 'Instant tactile card ejector wrapped in full-grain cowhide. RFID shielding protects credit cards from wireless electronic skimming.',
                'description' => '<p>A futuristic minimalist marvel wrapped in heirloom leathercraft. One click deploys 5 cards in a graded fan for rapid access. Dedicated cash wrap slot fits Pakistani Rupee currency notes.</p>',
                'image' => '/images/products/prod-cardholder.webp',
                'gallery' => ['/images/products/prod-cardholder.webp'],
                'colors' => [
                    ['name' => 'Classic Black', 'hex' => '#1A1A1A'],
                    ['name' => 'Dark Walnut', 'hex' => '#3D2817'],
                    ['name' => 'Cognac Tan', 'hex' => '#7B4A23'],
                ],
                'specifications' => [
                    'Leather' => '100% Full-Grain Drum-Dyed Hide',
                    'Mechanism' => 'Aviation-Grade RFID Aluminum Pop-up',
                    'Capacity' => '5 Cards in Mechanism + 3 Exterior Slots + Cash',
                    'Dimensions' => '100mm × 65mm × 15mm',
                    'Origin' => 'Handcrafted in Lahore, Pakistan',
                ],
                'availability' => 'in_stock',
                'in_stock' => true,
                'stock_quantity' => 30,
                'rating' => 5.0,
                'reviews_count' => 24,
                'has_engraving' => true,
                'engraving_price' => 250,
                'engraving_placeholder' => 'e.g. ZUNASH / M.A',
                'engraving_note' => 'Personalised items require advance payment and cannot be returned for change of mind.',
                'has_addons' => true,
                'addon_discount_percent' => 15,
                'addon_product_ids' => [$prod4->id],
                'has_gift_set' => false,
            ]
        );

        // 4. Product 2: The Heritage Bifold Leather Wallet
        $prod2 = Product::find(2);
        if (!$prod2) {
            $prod2 = new Product();
        }
        $prod2->fill([
            'name' => 'The Heritage Bifold Leather Wallet',
            'slug' => 'heritage-bifold-leather-wallet',
            'category_id' => $walletsCat->id,
            'price' => 3999,
            'original_price' => 5200,
            'short_description' => 'Classic 8-card vegetable tanned bifold with dual currency separators. Drum-dyed for a rich patina that darkens gracefully over decades.',
            'description' => '<p>The quintessence of Pakistani leathercraft. Cut from the finest prime steer hides, saddle stitched by master artisans with waxed braided cord. Designed to hold full-sized PKR 5,000 currency notes without creasing.</p>',
            'image' => '/images/products/prod-bifold-wallet.webp',
            'gallery' => [
                '/images/products/prod-bifold-wallet.webp',
                '/images/products/prod-bifold-wallet-thumb.webp',
            ],
            'colors' => [
                ['name' => 'Dark Brown', 'hex' => '#3B2219'],
                ['name' => 'Classic Black', 'hex' => '#1A1A1A'],
                ['name' => 'Tan Caramel', 'hex' => '#8B5A2B'],
            ],
            'specifications' => [
                'Leather' => 'Full-Grain Drum-Dyed Vegetable-Tanned Hide',
                'Thread' => 'Hand-Waxed Bonded Nylon Saddlery Thread',
                'Slots' => '8 Card Pockets, 2 Hidden Compartments, 2 Cash Dividers',
                'Dimensions' => '115mm × 90mm × 12mm (Closed)',
                'Origin' => 'Handcrafted in Lahore, Pakistan',
            ],
            'availability' => 'in_stock',
            'in_stock' => true,
            'stock_quantity' => 25,
            'rating' => 4.9,
            'reviews_count' => 38,
            'has_engraving' => true,
            'engraving_price' => 350,
            'engraving_placeholder' => 'e.g. ZUNASH / INITIALS',
            'engraving_note' => 'Advance payment only. Personalised, so not returnable for change of mind.',
            'has_addons' => true,
            'addon_discount_percent' => 15,
            'addon_product_ids' => [$prod3->id, $prod4->id],
            'has_gift_set' => true,
            'gift_set_title' => "Get the Gentleman's Set instead",
            'gift_set_subtitle' => 'Pop-up cardholder + Ombré separately',
            'gift_set_price' => 3999,
            'gift_set_original_price' => 4699,
            'gift_set_image' => '/images/products/prod-bifold-wallet.webp',
        ]);
        $prod2->save();

        // 5. Product 1: The Royal Reversible Calfskin Belt (Hero Conversion Showcase)
        $prod1 = Product::find(1);
        if (!$prod1) {
            $prod1 = new Product();
        }
        $prod1->fill([
            'name' => 'The Royal Reversible Calfskin Belt',
            'slug' => 'the-royal-reversible-calfskin-belt',
            'category_id' => $beltsCat->id,
            'price' => 4950,
            'original_price' => 6500,
            'short_description' => 'Two belts in one. Reversible drum-dyed full-grain leather featuring Obsidian Black on one side and Cognac Brown on the other with a solid 360° antique brass swivel buckle.',
            'description' => '<p>Crafted for the modern professional. Seamlessly transition from boardroom charcoal suiting to weekend chino tailoring with a single pull-and-turn of the solid brass swivel mechanism. Precision beveled and hand-burnished with natural carnauba beeswax for lifelong durability.</p>',
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
                'Lining' => 'Dual Full-Grain Hide Laminated & Saddle-Stitched',
                'Origin' => 'Handcrafted in Lahore, Pakistan',
                'Packaging' => 'Rigid Foil-Embossed Presentation Box Included',
            ],
            'availability' => 'in_stock',
            'in_stock' => true,
            'stock_quantity' => 40,
            'rating' => 5.0,
            'reviews_count' => 64,
            'has_engraving' => true,
            'engraving_price' => 0, // Complimentary debossing!
            'engraving_placeholder' => 'e.g. ZUNASH / M. ALI',
            'engraving_note' => 'Advance payment only. Personalised, so not returnable for change of mind.',
            'has_addons' => true,
            'addon_discount_percent' => 15,
            'addon_product_ids' => [$prod2->id, $prod3->id, $prod4->id],
            'has_gift_set' => true,
            'gift_set_title' => "Get the Gentleman's Executive Box instead",
            'gift_set_subtitle' => 'Reversible Belt + RFID Cardholder + Keycase separately',
            'gift_set_price' => 6999,
            'gift_set_original_price' => 8450,
            'gift_set_image' => '/images/products/prod-reversible-belt-thumb.webp',
        ]);
        $prod1->save();

        // 6. Update Prod 2 & Prod 3 to point to correct addon IDs
        $prod2->addon_product_ids = [$prod3->id, $prod4->id];
        $prod2->save();

        $prod3->addon_product_ids = [$prod4->id, $prod1->id];
        $prod3->save();

        // 7. Seed WhatsApp Reviews
        Review::where('is_whatsapp', true)->delete();

        Review::create([
            'author' => 'Dr. Usman Tariq',
            'city' => 'Lahore (DHA Ph 6)',
            'initials' => 'UT',
            'category' => 'belts',
            'product_name' => $prod1->name,
            'product_slug' => $prod1->slug,
            'rating' => 5,
            'title' => 'Personalised Name Engraving is exceptional!',
            'comment' => 'Assalam o alaikum brother! Received my personalised belt and wallet today via TCS. Truly impressed by the full-grain leather smell and the gold debossing of my name is crisp! Doorstep inspection allowed by the courier made it completely risk-free.',
            'image' => '/images/products/prod-reversible-belt-thumb.webp',
            'helpful' => 31,
            'verified' => true,
            'is_whatsapp' => true,
            'status' => 'approved',
        ]);

        Review::create([
            'author' => 'Capt. Daniyal Khan',
            'city' => 'Islamabad (F-7)',
            'initials' => 'DK',
            'category' => 'wallets',
            'product_name' => $prod2->name,
            'product_slug' => $prod2->slug,
            'rating' => 5,
            'title' => 'Gentleman\'s Gift Set for my brother',
            'comment' => 'Ordered the Gentleman\'s Set gift-boxed. Packaging is rigid, luxurious gold stamped box with satin lining. Bhai loved the craftsmanship. Fast dispatch in 24 hours. Recommended 100%!',
            'image' => '/images/products/prod-bifold-wallet.webp',
            'helpful' => 19,
            'verified' => true,
            'is_whatsapp' => true,
            'status' => 'approved',
        ]);

        Review::create([
            'author' => 'Hamza Malik',
            'city' => 'Karachi (Clifton)',
            'initials' => 'HM',
            'category' => 'wallets',
            'product_name' => $prod3->name,
            'product_slug' => $prod3->slug,
            'rating' => 5,
            'title' => 'Top grain leather and prompt COD delivery',
            'comment' => 'Bhai parcel received through Trax courier. Checked open parcel before paying cash. Pure hide leather, heavy brass buckle. Worth every rupee! Claimed the 15% off key fob add-on too.',
            'image' => '/images/products/prod-key-fob.webp',
            'helpful' => 24,
            'verified' => true,
            'is_whatsapp' => true,
            'status' => 'approved',
        ]);
    }
}
