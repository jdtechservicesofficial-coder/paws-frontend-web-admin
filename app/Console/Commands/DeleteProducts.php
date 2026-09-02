<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Product\Models\ProductVariation;
use Modules\Product\Models\Product;
use Modules\Category\Models\Category;
use Illuminate\Support\Facades\Schema;

class DeleteProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all products, variations, and categories along with media';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Schema::disableForeignKeyConstraints();

        $this->info("Deleting Product Variations...");
        ProductVariation::all()->each(function($variation) {
            if (method_exists($variation, 'getMedia')) {
                $variation->getMedia()->each->delete();
            }
            $variation->delete();
        });

        $this->info("Deleting Products...");
        Product::withTrashed()->get()->each(function($product) {
            if (method_exists($product, 'getMedia')) {
                $product->getMedia()->each->delete();
            }
            if (method_exists($product, 'categories')) {
                $product->categories()->detach();
            }
            $product->forceDelete();
        });

        $this->info("Deleting Categories...");
        Category::withTrashed()->get()->each(function($category) {
            if (method_exists($category, 'getMedia')) {
                $category->getMedia()->each->delete();
            }
            $category->forceDelete();
        });

        Schema::enableForeignKeyConstraints();

        $this->info('Deletion successful.');
    }
}
