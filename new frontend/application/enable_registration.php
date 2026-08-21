<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$gs = App\Models\GeneralSetting::first();
$gs->registration = 1;
$gs->save();
echo "Registration Enabled: " . $gs->registration;
