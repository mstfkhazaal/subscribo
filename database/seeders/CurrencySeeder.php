<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'currency_code' => 'USD',
                'currency_name' => '{"ar": "الدولار الأمريكي", "en": "US Dollar"}',
                'symbol' => '$',
            ],
            [
                'currency_code' => 'EUR',
                'currency_name' => '{"en": "Euro", "ar": "اليورو"}',
                'symbol' => '€',
            ],
            [
                'currency_code' => 'LBP',
                'currency_name' => '{"en": "Lebanese Pound", "ar": "ليرة لبناني"}',
                'symbol' => 'LBP',
            ],
        ];
        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
