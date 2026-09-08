<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();
echo \Modules\Product\Models\Product::where('status', 0)->count();
echo "\n";
$p = \Modules\Product\Models\Product::where('status', 0)->first();
if ($p) {
    echo "ID: " . $p->id . "\n";
    echo "Created By: " . $p->created_by . "\n";
    echo "Has categories: " . $p->categories()->count() . "\n";
}
