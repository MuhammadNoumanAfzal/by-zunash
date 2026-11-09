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
        $belt = Product::where('slug', 'like', '%belt%')->first() ?? Product::first();
        $wallet = Product::where('slug', 'like', '%wallet%')->first() ?? Product::skip(1)->first();
        $cardholder = Product::where('slug', 'like', '%card%')->first() ?? Product::skip(2)->first();
        $bag = Product::where('slug', 'like', '%bag%')->orWhere('slug', 'like', '%satchel%')->first() ?? Product::skip(3)->first();

        if ($belt && $wallet) {
            $origDuo = $belt->price + $wallet->price;
            $dealPriceDuo = round($origDuo * 0.82); // ~18% off

            $deal1 = Deal::updateOrCreate(
                ['slug' => 'the-executive-leather-duo'],
                [
                    'title' => 'The Executive Leather Duo',
                    'tagline' => 'Handcrafted Reversible Belt + Heritage Bifold Wallet',
                    'badge' => 'PATRON FAVORITE • SAVE 18%',
                    'description' => 'A curated pairing of our best-selling Italian calfskin reversible dress belt and our vegetable-tanned bifold wallet. Designed for boardroom composure and effortless daily utility. Presented in a custom rigid matte gift box.',
                    'image' => '/images/products/prod-reversible-belt.jpg',
                    'deal_price' => $dealPriceDuo,
                    'original_price' => $origDuo,
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

        if ($bag && $cardholder) {
            $origTrio = $bag->price + $cardholder->price;
            $dealPriceTrio = round($origTrio * 0.85); // 15% off

            $deal2 = Deal::updateOrCreate(
                ['slug' => 'the-signature-atelier-set'],
                [
                    'title' => 'The Signature Atelier Set',
                    'tagline' => 'Full-Grain Handbag + Slim RFID Cardholder',
                    'badge' => 'LIMITED ATELIER SET • SAVE 15%',
                    'description' => 'Sculpted from matching drum-dyed full-grain hides, this sophisticated pairing matches our premier handbag silhouette with our ultra-slim RFID cardholder for refined travel and day-to-evening carry.',
                    'image' => '/images/products/prod-signature-satchel.jpg',
                    'deal_price' => $dealPriceTrio,
                    'original_price' => $origTrio,
                    'discount_percentage' => 15,
                    'is_active' => true,
                    'is_featured' => false,
                    'sort_order' => 2,
                ]
            );

            $deal2->products()->sync([
                $bag->id => ['quantity' => 1],
                $cardholder->id => ['quantity' => 1],
            ]);
        }
    }
}
