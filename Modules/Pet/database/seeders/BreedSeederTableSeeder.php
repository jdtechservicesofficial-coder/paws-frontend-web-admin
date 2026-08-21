<?php

namespace Modules\Pet\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Pet\Models\Breed;
use Illuminate\Support\Facades\DB;

class BreedSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $data = [
            // Cat Breeds (pettype_id: 1)
            [
                'name' => 'Abyssinian',
                'slug' => 'abyssinian',
                'pettype_id' => 1,
                'status' => 1,
                'description' => 'Energetic and graceful breed with a ticked coat and curiosity.',
            ],
            [
                'name' => 'American Shorthair',
                'slug' => 'American Shorthair',
                'pettype_id' => 1,
                'status' => 1,
                'description' => 'Friendly, adaptable, and versatile breed with various coat colors/patterns',
            ],
            [
                'name' => 'Bengal',
                'slug' => 'Bengal',
                'pettype_id' => 1,
                'status' => 1,
                'description' => 'Active and intelligent breed with a striking marbled or spotted coat.',
            ],
            [
                'name' => 'British Shorthair',
                'slug' => 'British Shorthair',
                'pettype_id' => 1,
                'status' => 1,
                'description' => 'Easygoing and affectionate breed with a dense, plush blue coat.',
            ],
            [
                'name' => 'Persian',
                'slug' => 'Persian',
                'pettype_id' => 1,
                'status' => 1,
                'description' => 'Quiet and sweet-tempered breed with long, flowing fur and expressive eyes.',
            ],
            [
                'name' => 'Himalayan',
                'slug' => 'Himalayan',
                'pettype_id' => 1,
                'status' => 1,
                'description' => 'Gentle and calm breed, combining Persian features with Siamese color points.',
            ],
            [
                'name' => 'Siamese',
                'slug' => 'Siamese',
                'pettype_id' => 1,
                'status' => 1,
                'description' => 'Vocal, highly social, and active breed with a sleek body and deep blue eyes.',
            ],
            [
                'name' => 'Chartreux',
                'slug' => 'Chartreux',
                'pettype_id' => 1,
                'status' => 1,
                'description' => 'Quiet, sweet-natured breed with a beautiful water-resistant blue-gray coat.',
            ],
            [
                'name' => 'Ragdoll',
                'slug' => 'Ragdoll',
                'pettype_id' => 1,
                'status' => 1,
                'description' => 'Docile, placid, and extremely affectionate breed known to go limp when held.',
            ],
            [
                'name' => 'Sphynx',
                'slug' => 'Sphynx',
                'pettype_id' => 1,
                'status' => 1,
                'description' => 'Highly energetic, friendly, and completely hairless breed with suede-like skin.',
            ],
            
            // Dog Breeds (pettype_id: 2)
            [
                'name' => 'Labrador Retriever',
                'slug' => 'Labrador Retriever',
                'pettype_id' => 2,
                'status' => 1,
                'description' => 'Loyal, friendly, and outgoing; a playful family companion and retriever',
            ],
            [
                'name' => 'German Shepherd',
                'slug' => 'German Shepherd',
                'pettype_id' => 2,
                'status' => 1,
                'description' => 'Intelligent, courageous, and highly versatile working dog.',
            ],
            [
                'name' => 'Golden Retriever',
                'slug' => 'Golden Retriever',
                'pettype_id' => 2,
                'status' => 1,
                'description' => 'Friendly, reliable, and active family dog with a beautiful golden coat.',
            ],
            [
                'name' => 'Bulldog',
                'slug' => 'Bulldog',
                'pettype_id' => 2,
                'status' => 1,
                'description' => 'Calm, courageous, and friendly breed with a thick-set, low-slung body.',
            ],
            [
                'name' => 'Beagle',
                'slug' => 'Beagle',
                'pettype_id' => 2,
                'status' => 1,
                'description' => 'Merry, amiable, and curious hound dog with a superb sense of smell.',
            ],
            [
                'name' => 'Poodle',
                'slug' => 'Poodle',
                'pettype_id' => 2,
                'status' => 1,
                'description' => 'Highly intelligent, elegant, and active breed with a curly hypoallergenic coat.',
            ],
            [
                'name' => 'Rottweiler',
                'slug' => 'Rottweiler',
                'pettype_id' => 2,
                'status' => 1,
                'description' => 'Robust, powerful, and deeply loyal guardian breed.',
            ],
            [
                'name' => 'Yorkshire Terrier',
                'slug' => 'Yorkshire Terrier',
                'pettype_id' => 2,
                'status' => 1,
                'description' => 'Sprightly, tomboyish, and brave toy terrier with a fine silky coat.',
            ],
            [
                'name' => 'Boxer',
                'slug' => 'Boxer',
                'pettype_id' => 2,
                'status' => 1,
                'description' => 'Fun-loving, energetic, and highly protective breed with a powerful square jaw.',
            ],
            [
                'name' => 'Boston Terrier',
                'slug' => 'Boston Terrier',
                'pettype_id' => 2,
                'status' => 1,
                'description' => 'Lively, intelligent, and highly affectionate breed dubbed the American Gentleman.',
            ],
        ];

        foreach ($data as $value) {
            $existingBreed = Breed::where('slug', $value['slug'])->first();
            if (!$existingBreed) {
                Breed::create($value);
            }
        }

        // Enable foreign key checks!
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
