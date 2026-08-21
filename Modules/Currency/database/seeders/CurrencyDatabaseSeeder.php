<?php

namespace Modules\Currency\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Currency\Models\Currency;

class CurrencyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $data = [
            [
                'currency_name' => 'US Dollar',
                'currency_symbol' => '$',
                'currency_code' => 'USD',
                'currency_position' => 'left',
                'no_of_decimal' => 2,
                'thousand_separator' => ',',
                'decimal_separator' => '.',
                'is_primary' => 1,
            ],
            [
                'currency_name' => 'Euro',
                'currency_symbol' => '€',
                'currency_code' => 'EUR',
                'currency_position' => 'left',
                'no_of_decimal' => 2,
                'thousand_separator' => '.',
                'decimal_separator' => ',',
                'is_primary' => 0,
            ],
            [
                'currency_name' => 'British Pound',
                'currency_symbol' => '£',
                'currency_code' => 'GBP',
                'currency_position' => 'left',
                'no_of_decimal' => 2,
                'thousand_separator' => ',',
                'decimal_separator' => '.',
                'is_primary' => 0,
            ],
            [
                'currency_name' => 'Nigerian Naira',
                'currency_symbol' => '₦',
                'currency_code' => 'NGN',
                'currency_position' => 'left',
                'no_of_decimal' => 2,
                'thousand_separator' => ',',
                'decimal_separator' => '.',
                'is_primary' => 0,
            ],
            [
                'currency_name' => 'Indian Rupee',
                'currency_symbol' => '₹',
                'currency_code' => 'INR',
                'currency_position' => 'left',
                'no_of_decimal' => 2,
                'thousand_separator' => ',',
                'decimal_separator' => '.',
                'is_primary' => 0,
            ],
            [
                'currency_name' => 'Canadian Dollar',
                'currency_symbol' => '$',
                'currency_code' => 'CAD',
                'currency_position' => 'left',
                'no_of_decimal' => 2,
                'thousand_separator' => ',',
                'decimal_separator' => '.',
                'is_primary' => 0,
            ],
            [
                'currency_name' => 'Australian Dollar',
                'currency_symbol' => '$',
                'currency_code' => 'AUD',
                'currency_position' => 'left',
                'no_of_decimal' => 2,
                'thousand_separator' => ',',
                'decimal_separator' => '.',
                'is_primary' => 0,
            ],
            [
                'currency_name' => 'South African Rand',
                'currency_symbol' => 'R',
                'currency_code' => 'ZAR',
                'currency_position' => 'left',
                'no_of_decimal' => 2,
                'thousand_separator' => ',',
                'decimal_separator' => '.',
                'is_primary' => 0,
            ],
            [
                'currency_name' => 'UAE Dirham',
                'currency_symbol' => 'د.إ',
                'currency_code' => 'AED',
                'currency_position' => 'left',
                'no_of_decimal' => 2,
                'thousand_separator' => ',',
                'decimal_separator' => '.',
                'is_primary' => 0,
            ],
        ];

        foreach ($data as $value) {
            Currency::updateOrCreate(
                ['currency_code' => $value['currency_code']],
                $value
            );
        }

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
