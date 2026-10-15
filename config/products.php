<?php

return [
    'categories' => [
        'belts' => [
            'slug' => 'belts',
            'name' => 'Leather Belts',
            'tagline' => 'Hand-burnished, full-grain belts tailored for dress and casual distinction.',
            'image' => 'https://images.unsplash.com/photo-1624222247344-550fb60583dc?auto=format&fit=crop&w=800&q=80',
            'count' => 4,
        ],
        'wallets' => [
            'slug' => 'wallets',
            'name' => 'Wallets & Cardholders',
            'tagline' => 'Slim, enduring bifold and front-pocket wallets cut from top-grade hides.',
            'image' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=800&q=80',
            'count' => 4,
        ],
        'handbags' => [
            'slug' => 'handbags',
            'name' => 'Handbags',
            'tagline' => 'Sculpted silhouettes, rolled top handles, and bespoke gold-finish accents.',
            'image' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80',
            'count' => 4,
        ],
        'shoulder-bags' => [
            'slug' => 'shoulder-bags',
            'name' => 'Shoulder Bags',
            'tagline' => 'Timeless crossbodies and saddle bags designed for effortless mobility.',
            'image' => 'https://images.unsplash.com/photo-1591561954557-26941169b49e?auto=format&fit=crop&w=800&q=80',
            'count' => 4,
        ],
        'accessories' => [
            'slug' => 'accessories',
            'name' => 'Everyday Accessories',
            'tagline' => 'Passport folios, solid brass key fobs, and heirloom desk accents.',
            'image' => 'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?auto=format&fit=crop&w=800&q=80',
            'count' => 4,
        ],
    ],

    'items' => [
        // BELTS
        [
            'id' => 1,
            'slug' => 'the-royal-reversible-calfskin-belt',
            'name' => 'The Royal Reversible Calfskin Belt',
            'category' => 'belts',
            'category_name' => 'Leather Belts',
            'price' => 4950,
            'original_price' => 5950,
            'badge' => 'Bestseller',
            'is_bestseller' => true,
            'is_new' => false,
            'rating' => 4.9,
            'reviews_count' => 42,
            'short_description' => 'Two refined looks in one. Premium supple calfskin in espresso brown on one face and obsidian black on the reverse, secured by a solid brushed antique brass swivel buckle.',
            'description' => 'Handcrafted for the modern professional in Pakistan, The Royal Reversible Belt offers unmatched versatility. Made from drum-dyed full-grain calfskin leather, it delivers subtle sheen, supple bend, and impeccable durability. The rotatable solid brass buckle transitions effortlessly between black suit trousers and warm earth-toned chinos.',
            'image' => 'https://images.unsplash.com/photo-1624222247344-550fb60583dc?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1624222247344-550fb60583dc?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1585856476122-87db3bb1e185?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                'Reversible 360-degree swivel buckle in brushed antique brass',
                '100% full-grain calfskin with beveled, wax-burnished edges',
                'Width: 34mm (1.35 in) — fits formal and casual belt loops',
                'Reinforced double-core structure to prevent creasing or stretching',
                'Presented in an embossed By Zunash magnetic presentation box'
            ],
            'specifications' => [
                'Material' => '100% Full-Grain Vegetable Tanned Calfskin',
                'Hardware' => 'Solid Antique Brass Finish',
                'Width' => '34 mm (1.35 inches)',
                'Available Sizes' => '30, 32, 34, 36, 38, 40, 42 inches',
                'Care' => 'Wipe with soft cotton cloth; treat with neutral leather balm periodically'
            ],
            'colors' => [
                ['name' => 'Espresso & Obsidian Black', 'hex' => '#24160F', 'stock' => true],
                ['name' => 'Cognac Tan & Coffee', 'hex' => '#A87548', 'stock' => true]
            ]
        ],
        [
            'id' => 2,
            'slug' => 'hand-burnished-classic-dress-belt',
            'name' => 'Hand-Burnished Classic Dress Belt',
            'category' => 'belts',
            'category_name' => 'Leather Belts',
            'price' => 4450,
            'original_price' => null,
            'badge' => 'New Arrival',
            'is_bestseller' => false,
            'is_new' => true,
            'rating' => 4.8,
            'reviews_count' => 19,
            'short_description' => 'A timeless 32mm dress belt featuring feather-edge craftsmanship and rich hand-applied patina in cognac tan.',
            'description' => 'Precision cut and hand-polished at every step, this dress belt is an essential companion for bespoke tailoring. It boasts a subtly domed profile, tonal perimeter micro-stitching, and a sleek brushed nickel buckle.',
            'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1624222247344-550fb60583dc?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                'Premium vegetable tanned top-grain cowhide',
                'Domed padded profile with tone-on-tone edge stitching',
                'Brushed antique gold buckle with single leather keeper loop',
                'Hand-stained and sealed edges for maximum moisture resistance'
            ],
            'specifications' => [
                'Material' => 'Vegetable Tanned Pakistani Cowhide',
                'Hardware' => 'Brushed Antique Gold',
                'Width' => '32 mm',
                'Care' => 'Store hanging or loosely coiled away from direct sunlight'
            ],
            'colors' => [
                ['name' => 'Warm Tan', 'hex' => '#A87548', 'stock' => true],
                ['name' => 'Deep Espresso', 'hex' => '#24160F', 'stock' => true]
            ]
        ],
        [
            'id' => 3,
            'slug' => 'saddle-stitched-artisan-casual-belt',
            'name' => 'Saddle-Stitched Artisan Casual Belt',
            'category' => 'belts',
            'category_name' => 'Leather Belts',
            'price' => 3950,
            'original_price' => null,
            'badge' => null,
            'is_bestseller' => false,
            'is_new' => false,
            'rating' => 4.7,
            'reviews_count' => 14,
            'short_description' => 'Heavyweight pull-up leather crafted with thick contrast ivory thread for rugged, timeless denim wear.',
            'description' => 'Built from heavy 9-10 oz full-grain steer hide that develops a distinctive personal patina over years of wear. Highlights bold contrast saddle stitching and a heavyweight roller buckle.',
            'image' => 'https://images.unsplash.com/photo-1585856476122-87db3bb1e185?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1585856476122-87db3bb1e185?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                'Heavy 9 oz oil-tanned pull-up cowhide',
                'Durable Japanese waxed polyester saddle thread',
                'Antiqued solid steel roller buckle with screw rivets',
                'Width: 38mm (1.5 in) ideal for denim and chinos'
            ],
            'specifications' => [
                'Material' => '9-10 oz Heavy Pull-Up Cowhide',
                'Hardware' => 'Antiqued Steel Roller Buckle',
                'Width' => '38 mm',
                'Care' => 'Condition with natural leather wax once every six months'
            ],
            'colors' => [
                ['name' => 'Rich Chocolate', 'hex' => '#4A2C20', 'stock' => true]
            ]
        ],
        [
            'id' => 4,
            'slug' => 'braided-heritage-leather-belt',
            'name' => 'Braided Heritage Leather Belt',
            'category' => 'belts',
            'category_name' => 'Leather Belts',
            'price' => 5200,
            'original_price' => 5800,
            'badge' => 'Limited Edition',
            'is_bestseller' => false,
            'is_new' => false,
            'rating' => 4.9,
            'reviews_count' => 26,
            'short_description' => 'Intricately hand-plaited leather strips offering hole-free micro-adjustability and flexible comfort.',
            'description' => 'Each belt requires over four hours of intricate hand-plaiting by master leather artisans. The interlocking weave provides infinite adjustability without standard belt holes, ensuring a custom fit through every season.',
            'image' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                'Hand-plaited 8-strand supple bridle leather',
                'Hole-free prong insertion anywhere through the weave',
                'Hand-stitched leather tab and brass buckle end',
                'Elastic recovery and breathable weave'
            ],
            'specifications' => [
                'Material' => 'Supple Bridle Calfskin',
                'Hardware' => 'Polished Champagne Gold Buckle',
                'Width' => '35 mm',
                'Care' => 'Spot clean with mild damp cloth'
            ],
            'colors' => [
                ['name' => 'Dark Espresso', 'hex' => '#24160F', 'stock' => true],
                ['name' => 'Tan Gold', 'hex' => '#A87548', 'stock' => true]
            ]
        ],

        // WALLETS
        [
            'id' => 5,
            'slug' => 'the-heritage-bifold-leather-wallet',
            'name' => 'The Heritage Bifold Leather Wallet',
            'category' => 'wallets',
            'category_name' => 'Wallets & Cardholders',
            'price' => 3850,
            'original_price' => 4600,
            'badge' => 'Bestseller',
            'is_bestseller' => true,
            'is_new' => false,
            'rating' => 4.9,
            'reviews_count' => 64,
            'short_description' => 'Classic 8-card bifold featuring full-grain vegetable-tanned leather, dual currency dividers sized for PKR banknotes, and RFID lining.',
            'description' => 'The cornerstone of our leather goods collection. Meticulously designed for Pakistani currency dimensions with dual bill compartments to separate PKR banknotes from receipts. Lined with an ultra-thin RFID blocking fabric to safeguard your payment cards.',
            'image' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1563903530908-afdd155d057a?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                '8 precision die-cut card slots with turned edges',
                '2 hidden receipt/slip pockets under card banks',
                'Full-length dual cash sleeves calibrated for PKR 5000 & smaller notes',
                'Integrated German-certified RFID protective shield',
                'Debossed By Zunash gold foil monogram on interior corner'
            ],
            'specifications' => [
                'Material' => '100% Full-Grain Vegetable-Tanned Cowhide',
                'Lining' => 'Herringbone Cotton Twill & RFID Shielding Mesh',
                'Dimensions' => '11.2 cm x 9.0 cm x 1.4 cm (Closed)',
                'Weight' => '78 grams'
            ],
            'colors' => [
                ['name' => 'Espresso Brown', 'hex' => '#24160F', 'stock' => true],
                ['name' => 'Warm Tan', 'hex' => '#A87548', 'stock' => true]
            ]
        ],
        [
            'id' => 6,
            'slug' => 'minimalist-slim-cardholder',
            'name' => 'Minimalist Slim Cardholder',
            'category' => 'wallets',
            'category_name' => 'Wallets & Cardholders',
            'price' => 2450,
            'original_price' => null,
            'badge' => 'New Arrival',
            'is_bestseller' => false,
            'is_new' => true,
            'rating' => 4.8,
            'reviews_count' => 31,
            'short_description' => 'Front-pocket essential holding up to 6 cards plus folded cash in a central slip compartment.',
            'description' => 'Designed for those who travel light. Slim enough to slide undetected into suit breast pockets or front trouser pockets while keeping your essential CNIC, credit cards, and folded currency organized.',
            'image' => 'https://images.unsplash.com/photo-1563903530908-afdd155d057a?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1563903530908-afdd155d057a?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                '4 exterior card slots (2 per side) for instant access',
                'Central slip pocket for folded banknotes or extra cards',
                'Ultra-thin 4mm profile when empty',
                'Reinforced top stress stitching prevents stretching'
            ],
            'specifications' => [
                'Material' => 'Full-Grain Calfskin Leather',
                'Dimensions' => '10.0 cm x 7.4 cm x 0.4 cm',
                'Weight' => '28 grams'
            ],
            'colors' => [
                ['name' => 'Espresso Dark', 'hex' => '#24160F', 'stock' => true],
                ['name' => 'Cognac Tan', 'hex' => '#A87548', 'stock' => true]
            ]
        ],
        [
            'id' => 7,
            'slug' => 'executive-zip-around-travel-wallet',
            'name' => 'Executive Zip-Around Travel Wallet',
            'category' => 'wallets',
            'category_name' => 'Wallets & Cardholders',
            'price' => 6250,
            'original_price' => 7200,
            'badge' => null,
            'is_bestseller' => false,
            'is_new' => false,
            'rating' => 4.9,
            'reviews_count' => 22,
            'short_description' => 'All-in-one document and travel folio with smooth Japanese YKK antique brass perimeter zipper.',
            'description' => 'Carries your passport, international currency, boarding passes, 12 cards, and smartphone with seamless security. The smooth Japanese zip protects all contents from accidental slips while in transit.',
            'image' => 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                '12 dedicated card slots plus internal zippered coin pocket',
                'Dedicated passport slot and boarding pass sleeve',
                'YKK antique brass perimeter zipper with leather pull',
                'Full RFID protection throughout outer shells'
            ],
            'specifications' => [
                'Material' => 'Milled Grain Cowhide Leather',
                'Hardware' => 'Heavy Brass Zipper',
                'Dimensions' => '20.5 cm x 11.5 cm x 2.2 cm'
            ],
            'colors' => [
                ['name' => 'Rich Chocolate', 'hex' => '#4A2C20', 'stock' => true]
            ]
        ],
        [
            'id' => 8,
            'slug' => 'the-sovereign-trifold-pocket-wallet',
            'name' => 'The Sovereign Trifold Pocket Wallet',
            'category' => 'wallets',
            'category_name' => 'Wallets & Cardholders',
            'price' => 4200,
            'original_price' => null,
            'badge' => null,
            'is_bestseller' => false,
            'is_new' => false,
            'rating' => 4.7,
            'reviews_count' => 17,
            'short_description' => 'High-capacity trifold design featuring a clear ID window and 9 card compartments.',
            'description' => 'A structured trifold offering maximum card capacity while maintaining a tailored silhouette. Features a clear thumb-slide window for your national ID / driving license and dual cash slots.',
            'image' => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                '9 card slots and clear ID window',
                'Deep currency compartment accommodating international bills',
                'Hand-painted edges with triple seal coat'
            ],
            'specifications' => [
                'Material' => 'Vegetable Tanned Leather',
                'Dimensions' => '10.5 cm x 8.5 cm x 1.8 cm'
            ],
            'colors' => [
                ['name' => 'Deep Espresso', 'hex' => '#24160F', 'stock' => true]
            ]
        ],

        // HANDBAGS
        [
            'id' => 9,
            'slug' => 'the-zunash-signature-satchel',
            'name' => 'The Zunash Signature Satchel',
            'category' => 'handbags',
            'category_name' => 'Handbags',
            'price' => 14950,
            'original_price' => 17500,
            'badge' => 'Bestseller',
            'is_bestseller' => true,
            'is_new' => false,
            'rating' => 5.0,
            'reviews_count' => 58,
            'short_description' => 'Our flagship silhouette. Hand-sculpted architectural curves, rolled handles, and 24k gold-toned hardware accents.',
            'description' => 'The quintessential statement handbag crafted for refined gatherings and daily grandeur. Constructed from structured, scratch-resistant pebble leather with reinforced base studs, custom monogram lock, and an adjustable shoulder strap for hand or shoulder styling.',
            'image' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80',
                'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                'Dual hand-rolled leather carrying handles (12cm drop)',
                'Detachable and adjustable leather shoulder strap (48-58cm drop)',
                'Secure top zip closure with custom engraved By Zunash padlock',
                'Internal zippered privacy pocket plus two slip phone pouches',
                '5 protective bottom brass feet'
            ],
            'specifications' => [
                'Material' => 'Fine Grain Italian Pebble Cowhide',
                'Lining' => 'Ivory Micro-Suede Fabric',
                'Hardware' => '24k Antique Gold Finish',
                'Dimensions' => '31 cm (W) x 23 cm (H) x 13 cm (D)',
                'Weight' => '820 grams'
            ],
            'colors' => [
                ['name' => 'Rich Tan & Gold', 'hex' => '#A87548', 'stock' => true],
                ['name' => 'Midnight Espresso', 'hex' => '#24160F', 'stock' => true]
            ]
        ],
        [
            'id' => 10,
            'slug' => 'the-empress-structured-leather-tote',
            'name' => 'The Empress Structured Leather Tote',
            'category' => 'handbags',
            'category_name' => 'Handbags',
            'price' => 16800,
            'original_price' => null,
            'badge' => 'New Arrival',
            'is_bestseller' => false,
            'is_new' => true,
            'rating' => 4.9,
            'reviews_count' => 24,
            'short_description' => 'Generously proportioned luxury carryall fitting a 14\" laptop, planner, and vanity pouch with seamless grace.',
            'description' => 'Engineered for executive women who demand both aesthetic poise and effortless utility. The structured silhouette never sags, standing upright on solid brass studs while housing a padded laptop compartment and organized inner dividers.',
            'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                'Dedicated cushioned sleeve accommodating up to 14-inch laptops',
                'Reinforced flat shoulder straps with 26cm drop for comfortable armhole fit',
                'Magnetic top snap closure with internal secondary zip pocket',
                'Key leash with solid brass trigger snap hook'
            ],
            'specifications' => [
                'Material' => 'Full-Grain Structured Calfskin',
                'Dimensions' => '38 cm (Top W) x 29 cm (H) x 14 cm (D)',
                'Hardware' => 'Champagne Gold Plated'
            ],
            'colors' => [
                ['name' => 'Espresso Brown', 'hex' => '#24160F', 'stock' => true],
                ['name' => 'Cognac Tan', 'hex' => '#A87548', 'stock' => true]
            ]
        ],
        [
            'id' => 11,
            'slug' => 'palermo-suede-trim-leather-handbag',
            'name' => 'Palermo Suede-Trim Leather Handbag',
            'category' => 'handbags',
            'category_name' => 'Handbags',
            'price' => 18500,
            'original_price' => 21000,
            'badge' => 'Limited Edition',
            'is_bestseller' => false,
            'is_new' => false,
            'rating' => 4.8,
            'reviews_count' => 18,
            'short_description' => 'Rich dual-texture interplay featuring supple chocolate calfskin complemented by velvety camel suede side gussets.',
            'description' => 'An artisanal tribute to textural contrast. Featuring hand-turned seams, expandable suede gussets for adaptable volume, and signature polished lock closures.',
            'image' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                'Side gussets in genuine calf suede with cinch straps',
                'Dual top handles and detachable shoulder strap',
                'Gold foil brand imprint and serial certification tag'
            ],
            'specifications' => [
                'Material' => 'Full-Grain Calf Leather & Genuine Calf Suede',
                'Dimensions' => '33 cm x 24 cm x 15 cm'
            ],
            'colors' => [
                ['name' => 'Chocolate & Suede Camel', 'hex' => '#4A2C20', 'stock' => true]
            ]
        ],
        [
            'id' => 12,
            'slug' => 'mini-aurelia-box-handbag',
            'name' => 'Mini Aurelia Box Handbag',
            'category' => 'handbags',
            'category_name' => 'Handbags',
            'price' => 11900,
            'original_price' => null,
            'badge' => null,
            'is_bestseller' => false,
            'is_new' => false,
            'rating' => 4.9,
            'reviews_count' => 32,
            'short_description' => 'Architectural evening box handbag with jewel-finish gold clasp and vanity mirror.',
            'description' => 'Structured, compact, and unapologetically glamorous. Designed for wedding galas, intimate dinners, and evening celebrations.',
            'image' => 'https://images.unsplash.com/photo-1566150905458-1bf1fc113f0d?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1566150905458-1bf1fc113f0d?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                'Rigid wooden frame core wrapped in glove calfskin',
                'Jewel-cut solid push-lock clasp in antique gold',
                'Delicate leather-woven gold chain strap'
            ],
            'specifications' => [
                'Material' => 'Smooth Glove Calfskin',
                'Dimensions' => '19 cm x 13 cm x 7 cm'
            ],
            'colors' => [
                ['name' => 'Obsidian Espresso', 'hex' => '#24160F', 'stock' => true]
            ]
        ],

        // SHOULDER BAGS
        [
            'id' => 13,
            'slug' => 'the-boulevard-flap-shoulder-bag',
            'name' => 'The Boulevard Flap Shoulder Bag',
            'category' => 'shoulder-bags',
            'category_name' => 'Shoulder Bags',
            'price' => 12500,
            'original_price' => null,
            'badge' => 'Bestseller',
            'is_bestseller' => true,
            'is_new' => false,
            'rating' => 4.9,
            'reviews_count' => 47,
            'short_description' => 'Curated flap silhouette with subtle antique gold lock, adjustable strap, and dual interior compartments.',
            'description' => 'Clean lines meet timeless ease. The Boulevard is crafted to hang comfortably on the shoulder or across the body, offering fluid motion and rapid magnetic access.',
            'image' => 'https://images.unsplash.com/photo-1591561954557-26941169b49e?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1591561954557-26941169b49e?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                'Magnetic front flap with decorative antique gold buckle',
                'Wide leather shoulder strap with 7 adjustable notches',
                'Rear external slip pocket for phone access'
            ],
            'specifications' => [
                'Material' => 'Semi-Vegetable Tanned Cowhide',
                'Dimensions' => '25 cm x 18 cm x 8 cm'
            ],
            'colors' => [
                ['name' => 'Espresso', 'hex' => '#24160F', 'stock' => true],
                ['name' => 'Tan', 'hex' => '#A87548', 'stock' => true]
            ]
        ],
        [
            'id' => 14,
            'slug' => 'artisan-crossbody-saddle-bag',
            'name' => 'Artisan Crossbody Saddle Bag',
            'category' => 'shoulder-bags',
            'category_name' => 'Shoulder Bags',
            'price' => 10800,
            'original_price' => 12800,
            'badge' => 'New Arrival',
            'is_bestseller' => false,
            'is_new' => true,
            'rating' => 4.8,
            'reviews_count' => 29,
            'short_description' => 'Equestrian-inspired curved saddle bag featuring hand-stitched detailing and antique gold O-ring.',
            'description' => 'Embodying heritage leather-crafting traditions, the Saddle Bag showcases curved base paneling, waxed thread accents, and an iconic brass loop.',
            'image' => 'https://images.unsplash.com/photo-1575032617751-6ddec2089882?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1575032617751-6ddec2089882?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                'Equestrian contour silhouette',
                'Antique brass hardware with engraved monogram charm',
                'Internal phone pocket and card slot'
            ],
            'specifications' => [
                'Material' => 'Full-Grain Oil Pull-Up Leather',
                'Dimensions' => '22 cm x 19 cm x 7 cm'
            ],
            'colors' => [
                ['name' => 'Cognac Tan', 'hex' => '#A87548', 'stock' => true]
            ]
        ],
        [
            'id' => 15,
            'slug' => 'the-riviera-crescent-bag',
            'name' => 'The Riviera Crescent Bag',
            'category' => 'shoulder-bags',
            'category_name' => 'Shoulder Bags',
            'price' => 13400,
            'original_price' => null,
            'badge' => null,
            'is_bestseller' => false,
            'is_new' => false,
            'rating' => 4.9,
            'reviews_count' => 15,
            'short_description' => 'Ergonomic crescent hobo bag that nestles smoothly under the arm in ultra-supple milled hide.',
            'description' => 'The crescent shape conforms naturally to the body, offering a sleek contemporary profile without compromising interior volume.',
            'image' => 'https://images.unsplash.com/photo-1594223274512-ad4803739b7c?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1594223274512-ad4803739b7c?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                'Sculptural crescent geometry',
                'Top zipper closure with elongated pull tab',
                'Integrated wide leather shoulder strap'
            ],
            'specifications' => [
                'Material' => 'Supple Milled Nappa Leather',
                'Dimensions' => '28 cm x 17 cm x 9 cm'
            ],
            'colors' => [
                ['name' => 'Espresso Black', 'hex' => '#24160F', 'stock' => true]
            ]
        ],
        [
            'id' => 16,
            'slug' => 'urban-messenger-flap-bag',
            'name' => 'Urban Messenger Flap Bag',
            'category' => 'shoulder-bags',
            'category_name' => 'Shoulder Bags',
            'price' => 15200,
            'original_price' => 17000,
            'badge' => null,
            'is_bestseller' => false,
            'is_new' => false,
            'rating' => 4.8,
            'reviews_count' => 21,
            'short_description' => 'Versatile everyday messenger with dual front slip pockets, laptop sleeve, and webbing-reinforced leather strap.',
            'description' => 'Built for daily journeys through Karachi, Lahore, and Islamabad. Rugged, water-resistant waxed leather protects documents, tech, and notebooks.',
            'image' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                'Fits laptops up to 13 inches',
                'Dual quick-release magnetic closures beneath faux buckles',
                'Trolley sleeve on rear for luggage attachment'
            ],
            'specifications' => [
                'Material' => 'Waxed Distressed Cowhide',
                'Dimensions' => '36 cm x 27 cm x 10 cm'
            ],
            'colors' => [
                ['name' => 'Deep Chocolate', 'hex' => '#4A2C20', 'stock' => true]
            ]
        ],

        // ACCESSORIES
        [
            'id' => 17,
            'slug' => 'handcrafted-brass-and-leather-key-fob',
            'name' => 'Handcrafted Brass & Leather Key Fob',
            'category' => 'accessories',
            'category_name' => 'Everyday Accessories',
            'price' => 1650,
            'original_price' => null,
            'badge' => 'Bestseller',
            'is_bestseller' => true,
            'is_new' => false,
            'rating' => 4.9,
            'reviews_count' => 53,
            'short_description' => 'Solid sand-cast brass trigger clasp combined with thick hand-stitched bridal leather loop.',
            'description' => 'A tactile everyday pleasure. Solid brass spring clasp connects securely to belt loops or bag D-rings, keeping vehicle and home keys always at hand.',
            'image' => 'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                'Solid sand-cast brass hardware with natural patina finish',
                'Thick 8 oz bridle leather loop with burnished edges',
                'Laser-etched By Zunash monogram star'
            ],
            'specifications' => [
                'Material' => 'English Bridle Cowhide & Solid Brass',
                'Length' => '13 cm total'
            ],
            'colors' => [
                ['name' => 'Tan Gold', 'hex' => '#A87548', 'stock' => true],
                ['name' => 'Espresso', 'hex' => '#24160F', 'stock' => true]
            ]
        ],
        [
            'id' => 18,
            'slug' => 'full-grain-passport-folio',
            'name' => 'Full-Grain Passport Folio',
            'category' => 'accessories',
            'category_name' => 'Everyday Accessories',
            'price' => 3450,
            'original_price' => 3950,
            'badge' => 'New Arrival',
            'is_bestseller' => false,
            'is_new' => true,
            'rating' => 4.9,
            'reviews_count' => 38,
            'short_description' => 'Refined passport sleeve with boarding pass slide, dual SIM slots, and ejector pin holder.',
            'description' => 'Essential travel luxury. Houses international passports snugly with dedicated cutouts for micro SIM cards, travel receipts, and emergency cash.',
            'image' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                'Fits all standard international passport booklets',
                '2 dedicated card slots plus folded boarding pass pocket',
                'Gold foil stamped star emblem'
            ],
            'specifications' => [
                'Material' => 'Smooth Vegetable Tanned Calfskin',
                'Dimensions' => '14.2 cm x 10.2 cm (Closed)'
            ],
            'colors' => [
                ['name' => 'Espresso Brown', 'hex' => '#24160F', 'stock' => true]
            ]
        ],
        [
            'id' => 19,
            'slug' => 'monogram-valet-catchall-tray',
            'name' => 'Monogram Valet Catchall Tray',
            'category' => 'accessories',
            'category_name' => 'Everyday Accessories',
            'price' => 2950,
            'original_price' => null,
            'badge' => null,
            'is_bestseller' => false,
            'is_new' => false,
            'rating' => 4.8,
            'reviews_count' => 27,
            'short_description' => 'Corner-snapping desk valet tray in heavyweight oiled saddle leather.',
            'description' => 'Packs completely flat for travel; snaps into an elegant 3D desk tray in seconds to hold your timepiece, cuff links, keys, and coins.',
            'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                'Antique brass corner snap buttons',
                'Lays completely flat in luggage for business trips',
                'Suede bottom lining prevents scratching furniture surfaces'
            ],
            'specifications' => [
                'Material' => 'Heavy Saddle Leather & Micro-Suede',
                'Dimensions' => '18 cm x 18 cm x 4 cm (Formed)'
            ],
            'colors' => [
                ['name' => 'Cognac Tan', 'hex' => '#A87548', 'stock' => true]
            ]
        ],
        [
            'id' => 20,
            'slug' => 'classic-leather-eyewear-case',
            'name' => 'Classic Leather Eyewear Case',
            'category' => 'accessories',
            'category_name' => 'Everyday Accessories',
            'price' => 2800,
            'original_price' => null,
            'badge' => null,
            'is_bestseller' => false,
            'is_new' => false,
            'rating' => 4.7,
            'reviews_count' => 16,
            'short_description' => 'Rigid bridge-support sunglass case with soft velvet interior lining.',
            'description' => 'Shields your favorite optical glasses or sunglasses from crush damage. Features an interior nose-bridge pillar and antique brass snap closure.',
            'image' => 'https://images.unsplash.com/photo-1589782182703-2aaa69037b5b?auto=format&fit=crop&w=800&q=80',
            'gallery' => [
                'https://images.unsplash.com/photo-1589782182703-2aaa69037b5b?auto=format&fit=crop&w=800&q=80'
            ],
            'features' => [
                'Internal rigid nose-bridge support structure',
                'Plush anti-scratch microfibre velvet interior',
                'Secure brass dome snap fastener'
            ],
            'specifications' => [
                'Material' => 'Structured Cowhide Leather',
                'Dimensions' => '17 cm x 7.5 cm x 4 cm'
            ],
            'colors' => [
                ['name' => 'Deep Espresso', 'hex' => '#24160F', 'stock' => true]
            ]
        ]
    ]
];
