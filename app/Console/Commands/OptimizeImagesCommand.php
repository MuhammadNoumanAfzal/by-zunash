<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ImageOptimizer;
use App\Models\Category;
use App\Models\Product;

class OptimizeImagesCommand extends Command
{
    protected $signature = 'images:optimize';
    protected $description = 'Compress, resize, and convert all catalog, category, and site images to WebP';

    public function handle(): int
    {
        $this->info('Starting automated image compression and WebP conversion...');

        $directories = [
            'images/categories' => 800,
            'images/products'   => 800,
            'images/brand'      => 900,
            'images/deals'      => 900,
            'images/hero'       => 1600,
        ];

        $totalConverted = 0;
        $totalBytesSaved = 0;

        foreach ($directories as $subfolder => $maxDim) {
            $dirPath = public_path($subfolder);
            if (!is_dir($dirPath)) continue;

            $files = scandir($dirPath);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                $fullPath = $dirPath . '/' . $file;
                if (!is_file($fullPath)) continue;

                $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                if (!in_array($ext, ['png', 'jpg', 'jpeg', 'webp'])) continue;

                $origSize = filesize($fullPath);
                $info = @getimagesize($fullPath);
                if (!$info) continue;

                $width = $info[0];
                $height = $info[1];

                $baseName = pathinfo($fullPath, PATHINFO_FILENAME);
                $webpPath = $dirPath . '/' . $baseName . '.webp';
                $jpgPath = $dirPath . '/' . $baseName . '.jpg';

                // If PNG or large JPG or WebP > 800px, recompress to optimal WebP
                $needsOptimization = ($ext === 'png') || 
                                    ($width > $maxDim || $height > $maxDim) || 
                                    (!file_exists($webpPath)) || 
                                    ($origSize > 120000);

                if ($needsOptimization) {
                    $quality = ($subfolder === 'images/hero') ? 85 : 80;
                    $success = ImageOptimizer::resizeAndSave($fullPath, $webpPath, $jpgPath, $maxDim, $quality);

                    if ($success) {
                        clearstatcache();
                        $newSize = file_exists($webpPath) ? filesize($webpPath) : $origSize;
                        $saved = max(0, $origSize - $newSize);
                        $totalBytesSaved += $saved;
                        $totalConverted++;

                        $this->line("Optimized: {$subfolder}/{$file} ({$width}x{$height}, " . round($origSize / 1024, 1) . "KB -> " . round($newSize / 1024, 1) . "KB WebP)");
                    }
                }
            }
        }

        // Update database records to use WebP versions if available
        $this->info('Updating Category and Product database records to WebP paths...');

        $categories = Category::all();
        foreach ($categories as $cat) {
            if ($cat->image) {
                $cleanPath = ltrim($cat->image, '/');
                $webpPath = preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $cleanPath);
                if (file_exists(public_path($webpPath)) && $cat->image !== '/' . $webpPath) {
                    $cat->image = '/' . $webpPath;
                    $cat->save();
                    $this->line("Category '{$cat->name}' updated to: /{$webpPath}");
                }
            }
        }

        $products = Product::all();
        foreach ($products as $prod) {
            if ($prod->image) {
                $cleanPath = ltrim($prod->image, '/');
                $webpPath = preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $cleanPath);
                if (file_exists(public_path($webpPath)) && $prod->image !== '/' . $webpPath) {
                    $prod->image = '/' . $webpPath;
                    $prod->save();
                    $this->line("Product '{$prod->name}' updated to: /{$webpPath}");
                }
            }
        }

        $mbSaved = round($totalBytesSaved / (1024 * 1024), 2);
        $this->info("Completed! Total images optimized: {$totalConverted}. Space/bandwidth saved: {$mbSaved} MB.");

        return 0;
    }
}
