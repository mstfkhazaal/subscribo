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
        Currency::upsert([
            [
                'currency_code' => 'USD',
                'currency_name' => json_encode(['en' => 'US Dollar', 'ar' => 'الدولار الأمريكي']),
                'symbol' => '$',
            ],
            [
                'currency_code' => 'EUR',
                'currency_name' => json_encode(["en"=> "Euro", "ar"=> "اليورو"]),
                'symbol' => '€',
            ],
            [
                'currency_code' => 'LBP',
                'currency_name' => json_encode(["en"=> "Lebanese Pound", "ar"=> "ليرة لبناني"]),
                'symbol' => 'LBP',
            ],
            [
                'currency_code' => 'RMB',
                'currency_name' => json_encode(["ar"=> "يوان", "en"=> "Yuan"]),
                'symbol' => '¥',
            ],

        ],['currency_code','currency_name','symbol']);
    }
}
