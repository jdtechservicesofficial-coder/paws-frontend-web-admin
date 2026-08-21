<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

// Configure pawf connection
Config::set('database.connections.pawf', [
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => 'pawf',
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'strict' => true,
    'engine' => null,
]);

$pawf = DB::connection('pawf');

// Copy frontends
$frontends = $pawf->table('frontends')->get();
foreach ($frontends as $row) {
    DB::table('frontends')->updateOrInsert(['id' => $row->id], (array)$row);
}
echo "Copied frontends\n";

// Copy extensions if they exist in pawf, but wait, extensions table doesn't exist in pawandpaws!
// We need to create it!
if (!\Illuminate\Support\Facades\Schema::hasTable('extensions')) {
    DB::statement('CREATE TABLE extensions LIKE pawf.extensions');
    $extensions = $pawf->table('extensions')->get();
    foreach ($extensions as $row) {
        DB::table('extensions')->insert((array)$row);
    }
    echo "Copied extensions\n";
}

// Copy languages if needed
$languages = $pawf->table('languages')->get();
foreach ($languages as $row) {
    DB::table('languages')->updateOrInsert(['id' => $row->id], (array)$row);
}
echo "Copied languages\n";

// We don't overwrite general_settings because we might break the admin, but we can copy missing columns or rows?
// Actually, general_settings only has 1 row with id=1 usually.
// Let's just update the frontend-specific columns in general_settings
$pawf_gs = $pawf->table('general_settings')->first();
if ($pawf_gs) {
    DB::table('general_settings')->where('id', 1)->update([
        'site_name' => $pawf_gs->site_name ?? 'PlayPaws',
        'base_color' => $pawf_gs->base_color ?? '000000',
        'secondary_color' => $pawf_gs->secondary_color ?? '000000',
    ]);
}

echo "Done.";
