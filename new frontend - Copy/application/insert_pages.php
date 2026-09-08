<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$about = App\Models\Page::where('slug', 'about')->first();
if (!$about) {
    $about = new App\Models\Page();
    $about->slug = 'about';
}
$about->name = 'About';
$about->tempname = 'templates.basic.';
$about->secs = '["about","testimonial"]';
$about->save();

$pricing = App\Models\Page::where('slug', 'pricing')->first();
if (!$pricing) {
    $pricing = new App\Models\Page();
    $pricing->slug = 'pricing';
}
$pricing->name = 'Pricing';
$pricing->tempname = 'templates.basic.';
$pricing->secs = '["packages"]';
$pricing->save();

echo "Done.";
