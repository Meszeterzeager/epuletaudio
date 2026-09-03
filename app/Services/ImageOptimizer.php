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
     * Width/height cap for the small "card" variant generated alongside
     * every stored image, used by teaser grids (solution/service cards)
     * so they don't ship the full hero-sized file.
     */
    public const THUMB_SIZE = 700;

    /**
     * Resize an uploaded image down to the given bounds, convert it to WebP,
     * store it on the given disk, and return the stored path. Also generates
     * a small "_thumb" variant next to it for card/grid usage.
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
        $directory = trim($directory, '/');
        $basename = Str::random(40);
        $path = $directory.'/'.$basename.'.webp';

        $image = $manager->decodePath($file->getRealPath());
        $image->scaleDown($maxWidth, $maxHeight);
        $encoded = $image->encode(new WebpEncoder(quality: $quality));
        Storage::disk($disk)->put($path, (string) $encoded);

        $thumb = $manager->decodePath($file->getRealPath());
        $thumb->scaleDown(self::THUMB_SIZE, self::THUMB_SIZE);
        $thumbEncoded = $thumb->encode(new WebpEncoder(quality: $quality));
        Storage::disk($disk)->put(self::thumbPath($path), (string) $thumbEncoded);

        return $path;
    }

    /**
     * Derive the "_thumb" variant path for a stored image path.
     */
    public static function thumbPath(string $path): string
    {
        return preg_replace('/\.webp$/', '', $path).'_thumb.webp';
    }

    /**
     * Resolve the public URL of the small card variant for a stored image,
     * falling back to the full-size image if no thumb exists for it yet.
     */
    public static function thumbUrl(?string $path, string $disk = 'public'): ?string
    {
        if (! $path) {
            return null;
        }

        $thumbPath = self::thumbPath($path);

        return Storage::disk($disk)->exists($thumbPath)
            ? Storage::disk($disk)->url($thumbPath)
            : Storage::disk($disk)->url($path);
    }

    /**
     * Generate the missing "_thumb" variant for an already-stored image.
     * Used to backfill images uploaded before thumb generation existed.
     */
    public static function backfillThumb(string $path, string $disk = 'public', int $quality = 72): void
    {
        $thumbPath = self::thumbPath($path);

        if (Storage::disk($disk)->exists($thumbPath) || ! Storage::disk($disk)->exists($path)) {
            return;
        }

        $manager = new ImageManager(new Driver());
        $thumb = $manager->decodeBinary(Storage::disk($disk)->get($path));
        $thumb->scaleDown(self::THUMB_SIZE, self::THUMB_SIZE);
        $encoded = $thumb->encode(new WebpEncoder(quality: $quality));

        Storage::disk($disk)->put($thumbPath, (string) $encoded);
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
