<?php
define('LARAVEL_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Force the IS_DUMMY_DATA env variable to true so the seeders run
putenv('IS_DUMMY_DATA=true');
$_ENV['IS_DUMMY_DATA'] = 'true';
$_SERVER['IS_DUMMY_DATA'] = 'true';

use Illuminate\Support\Facades\Artisan;
use Modules\World\Models\Country;
use Modules\World\Models\State;
use Modules\World\Models\City;

try {
    echo "Starting Seeding World Module (this might take up to 2 minutes, please do not close the page)...<br>";
    
    // Increase execution time limit for seeding large datasets
    set_time_limit(300);
    ini_set('memory_limit', '512M');

    $exitCode = Artisan::call('db:seed', [
        '--class' => 'Modules\World\database\seeders\WorldDatabaseSeeder',
        '--force' => true
    ]);
    
    if ($exitCode === 0) {
        echo "<h3>Seeding completed successfully!</h3>";
        
        echo "Optimizing database for Nigeria only...<br>";
        
        // 1. Delete all other countries except Nigeria (ID 160)
        $deletedCountries = Country::where('id', '!=', 160)->delete();
        echo "Deleted $deletedCountries other countries.<br>";

        // 2. Delete all other states except Nigeria's states (IDs 2647-2683)
        $deletedStates = State::where('country_id', '!=', 160)->delete();
        echo "Deleted $deletedStates other states.<br>";

        // 3. Clear all old cities
        City::truncate();
        echo "Cleared all old cities.<br>";

        // 4. Seed Nigerian cities
        $nigerianCities = [
            2647 => ['Umuahia', 'Aba', 'Ohafia', 'Arochukwu'], // Abia
            2648 => ['Abuja', 'Garki', 'Wuse', 'Asokoro', 'Maitama', 'Gwarinpa', 'Kubwa'], // FCT
            2649 => ['Yola', 'Mubi', 'Jimeta', 'Numan'], // Adamawa
            2650 => ['Uyo', 'Eket', 'Ikot Ekpene', 'Oron'], // Akwa Ibom
            2651 => ['Awka', 'Onitsha', 'Nnewi', 'Ekwulobia'], // Anambra
            2652 => ['Bauchi', 'Azare', 'Misau', 'Jama\'are'], // Bauchi
            2653 => ['Yenagoa', 'Brass', 'Ogbia', 'Sagbama'], // Bayelsa
            2654 => ['Makurdi', 'Gboko', 'Otukpo', 'Katsina-Ala'], // Benue
            2655 => ['Maiduguri', 'Biu', 'Bama', 'Gwoza'], // Borno
            2656 => ['Calabar', 'Ugep', 'Ogoja', 'Obudu'], // Cross River
            2657 => ['Asaba', 'Warri', 'Sapele', 'Ughelli', 'Agbor'], // Delta
            2658 => ['Abakaliki', 'Afikpo', 'Onueke'], // Ebonyi
            2659 => ['Benin City', 'Uromi', 'Auchi', 'Ekpoma'], // Edo
            2660 => ['Ado Ekiti', 'Ikere Ekiti', 'Oye Ekiti'], // Ekiti
            2661 => ['Enugu', 'Nsukka', 'Oji River', 'Agbani'], // Enugu
            2662 => ['Gombe', 'Kaltungo', 'Dukin', 'Billiri'], // Gombe
            2663 => ['Owerri', 'Orlu', 'Okigwe', 'Mbaise'], // Imo
            2664 => ['Dutse', 'Hadejia', 'Gumel', 'Kazaure'], // Jigawa
            2665 => ['Kaduna', 'Zaria', 'Kafanchan', 'Kagoro'], // Kaduna
            2666 => ['Kano', 'Wudil', 'Gwarzo', 'Dambatta'], // Kano
            2667 => ['Katsina', 'Daura', 'Funtua', 'Malumfashi'], // Katsina
            2668 => ['Birnin Kebbi', 'Argungu', 'Yauri', 'Zuru'], // Kebbi
            2669 => ['Lokoja', 'Okene', 'Kabba', 'Idah'], // Kogi
            2670 => ['Ilorin', 'Offa', 'Omu-Aran', 'Lafiagi'], // Kwara
            2671 => ['Lagos', 'Ikeja', 'Lekki', 'Victoria Island', 'Surulere', 'Yaba', 'Apapa', 'Ikorodu', 'Epe', 'Badagry', 'Ajah'], // Lagos
            2672 => ['Lafia', 'Keffi', 'Akwanga', 'Karu'], // Nassarawa
            2673 => ['Minna', 'Bida', 'Suleja', 'Kontagora'], // Niger
            2674 => ['Abeokuta', 'Ijebu Ode', 'Sagamu', 'Ota', 'Ilaro'], // Ogun
            2675 => ['Akure', 'Ondo City', 'Owo', 'Okitipupa'], // Ondo
            2676 => ['Osogbo', 'Ile-Ife', 'Ilesa', 'Ede'], // Osun
            2677 => ['Ibadan', 'Ogbomosho', 'Oyo Town', 'Seyin'], // Oyo
            2678 => ['Jos', 'Bukuru', 'Pankshin', 'Shendam'], // Plateau
            2679 => ['Port Harcourt', 'Obio-Akpor', 'Bonny Island', 'Ahoada', 'Degema'], // Rivers
            2680 => ['Sokoto', 'Wurno', 'Tambuwal'], // Sokoto
            2681 => ['Jalingo', 'Wukari', 'Bali', 'Gembu'], // Taraba
            2682 => ['Damaturu', 'Gashua', 'Potiskum', 'Nguru'], // Yobe
            2683 => ['Gusau', 'Kaura Namoda', 'Talata Mafara'], // Zamfara
        ];

        $cityCount = 0;
        foreach ($nigerianCities as $stateId => $cities) {
            foreach ($cities as $cityName) {
                City::create([
                    'name' => $cityName,
                    'state_id' => $stateId,
                    'status' => 1
                ]);
                $cityCount++;
            }
        }
        echo "Successfully seeded $cityCount Nigerian cities!<br>";
        echo "<h3>Database successfully optimized for Nigeria!</h3>";
        
    } else {
        echo "<h3>Seeding failed with exit code: $exitCode</h3>";
    }
    echo "Output: <pre>" . Artisan::output() . "</pre>";
} catch (\Exception $e) {
    echo "<h3>Error seeding:</h3> " . $e->getMessage() . "<br>";
}
