<?php

namespace App\Support;

use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class CloudinaryUrlGenerator extends DefaultUrlGenerator
{
    public function getUrl(): string
    {
        $url = parent::getUrl();
        $cloudName = '';
        $cloudinaryUrl = config('cloudinary.cloud_url') ?? env('CLOUDINARY_URL');
        
        if (!$cloudinaryUrl) {
            $envPaths = [base_path('.env'), base_path('../.env'), base_path('../../.env')];
            foreach ($envPaths as $envPath) {
                if (file_exists($envPath)) {
                    $envContent = file_get_contents($envPath);
                    if (preg_match('/^CLOUDINARY_URL=["\']?cloudinary:\/\/(.*?):(.*?)@([^"\'\s\r\n]+)["\']?/m', $envContent, $matches)) {
                        $cloudName = trim($matches[3]);
                        break;
                    }
                }
            }
        } else {
            if (preg_match('/@([^\/]+)$/', $cloudinaryUrl, $matches)) {
                $cloudName = trim($matches[1]);
            }
        }

        if ($cloudName) {
            if ($url && preg_match('/res\.cloudinary\.com\/\/?image\//', $url)) {
                return preg_replace('/res\.cloudinary\.com\/\/?image\//', 'res.cloudinary.com/' . $cloudName . '/image/', $url);
            }
            
            // Intercept local URLs and convert to Cloudinary
            if (str_contains($url, '/storage/')) {
                $parts = explode('/storage/', $url);
                if (count($parts) > 1) {
                    return 'https://res.cloudinary.com/' . $cloudName . '/image/upload/' . $parts[1];
                }
            }
        }

        return $url;
    }
}
