<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$s = \App\Models\Frontend::where('data_keys', 'seo.data')->first();
$d = (array)$s->data_values;
$d['description'] = 'Pet care solution';
$d['keywords'] = ['pet'];
$d['image_size'] = '600x400';
$s->data_values = $d;
$s->save();

$p = \App\Models\Page::where('slug', '/')->first();
$p->secs = json_encode(['about', 'services']);
$p->save();

echo "fixed";
