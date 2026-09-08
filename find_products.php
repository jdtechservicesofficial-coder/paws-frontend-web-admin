<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$items = [
    "Bath brush",
    "Bath glove",
    "3 piece grooming kit",
    "Towels",
    "Grooming bag",
    "Fish toy",
    "Squeaky ball",
    "Squeaky teddy",
    "Shoe toy",
    "Dog maze",
    "Dog smart",
    "Dog brick",
    "Ball pet toy",
    "Cat litter pack",
    "Cat litter packer",
    "Pet bag",
    "Cat litter box small",
    "Cat litter box medium",
    "Cat litter box large",
    "Essential rabbit food",
    "Jojo doggy fresh",
    "Training pad small",
    "Training pad medium",
    "Training pad large",
    "Female dog diaper",
    "Disposable diaper",
    "Dog dress small",
    "Dog dress medium",
    "Dog dress large",
    "Cage size 1",
    "Cage size 2",
    "Cage size 3",
    "Cage size 4",
    "Pet carrier small",
    "Pet carrier large",
    "Cat scratcher",
    "Duplex cage",
    "Up net bed",
    "Water dispenser",
    "Food dispenser",
    "Cat bottles",
    "2 in 1 plate small",
    "2 in 1 plate medium",
    "2 in 1 plate large",
    "Design plate"
];

$results = [];

$products = \Illuminate\Support\Facades\DB::table('products')->get();

foreach ($items as $item) {
    $found = false;
    foreach ($products as $product) {
        if (stripos($product->name, $item) !== false) {
            $results[$item] = $product->id;
            $found = true;
            break;
        }
    }
    if (!$found) {
        $results[$item] = "-";
    }
}

foreach ($results as $item => $id) {
    echo $item . " : " . $id . "\n";
}
