<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/api/get-product-list?is_admin=1', 'GET');
$app->instance('request', $request);
$kernel->bootstrap();

$req = app('request');
var_dump($req->is_admin);
var_dump($req->is_admin != 1);
var_dump(!$req->has('is_admin') || $req->is_admin != 1);
