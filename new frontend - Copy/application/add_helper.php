<?php
$file = 'app/Http/Helpers/helpers.php';
$content = file_get_contents($file);
if (strpos($content, 'function getCloudinaryOrLocalUrl') === false) {
    $code = <<<'PHP'

function getCloudinaryOrLocalUrl($media) {
    if (!$media) return '';
    
    if (isset($media->disk) && $media->disk === 'cloudinary') {
        $envPath = base_path('../../.env');
        if (file_exists($envPath)) {
            $env = file_get_contents($envPath);
            if (preg_match('/^CLOUDINARY_URL=cloudinary:\/\/(.*?):(.*?)@(.*?)$/m', $env, $matches)) {
                $cloudName = trim($matches[3]);
                return 'https://res.cloudinary.com/' . $cloudName . '/image/upload/' . $media->id . '/' . $media->file_name;
            }
        }
    }
    
    // Fallback to local url
    $pawllyDomain = \Illuminate\Support\Facades\DB::table('settings')->where('name', 'app_domain_url')->value('val') ?? '';
    return $pawllyDomain . '/storage/' . $media->id . '/' . $media->file_name;
}
PHP;
    file_put_contents($file, $content . $code);
    echo 'Added function to helpers.php';
} else {
    echo 'Function already exists';
}
