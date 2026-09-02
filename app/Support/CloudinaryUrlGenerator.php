<?php

namespace App\Support;

use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class CloudinaryUrlGenerator extends DefaultUrlGenerator
{
    public function getUrl(): string
    {
        $url = parent::getUrl();
        if ($url && preg_match('/res\.cloudinary\.com\/\/?image\//', $url)) {
            $cloudinaryUrl = config('cloudinary.cloud_url') ?? env('CLOUDINARY_URL');
            if ($cloudinaryUrl && preg_match('/@([^\/]+)$/', $cloudinaryUrl, $matches)) {
                $cloudName = trim($matches[1]);
                return preg_replace('/res\.cloudinary\.com\/\/?image\//', 'res.cloudinary.com/' . $cloudName . '/image/', $url);
            }
        }
        return $url;
    }
}
