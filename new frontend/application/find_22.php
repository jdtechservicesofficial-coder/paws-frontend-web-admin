<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = \DB::select('SHOW TABLES');
foreach($tables as $t) {
    $table = array_values((array)$t)[0];
    try {
        $count = \DB::table($table)->where('name', '22')->count();
        if($count > 0) {
            echo "Table $table has name = '22'\n";
        }
    } catch(\Exception $e) {}
}
echo "Done\n";
