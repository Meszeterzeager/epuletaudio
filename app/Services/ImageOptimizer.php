<?php

namespace App\Services;

use Closure;
use Filament\Forms\Components\BaseFileUpload;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class ImageOptimizer
{
    /**
     * Resize an uploaded image down to the given bounds, convert it to WebP,
     * store it on the given disk, and return the stored path.
     */
    public static function store(
        UploadedFile $file,
        string $directory,
        string $disk = 'public',
        int $maxWidth = 1920,
        int $maxHeight = 1920,
        int $quality = 72,
    ): string {
        $manager = new ImageManager(new Driver());
        $image = $manager->decodePath($file->getRealPath());
        $image->scaleDown($maxWidth, $maxHeight);

        $encoded = $image->encode(new WebpEncoder(quality: $quality));

        $path = trim($directory, '/').'/'.Str::random(40).'.webp';

        Storage::disk($disk)->put($path, (string) $encoded);

        return $path;
    }

    /**
     * A `saveUploadedFileUsing()` callback for Filament FileUpload fields that
     * resizes and converts images to WebP before storing them.
     */
    public static function filamentSaveUsing(int $maxWidth = 1920, int $maxHeight = 1920, int $quality = 72): Closure
    {
        return function (BaseFileUpload $component, UploadedFile $file) use ($maxWidth, $maxHeight, $quality): string {
            return self::store(
                $file,
                $component->getDirectory() ?? '',
                $component->getDiskName(),
                $maxWidth,
                $maxHeight,
                $quality,
            );
        };
    }
}
