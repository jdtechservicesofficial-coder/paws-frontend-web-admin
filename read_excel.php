<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Maatwebsite\Excel\Facades\Excel;

$file = 'C:\Users\USER\Downloads\pawlly-232\codecanyon-48285200-pawlly-allinone-pet-care-solution-in-flutter-laravel\admin-panel\read\PAW_AND_PAWS_PETSTORE_INVENTORY.xlsx';
try {
    $data = Excel::toArray(new class implements \Maatwebsite\Excel\Concerns\ToArray {
        public function array(array $array) {}
    }, $file);

    file_put_contents('inventory_data.json', json_encode($data[0] ?? []));
    echo "Saved to inventory_data.json";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
