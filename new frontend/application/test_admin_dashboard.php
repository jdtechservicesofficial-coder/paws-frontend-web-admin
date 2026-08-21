<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/admin/dashboard', 'GET');
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
Illuminate\Support\Facades\Auth::guard('admin')->loginUsingId(1);
$response = $kernel->handle($request);
echo $response->status();
if ($response->status() == 500) {
    echo "\n";
    echo $response->getContent();
}
