<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$carts = \Modules\Product\Models\Cart::where('user_id', 341)->get();
echo "Total Carts: " . count($carts) . "\n";
foreach ($carts as $cart) {
    $product = $cart->product;
    echo "Cart ID: " . $cart->id . "\n";
    if (!$product) {
        echo "Product is NULL\n";
    } else {
        echo "Product ID: " . $product->id . ", has_variation: " . $product->has_variation . "\n";
        echo "Cart product_variation_id: " . $cart->product_variation_id . "\n";
        if (!$cart->product_variation) {
            echo "Cart product_variation is NULL\n";
        } else {
            echo "Cart product_variation exists! ID: " . $cart->product_variation->id . "\n";
        }
    }
}
