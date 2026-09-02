<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$c1 = \App\Models\Category::where('id', 2)->first();
if($c1){
    $c1->name = 'Dog Can Food';
    $c1->save();
}

$c2 = \App\Models\Category::where('id', 6)->first();
if($c2){
    $c2->name = 'Cat Can Food';
    $c2->save();
}

$c3 = \App\Models\Category::where('id', 7)->first();
if($c3){
    $c3->name = 'Cat Dry Food';
    $c3->save();
}

echo "Done\n";
