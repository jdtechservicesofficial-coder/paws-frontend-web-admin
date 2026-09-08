<?php

namespace Database\Seeders;

use App\Models\Frontend;
use Illuminate\Database\Seeder;

class FrontendSeeder extends Seeder
{
    public function run()
    {
        Frontend::create([
            'data_keys' => 'banner.content',
            'data_values' => [
                'heading' => 'Welcome to Pawlly',
                'description' => 'The best pet care',
                'button_url' => '/',
                'button_text' => 'Get Started',
                'background_image' => 'default.png',
            ]
        ]);
        
        Frontend::create([
            'data_keys' => 'seo.data',
            'data_values' => [
                'meta_keywords' => ['pet', 'care'],
                'meta_description' => 'Pet care solution',
                'social_title' => 'Pawlly',
                'social_description' => 'Pawlly',
                'image' => 'default.png',
            ]
        ]);
        
        \App\Models\Page::create([
            'name' => 'Home',
            'slug' => '/',
            'tempname' => 'basic',
            'secs' => json_encode(['about', 'services', 'contact']),
        ]);
    }
}
