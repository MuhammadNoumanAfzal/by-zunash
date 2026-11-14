<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageOptimizer
{
    /**
     * Process an uploaded file, resize to max dimensions, and save as WebP + JPG fallback.
     * Returns the relative public path of the webp image.
     */
    public static function processUpload(UploadedFile $file, string $subfolder, string $prefix, int $maxDim = 800, int $quality = 80): string
    {
        $destDir = public_path($subfolder);
        if (!file_exists($destDir)) {
            @mkdir($destDir, 0755, true);
        }

        $baseName = $prefix . '-' . time() . '-' . Str::random(5);
        $webpFilename = $baseName . '.webp';
        $jpgFilename = $baseName . '.jpg';

        $sourcePath = $file->getRealPath();
        self::resizeAndSave($sourcePath, $destDir . '/' . $webpFilename, $destDir . '/' . $jpgFilename, $maxDim, $quality);

        return '/' . trim($subfolder, '/') . '/' . $webpFilename;
    }

    /**
     * Resize any image on disk to max dimensions and output WebP & JPG.
     */
    public static function resizeAndSave(string $sourcePath, string $webpPath, ?string $jpgPath = null, int $maxDim = 800, int $quality = 80): bool
    {
        if (!file_exists($sourcePath)) {
            return false;
        }

        $info = @getimagesize($sourcePath);
        if (!$info) {
            return false;
        }

        $mime = $info['mime'];
        $srcWidth = $info[0];
        $srcHeight = $info[1];

        // Create GD resource according to mime
        $srcImage = null;
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $srcImage = @imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $srcImage = @imagecreatefrompng($sourcePath);
                break;
            case 'image/webp':
                if (function_exists('imagecreatefromwebp')) {
                    $srcImage = @imagecreatefromwebp($sourcePath);
                }
                break;
            case 'image/gif':
                $srcImage = @imagecreatefromgif($sourcePath);
                break;
        }

        if (!$srcImage) {
            return false;
        }

        // Calculate proportional dimensions
        $targetWidth = $srcWidth;
        $targetHeight = $srcHeight;

        if ($srcWidth > $maxDim || $srcHeight > $maxDim) {
            if ($srcWidth >= $srcHeight) {
                $targetWidth = $maxDim;
                $targetHeight = (int) round(($srcHeight / $srcWidth) * $maxDim);
            } else {
                $targetHeight = $maxDim;
                $targetWidth = (int) round(($srcWidth / $srcHeight) * $maxDim);
            }
        }

        // Resample image
        $dstImage = imagecreatetruecolor($targetWidth, $targetHeight);

        // Preserve transparency for PNG / WebP
        imagealphablending($dstImage, false);
        imagesavealpha($dstImage, true);
        $transparent = imagecolorallocatealpha($dstImage, 255, 255, 255, 127);
        imagefilledrectangle($dstImage, 0, 0, $targetWidth, $targetHeight, $transparent);
        imagealphablending($dstImage, true);

        imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $srcWidth, $srcHeight);

        // Save WebP
        if (function_exists('imagewebp')) {
            imagewebp($dstImage, $webpPath, $quality);
        }

        // Save JPG fallback if requested
        if ($jpgPath) {
            // For JPG, blend transparent background onto white
            $jpgCanvas = imagecreatetruecolor($targetWidth, $targetHeight);
            $white = imagecolorallocate($jpgCanvas, 255, 255, 255);
            imagefilledrectangle($jpgCanvas, 0, 0, $targetWidth, $targetHeight, $white);
            imagecopy($jpgCanvas, $dstImage, 0, 0, 0, 0, $targetWidth, $targetHeight);
            imagejpeg($jpgCanvas, $jpgPath, max(75, $quality));
            imagedestroy($jpgCanvas);
        }

        imagedestroy($srcImage);
        imagedestroy($dstImage);

        return true;
    }
}
