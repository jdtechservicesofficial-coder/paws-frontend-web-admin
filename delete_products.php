<?php
use Modules\Product\Models\ProductVariation;
use Modules\Product\Models\Product;
use Modules\Category\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Schema::disableForeignKeyConstraints();

// 1. Delete all Product Variations
ProductVariation::all()->each(function($variation) {
    if (method_exists($variation, 'getMedia')) {
        $variation->getMedia()->each->delete();
    }
    $variation->delete();
});

// 2. Delete all Products
Product::withTrashed()->get()->each(function($product) {
    if (method_exists($product, 'getMedia')) {
        $product->getMedia()->each->delete();
    }
    if (method_exists($product, 'categories')) {
        $product->categories()->detach();
    }
    $product->forceDelete();
});

// 3. Delete all Categories
Category::withTrashed()->get()->each(function($category) {
    if (method_exists($category, 'getMedia')) {
        $category->getMedia()->each->delete();
    }
    $category->forceDelete();
});

Schema::enableForeignKeyConstraints();

echo "Deletion successful.\n";
