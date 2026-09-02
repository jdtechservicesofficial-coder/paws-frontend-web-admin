<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Category\Models\Category;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductCategory;
use Illuminate\Support\Str;

class PopulateInventory extends Command
{
    protected $signature = 'app:populate-inventory';
    protected $description = 'Populate inventory from embedded data';

    public function handle()
    {
        $data = [
            ['Dog Food', 'Can Food', 'Pedigree', 101, 2900],
            ['Dog Food', 'Can Food', 'Booster Puppy', 59, 2500],
            ['Dog Food', 'Can Food', 'Booster All Life Stage', 52, 2500],
            ['Dog Food', 'Can Food', 'Balance', 25, 2500],
            ['Dog Food', 'Can Food', 'Optimax Dog', 34, 2500],
            ['Dog Food', 'Can Food', 'Frances Pride', 34, 2500],
            ['Dog Food', 'Can Food', 'Gran Bonta', 85, 2500],
            ['Dog Food', 'Can Food', 'Nitro Pro Puppy', 13, 2500],
            ['Dog Food', 'Can Food', 'Nitro Pro Adult', 0, 0],
            ['Dog Food', 'Can Food', 'Dekra', 86, 2500],
            ['Dog Food', 'Can Food', 'First Choice Puppy', 52, 2500],
            ['Dog Food', 'Can Food', 'First Choice Adult', 32, 2500],
            ['Dog Food', 'Can Food', 'Sigma Dog', 1, 0],
            ['Dog Food', 'Dry Food', 'Balance Dog Dry Food (5kg)', 4, 35000],
            ['Dog Food', 'Dry Food', 'Booster Dog Dry Food (10kg)', 2, 30000],
            ['Dog Food', 'Dry Food', 'Zito Puppy', 3, 30000],
            ['Dog Food', 'Dry Food', 'Zito Adult', 4, 30000],
            ['Dog Food', 'Dry Food', 'Booster Dog Dry Food (4kg)', 11, 35000],
            ['Dog Food', 'Dry Food', 'Dog Show', 1, 95000],
            ['Dog Food', 'Dry Food', 'Boreal Dog Dry Food', 2, 15000],
            ['Dog Food', 'Treats', 'VegeBones', 0, 0],
            ['Dog Food', 'Treats', 'Beef Flavor', 1, 0],
            ['Dog Food', 'Treats', 'Booster Dog Treat', 2, 9000],
            ['Dog Food', 'Treats', 'Chewing Bone', 2, 8500],
            ['Dog Food', 'Treats', 'Booster Chew Bone', 12, 0],
            ['Cat Food', 'Can Food', 'Real Meat', 48, 2500],
            ['Cat Food', 'Can Food', 'Wimow Can Food', 106, 2500],
            ['Cat Food', 'Can Food', 'Optimax', 26, 2500],
            ['Cat Food', 'Can Food', 'Booster Cat', 54, 2900],
            ['Cat Food', 'Can Food', 'Sigma Cat', 23, 2500],
            ['Cat Food', 'Can Food', 'Mousse Pate', 48, 2500],
            ['Cat Food', 'Dry Food', 'Booster Cat Dry', 3, 35000],
            ['Cat Food', 'Dry Food', 'Whiskas', 1, 35000],
            ['Cat Food', 'Dry Food', 'Boreal Cat', 8, 45000],
            ['Cat Food', 'Dry Food', 'Sigma Cat', 1, 0],
            ['Cat Food', 'Dry Food', 'Royal Canin (4kg)', 1, 80000],
            ['Cat Food', 'Dry Food', 'Royal Canin (2kg)', 6, 48000],
            ['Cat Food', 'Dry Food', 'Purina Go-Cat', 6, 39000],
            ['Cat Food', 'Treats', 'Mouthful', 18, 3500],
            ['Cat Food', 'Treats', 'Whiskas', 36, 3500],
            ['Cat Food', 'Treats', 'Wimow', 59, 1500],
            ['Cat Food', 'Treats', 'Leo', 30, 2000],
            ['Cat Food', 'Treats', 'Gemon', 5, 1600],
            ['Cat Food', 'Treats', 'Sheba', 21, 4000],
            ['Cat Food', 'Treats', 'Wagon', 0, 0],
            ['Cat Food', 'Cat Litter', 'Clean Step (9L)', 3, 30000],
            ['Cat Food', 'Cat Litter', 'Jojo Kitty Fresh (8kg)', 28, 35000],
            ['Cat Food', 'Cat Litter', 'Clean Paws', 2, 0],
            ['Cat Food', 'Cat Litter', 'Pettex', 3, 15000],
            ['Cat Food', 'Cat Litter', 'Chat & Chat', 2, 20000],
            ['Cat Food', 'Cat Litter', 'Glory Penny (10L)', 1, 27000],
            ['Shampoos', 'Pet Shampoo', 'Endi Deodorization Spray', 0, 0],
            ['Shampoos', 'Pet Shampoo', 'Fresh Scent Shampoo', 3, 14000],
            ['Shampoos', 'Dog Shampoo', 'Global Canine Dog Shampoo', 5, 15000],
            ['Shampoos', 'Pet Shampoo', 'Tea Tree Oil Shampoo', 0, 0],
            ['Shampoos', 'Pet Shampoo', 'Fresh N Clean', 5, 25000],
            ['Shampoos', 'Pet Shampoo', 'Tearless Formula White', 0, 0],
            ['Shampoos', 'Pet Shampoo', 'Coat Shampoo', 1, 0],
            ['Shampoos', 'Pet Shampoo', 'Daisy Lilia', 2, 0],
            ['Shampoos', 'Pet Shampoo', 'Endi Aroma Pet Shampoo (Big)', 4, 10000],
            ['Shampoos', 'Pet Shampoo', 'Endi Aroma Pet Shampoo (Small)', 2, 10000],
            ['Shampoos', 'Cat Shampoo', 'Cat Shampoo', 4, 0],
            ['Shampoos', 'Pet Shampoo', 'Gentle Pet Shampoo', 2, 25000],
            ['Shampoos', 'Pet Shampoo', 'Touchpaws Pet Shampoo', 3, 15000],
            ['Shampoos', 'Pet Shampoo', 'Class & Claws Shampoo', 37, 9000],
            ['Shampoos', 'Dog Shampoo', 'Animology Dog Shampoo', 9, 15000],
            ['Shampoos', 'Pet Soap', 'XJOPHER Dog Soap', 4, 3000],
            ['Health & Pet Care', 'Flea & Tick', 'Cat Flea & Tick Collar', 5, 7500],
            ['Health & Pet Care', 'Flea & Tick', 'Dog Flea & Tick Collar', 2, 7500],
            ['Health & Pet Care', 'Supplements', 'Catnip', 3, 0],
            ['Health & Pet Care', 'Treats', 'Catnip Biscuit', 26, 9000],
            ['Health & Pet Care', 'Treats', 'Dogs N More Cookies', 0, 0],
            ['Health & Pet Care', 'Milk & Nutrition', 'Class & Claws Pet Milk', 2, 24000],
            ['Health & Pet Care', 'Milk & Nutrition', 'Goat Milk', 3, 23000],
            ['Health & Pet Care', 'Milk & Nutrition', 'Wimow Kitten Milk', 3, 0],
            ['Health & Pet Care', 'Milk & Nutrition', 'Dogomax Milk Replacer', 7, 25000],
            ['Health & Pet Care', 'Dental Care', 'Toothbrush & Paste', 1, 10000],
            ['Health & Pet Care', 'Grooming Care', 'Pet Nail Clipper', 9, 0],
            ['Health & Pet Care', 'Flea & Tick', 'Class & Claws Tick & Flea Spray', 2, 0],
            ['Health & Pet Care', 'Flea & Tick', 'Eradicator Dog Spray', 1, 15000],
            ['Health & Pet Care', 'Flea & Tick', 'Eradicator Dog Spray (Small)', 2, 9000],
            ['Health & Pet Care', 'Training', 'Puppy Trainer Training Aid', 11, 0],
            ['Health & Pet Care', 'Cat Litter Care', 'Cat Litter Deodorizing Beads', 5, 10000],
            ['Health & Pet Care', 'Supplements', 'Pet Tabs Forte', 1, 0],
            ['Health & Pet Care', 'Medication', 'Fluravet (2.0–4.5kg)', 2, 11000],
            ['Health & Pet Care', 'Medication', 'Fluravet (20–40kg)', 1, 28000],
            ['Health & Pet Care', 'Supplements', 'Vetzyme Moult & Coat', 1, 0],
            ['Health & Pet Care', 'Supplements', 'Vigor-Vit', 11, 0],
            ['Health & Pet Care', 'Dewormer', 'Eagle Merry Pet Dewormer', 1, 0],
            ['Health & Pet Care', 'Medication', 'MangeQ', 8, 0],
            ['Health & Pet Care', 'Medication', 'Zerokrim', 4, 0],
            ['Health & Pet Care', 'Supplements', 'Vitalpet Puppy', 0, 0],
            ['Health & Pet Care', 'Flea & Tick', 'Fiproprotector', 4, 0],
            ['Health & Pet Care', 'Supplements', 'Chivic Pet Advanced Supplement', 1, 0],
            ['Health & Pet Care', 'Supplements', 'Hemp Calming Chews', 3, 0],
            ['Health & Pet Care', 'Supplements', 'Pre & Probiotic', 3, 0],
            ['Health & Pet Care', 'Hygiene', 'Pet Wipes', 0, 0],
            ['Health & Pet Care', 'Ear Care', 'Ear Drops', 7, 0],
            ['Health & Pet Care', 'Deterrent', 'Cat & Kitten Deterrent Spray', 2, 0],
            ['Health & Pet Care', 'Dental Care', '6-in-1 Canine Dental Solution', 3, 0],
            ['Health & Pet Care', 'Wound Care', 'Super Heal Wound Healing Oil', 3, 0],
            ['Health & Pet Care', 'Wound Care', 'Sheck Wound Healing Cream', 5, 0],
            ['Health & Pet Care', 'Wound Care', 'Command Dog Wound Healing Oil', 9, 0],
            ['Health & Pet Care', 'Supplements', 'Zito Cod Oil', 7, 0],
            ['Grooming Tools', 'Brushes & Combs', 'Pet Comb', 12, 0],
            ['Grooming Tools', 'Brushes & Combs', 'Pet Rake', 7, 0],
            ['Grooming Tools', 'Brushes & Combs', 'Double-Sided Pet Brush', 6, 0],
            ['Grooming Tools', 'Bathing', 'Bath Brush', 3, 0],
            ['Grooming Tools', 'Bathing', 'Bath Glove', 1, 0],
            ['Grooming Tools', 'Grooming Kits', '3-Piece Grooming Kit', 1, 0],
            ['Grooming Tools', 'Towels', 'Towel', 11, 0],
            ['Grooming Tools', 'Grooming Bags', 'Grooming Bags', 2, 0],
            ['Toys', 'Dog Toys', 'Fish Toy', 5, 0],
            ['Toys', 'Dog Toys', 'Squeaky Ball', 4, 0],
            ['Toys', 'General Toys', 'Ball', 9, 0],
            ['Toys', 'Cat Toys', 'Cat Wand Toy', 0, 0],
            ['Toys', 'Dog Toys', 'Squeaky Teddy Toy', 24, 0],
            ['Toys', 'Dog Toys', 'Shoe Toy', 6, 0],
            ['Toys', 'Dog Toys', 'Dog Treat Maze', 0, 0],
            ['Toys', 'Dog Toys', 'Dog Smart', 0, 0],
            ['Toys', 'Dog Toys', 'Dog Brick', 0, 0],
            ['Toys', 'General Toys', 'Pet Toys', 16, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Harnesses', 'Dog Harness (Small)', 8, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Harnesses', 'Dog Harness (Medium)', 24, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Harnesses', 'Dog Harness (Large)', 6, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Harnesses', 'Dog Harness (XL)', 6, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Leashes', 'Leash & Collar (Small)', 15, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Leashes', 'Leash & Collar (Medium)', 28, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Leashes', 'Leash & Collar (Big)', 8, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Leashes', 'Long Big Leash', 13, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Leashes', 'Short Big Leash', 4, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Leashes', 'Small Leash', 2, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Leashes', 'Retractable Leash (Small)', 1, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Leashes', 'Retractable Leash (Medium)', 2, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Leashes', 'Retractable Leash (Big)', 0, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Collars', 'Big Collar', 14, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Collars', 'Medium Collar', 7, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Collars', 'Small Collar', 8, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Collars', 'Bell Collar (Small)', 1, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Collars', 'Elizabethan Collar (Small)', 3, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Collars', 'Elizabethan Collar (Medium)', 1, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Collars', 'Pet Protective Collar Cone', 3, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Muzzles', 'Small', 7, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Muzzles', 'Medium', 5, 0],
            ['Harnesses, Leashes, Collars & Muzzles', 'Muzzles', 'Large', 3, 0],
            ['Feeding Accessories', 'Bottles', 'Cat Bottle', 9, 5000],
            ['Feeding Accessories', 'Plates', '2-in-1 Plate (Small)', 2, 5500],
            ['Feeding Accessories', 'Plates', '2-in-1 Plate (Medium)', 7, 0],
            ['Feeding Accessories', 'Plates', '2-in-1 Plate (Large)', 0, 0],
            ['Feeding Accessories', 'Plates', 'Design Plate', 10, 0],
            ['Feeding Accessories', 'Bowls', 'Plastic Bowl (Small)', 5, 0],
            ['Feeding Accessories', 'Bowls', 'Plastic Bowl (Large)', 9, 0],
            ['Feeding Accessories', 'Bowls', 'Stainless Steel Bowl (Small)', 5, 8500],
            ['Feeding Accessories', 'Bowls', 'Stainless Steel Bowl (Medium)', 5, 0],
            ['Feeding Accessories', 'Bowls', 'Stainless Steel Bowl (Large)', 9, 0],
            ['Feeding Accessories', 'Bowls', 'Jumbo Plastic Pet Bowl', 6, 0],
            ['Feeding Accessories', 'Bowls', 'Slow Feed Bowl (Small)', 4, 0],
            ['Feeding Accessories', 'Bowls', 'Slow Feed Bowl (Large)', 5, 0],
            ['Feeding Accessories', 'Bowls', 'Big Bowl', 9, 0],
            ['Feeding Accessories', 'Bowls', 'Extra Large Bowl', 13, 0],
            ['Feeding Accessories', 'Dispensers', 'Water Dispenser', 1, 0],
            ['Feeding Accessories', 'Dispensers', 'Food Dispenser', 4, 0],
            ['Beds, Cages & Carriers', 'Beds', 'Hoopnet Bed', 1, 0],
            ['Beds, Cages & Carriers', 'Beds', 'Plain Bed (Small)', 0, 0],
            ['Beds, Cages & Carriers', 'Beds', 'Plain Bed (Medium)', 1, 0],
            ['Beds, Cages & Carriers', 'Beds', 'Plain Bed (Large)', 0, 0],
            ['Beds, Cages & Carriers', 'Beds', 'Fur Bed (Small)', 1, 0],
            ['Beds, Cages & Carriers', 'Beds', 'Fur Bed (Medium)', 1, 0],
            ['Beds, Cages & Carriers', 'Beds', 'Chair Bed (Small)', 1, 0],
            ['Beds, Cages & Carriers', 'Beds', 'Chair Bed (Large)', 1, 0],
            ['Beds, Cages & Carriers', 'Beds', 'Chair Fur Bed', 1, 0],
            ['Beds, Cages & Carriers', 'Beds', 'Fur Bed with Hood (Small)', 1, 25000],
            ['Beds, Cages & Carriers', 'Beds', 'Fur Bed with Hood (Medium)', 1, 35000],
            ['Beds, Cages & Carriers', 'Beds', 'Fur Bed with Hood (Large)', 1, 55000],
            ['Beds, Cages & Carriers', 'Beds', 'Fur Chair', 1, 0],
            ['Beds, Cages & Carriers', 'Housing', 'Cat House', 0, 0],
            ['Beds, Cages & Carriers', 'Housing', 'Cat Scratcher', 3, 0],
            ['Beds, Cages & Carriers', 'Housing', 'Duplex Cage', 1, 0],
            ['Beds, Cages & Carriers', 'Carriers', 'Pet Carrier (Small)', 5, 0],
            ['Beds, Cages & Carriers', 'Carriers', 'Pet Carrier (Large)', 2, 0],
            ['Beds, Cages & Carriers', 'Cages', 'Cage Size 1', 1, 75000],
            ['Beds, Cages & Carriers', 'Cages', 'Cage Size 2', 1, 0],
            ['Beds, Cages & Carriers', 'Cages', 'Cage Size 3', 2, 95000],
            ['Beds, Cages & Carriers', 'Cages', 'Cage Size 4', 1, 0],
            ['Clothing', 'Dog Clothing', 'Dog Dress', 38, 8500],
            ['Clothing', 'Dog Clothing', 'Dog Shoe', 2, 17000],
            ['Training & Hygiene', 'Training Pads', 'Jojo Fresh Pad', 16, 25000],
            ['Training & Hygiene', 'Training Pads', 'Training Pad (Small)', 8, 25000],
            ['Training & Hygiene', 'Training Pads', 'Training Pad (Medium)', 2, 0],
            ['Training & Hygiene', 'Training Pads', 'Training Pad (Large)', 3, 0],
            ['Training & Hygiene', 'Diapers', 'Female Dog Diapers', 0, 0],
            ['Training & Hygiene', 'Diapers', 'Disposable Diapers', 1, 12800],
            ['Small Pet Food', 'Rabbit Food', 'Essential Classic Rabbit Food', 3, 0],
            ['Small Pet Food', 'Parrot Food', 'Extreme Gourmet Parrot Food', 0, 0],
            ['Other Accessories', 'Cat Litter Accessories', 'Cat Litter Packer', 20, 0],
            ['Other Accessories', 'Cat Litter Accessories', 'Pet Litter Scoop', 5, 5000],
            ['Other Accessories', 'Bags', 'Pet Bag', 0, 0],
            ['Other Accessories', 'Cat Litter Boxes', 'Cat Litter Box (Small)', 1, 25000],
            ['Other Accessories', 'Cat Litter Boxes', 'Cat Litter Box (Medium)', 1, 35000],
            ['Other Accessories', 'Cat Litter Boxes', 'Cat Litter Box (Large)', 1, 45000],
        ];

        \Illuminate\Support\Facades\DB::statement('ALTER TABLE products AUTO_INCREMENT = 1192;');
        $this->info("Starting inventory population...");
        
        foreach ($data as $row) {
            $catName = $row[0];
            $subCatName = $row[1];
            $prodName = $row[2];
            $qty = $row[3];
            $price = $row[4];
            
            // Get or create parent category
            $parentCat = ProductCategory::firstOrCreate(
                ['name' => $catName],
                ['slug' => Str::slug($catName), 'status' => 1]
            );
            
            // Get or create subcategory
            $subCat = null;
            if (!empty($subCatName)) {
                $subCat = ProductCategory::firstOrCreate(
                    ['name' => $subCatName, 'parent_id' => $parentCat->id],
                    ['slug' => Str::slug($subCatName), 'status' => 1]
                );
            }
            
            // Create Product
            $product = Product::firstOrCreate(
                ['name' => $prodName],
                [
                    'slug' => Str::slug($prodName) . '-' . time(),
                    'min_price' => $price,
                    'max_price' => $price,
                    'stock_qty' => $qty,
                    'status' => 1,
                    'created_by' => 1
                ]
            );
            
            // Attach categories
            $catIds = [$parentCat->id];
            if ($subCat) {
                $catIds[] = $subCat->id;
            }
            $product->categories()->syncWithoutDetaching($catIds);
        }
        
        $this->info("Inventory populated successfully!");
    }
}