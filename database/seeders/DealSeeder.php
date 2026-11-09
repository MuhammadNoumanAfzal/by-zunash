<?php

namespace Database\Seeders;

use App\Models\Deal;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $belt = Product::where('slug', 'like', '%belt%')->first() ?? Product::find(1);
        $wallet = Product::where('slug', 'like', '%wallet%')->first() ?? Product::find(2);
        $cardholder = Product::where('slug', 'like', '%card%')->first() ?? Product::find(3);
        $bag = Product::where('slug', 'like', '%satchel%')->orWhere('slug', 'like', '%bag%')->first() ?? Product::find(4);
        $keyfob = Product::where('slug', 'like', '%key%')->first() ?? Product::find(5);

        // Deal 1: The Executive Leather Duo
        if ($belt && $wallet) {
            $orig1 = (float)$belt->price + (float)$wallet->price;
            $deal1 = Deal::updateOrCreate(
                ['slug' => 'the-executive-leather-duo'],
                [
                    'title' => 'The Executive Leather Duo',
                    'tagline' => 'Calfskin Belt & Bifold Wallet',
                    'category_slug' => 'belts',
                    'badge' => 'Save 18%',
                    'description' => 'A curated pairing of our reversible dress belt and vegetable-tanned bifold wallet. Includes matte presentation gift box.',
                    'highlights' => "100% Full-grain vegetable-tanned calfskin\nHand-beveled and beeswax-burnished edges\nSolid brushed antique brass swivel hardware\nIncludes bespoke rigid magnetic gift box",
                    'image' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?auto=format&fit=crop&w=1000&q=80',
                    'deal_price' => 7200,
                    'original_price' => $orig1,
                    'discount_percentage' => 18,
                    'is_active' => true,
                    'is_featured' => true,
                    'sort_order' => 1,
                ]
            );
            $deal1->products()->sync([
                $belt->id => ['quantity' => 1],
                $wallet->id => ['quantity' => 1],
            ]);
        }

        // Deal 2: The Signature Atelier Set
        if ($bag && $cardholder) {
            $orig2 = (float)$bag->price + (float)$cardholder->price;
            $deal2 = Deal::updateOrCreate(
                ['slug' => 'the-signature-atelier-set'],
                [
                    'title' => 'The Signature Atelier Set',
                    'tagline' => 'Handbag & Slim Cardholder',
                    'category_slug' => 'handbags',
                    'badge' => 'Save 16%',
                    'description' => 'Sculpted from matching drum-dyed full-grain hides, matching our premier handbag silhouette with our slim cardholder.',
                    'highlights' => "Drum-dyed full-grain leather with suede lining\nMinimalist 4-pocket matching cardholder included\nHand-finished edge lacquer with reinforced handle\nComplimentary dust bag and presentation packaging",
                    'image' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&w=1000&q=80',
                    'deal_price' => 17900,
                    'original_price' => $orig2,
                    'discount_percentage' => 16,
                    'is_active' => true,
                    'is_featured' => true,
                    'sort_order' => 2,
                ]
            );
            $deal2->products()->sync([
                $bag->id => ['quantity' => 1],
                $cardholder->id => ['quantity' => 1],
            ]);
        }

        // Deal 3: Everyday Carry Trio
        if ($belt && $cardholder && $keyfob) {
            $orig3 = (float)$belt->price + (float)$cardholder->price + (float)$keyfob->price;
            $deal3 = Deal::updateOrCreate(
                ['slug' => 'the-everyday-carry-trio'],
                [
                    'title' => 'The Everyday Carry Trio',
                    'tagline' => 'Belt, Cardholder & Key Fob',
                    'category_slug' => 'accessories',
                    'badge' => 'Save 20%',
                    'description' => 'A complete 3-piece daily essentials set in matching warm cognac leather, accompanied by luxury presentation box.',
                    'highlights' => "Tri-set in harmonized warm cognac tones\nSolid brass trigger clasp on everyday key fob\nSlim 4mm cardholder fits jacket breast pocket\nPacked together in custom atelier gift carton",
                    'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=1000&q=80',
                    'deal_price' => 7800,
                    'original_price' => $orig3,
                    'discount_percentage' => 20,
                    'is_active' => true,
                    'is_featured' => false,
                    'sort_order' => 3,
                ]
            );
            $deal3->products()->sync([
                $belt->id => ['quantity' => 1],
                $cardholder->id => ['quantity' => 1],
                $keyfob->id => ['quantity' => 1],
            ]);
        }
    }
}
