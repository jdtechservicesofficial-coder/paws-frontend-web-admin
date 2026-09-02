<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CloudinaryStorageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        \Illuminate\Support\Facades\Storage::extend('cloudinary', function ($app, $config) {
            $adapter = new \App\Extensions\CloudinaryAdapter();
            return new \Illuminate\Filesystem\FilesystemAdapter(
                new \League\Flysystem\Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });
    }
}
