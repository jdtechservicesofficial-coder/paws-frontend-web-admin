<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = \Illuminate\Support\Facades\DB::table('products')->get();
$content = "";
foreach ($products as $p) {
    $content .= $p->id . ' - ' . $p->name . "\n";
}
file_put_contents('all_products_dump.txt', $content);
