<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Modules\Category\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

// Disable foreign key checks so parent categories can be deleted
DB::statement('SET FOREIGN_KEY_CHECKS=0;');

// 1. Force delete all categories
$categories = Category::withTrashed()->get();
foreach ($categories as $category) {
    if ($category->hasMedia('category_image')) {
        $category->getMedia('category_image')->each->delete();
    }
    $category->forceDelete();
}
echo "Categories force deleted.\n";

// Clear product_categories pivot just in case
DB::table('product_categories')->truncate();
echo "Product-Category mappings cleared.\n";

// Enable foreign key checks
DB::statement('SET FOREIGN_KEY_CHECKS=1;');

// Clear caches
Artisan::call('cache:clear');
Artisan::call('config:clear');

echo "Database wiped clean of categories.\n";
