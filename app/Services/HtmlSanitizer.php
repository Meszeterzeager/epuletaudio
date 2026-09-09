<?php

namespace App\Services;

use HTMLPurifier;
use HTMLPurifier_Config;

class HtmlSanitizer
{
    public static function sanitizeRichContent(?string $html): ?string
    {
        if ($html === null || $html === '') {
            return $html;
        }

        $cachePath = storage_path('app/htmlpurifier-cache');

        if (! is_dir($cachePath) && ! mkdir($cachePath, 0775, true) && ! is_dir($cachePath)) {
            throw new \RuntimeException("Unable to create HTML purifier cache directory: {$cachePath}");
        }

        $config = HTMLPurifier_Config::createDefault();
        $config->set('Cache.SerializerPath', $cachePath);
        $config->set('HTML.Allowed', 'p,br,div,span,strong,b,em,i,u,s,ul,ol,li,blockquote,a[href|title|target],table,thead,tbody,tr,td,th,h1,h2,h3,h4,h5,h6,img[src|alt|width|height]');
        $config->set('HTML.TargetBlank', true);
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);

        return (new HTMLPurifier($config))->purify($html);
    }
}
