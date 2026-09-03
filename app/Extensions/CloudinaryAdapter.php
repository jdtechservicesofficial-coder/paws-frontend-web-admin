<?php

namespace App\Extensions;

use League\Flysystem\Config;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemAdapter;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Str;

class CloudinaryAdapter implements FilesystemAdapter
{
    public function fileExists(string $path): bool
    {
        return true;
    }

    public function directoryExists(string $path): bool
    {
        return true;
    }

    public function write(string $path, string $contents, Config $config): void
    {
        $tempFile = sys_get_temp_dir() . '/' . Str::random(10);
        file_put_contents($tempFile, $contents);
        
        $this->uploadToCloudinary($path, $tempFile);
        
        @unlink($tempFile);
    }

    public function writeStream(string $path, $contents, Config $config): void
    {
        $tempFile = sys_get_temp_dir() . '/' . Str::random(10);
        $handle = fopen($tempFile, 'w');
        stream_copy_to_stream($contents, $handle);
        fclose($handle);

        $this->uploadToCloudinary($path, $tempFile);

        @unlink($tempFile);
    }

    protected function uploadToCloudinary($path, $tempFile)
    {
        $pathInfo = pathinfo($path);
        
        $publicId = $pathInfo['dirname'] !== '.' ? $pathInfo['dirname'] . '/' . $pathInfo['filename'] : $pathInfo['filename'];
        
        // Remove leading slash if exists
        $publicId = ltrim($publicId, '/');

        Cloudinary::upload($tempFile, [
            'public_id' => $publicId,
            'resource_type' => 'auto',
            'use_filename' => true,
            'unique_filename' => false,
            'overwrite' => true,
        ]);
    }

    public function read(string $path): string
    {
        $url = $this->getUrl($path);
        return file_get_contents($url);
    }

    public function readStream(string $path)
    {
        $url = $this->getUrl($path);
        return fopen($url, 'r');
    }

    public function delete(string $path): void
    {
        $pathInfo = pathinfo($path);
        $publicId = $pathInfo['dirname'] !== '.' ? $pathInfo['dirname'] . '/' . $pathInfo['filename'] : $pathInfo['filename'];
        $publicId = ltrim($publicId, '/');
        
        Cloudinary::destroy($publicId);
    }

    public function deleteDirectory(string $path): void
    {
    }

    public function createDirectory(string $path, Config $config): void
    {
    }

    public function setVisibility(string $path, string $visibility): void
    {
    }

    public function visibility(string $path): FileAttributes
    {
        return new FileAttributes($path, null, 'public');
    }

    public function mimeType(string $path): FileAttributes
    {
        return new FileAttributes($path);
    }

    public function lastModified(string $path): FileAttributes
    {
        return new FileAttributes($path);
    }

    public function fileSize(string $path): FileAttributes
    {
        return new FileAttributes($path);
    }

    public function listContents(string $path, bool $deep): iterable
    {
        return [];
    }

    public function move(string $source, string $destination, Config $config): void
    {
        $this->write($destination, $this->read($source), $config);
        $this->delete($source);
    }

    public function copy(string $source, string $destination, Config $config): void
    {
        $this->write($destination, $this->read($source), $config);
    }
    
    public function getUrl(string $path)
    {
        $cloudinaryUrl = config('cloudinary.cloud_url') ?? env('CLOUDINARY_URL');
        $cloudName = '';

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
            $parsed = parse_url($cloudinaryUrl);
            $cloudName = $parsed['host'] ?? '';
        }

        return "https://res.cloudinary.com/" . $cloudName . "/image/upload/" . ltrim($path, '/');
    }
}
