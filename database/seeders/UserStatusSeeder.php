<?php

namespace Database\Seeders;

use App\Models\UserStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserStatus::create([
            'id' => 1,
            "code" => "PND",
            "variant" => "info",
            'name' => '{"en":"Pending","ar":"قيد الانشاء"}'
        ]);
        UserStatus::create([
            'id' => 2,
            "code" => "ACT",
            "variant" => "success",
            'name' => '{"en":"Active","ar":"مفعل"}'
        ]);
        UserStatus::create([
            'id' => 3,
            "code" => "NACT",
            "variant" => "warning",
            'name' => '{"en":"Not Active","ar":"غير مفعل"}'
        ]);
        UserStatus::create([
            'id' => 4,
            "code" => "BLOCK",
            "variant" => "danger",
            'name' => '{"en":"Blocked","ar":"محظور"}'
        ]);
        UserStatus::create([
            'id' => 5,
            "code" => "DELT",
            "variant" => "danger",
            'name' => '{"en":"Deleted","ar":"محذوف"}'
        ]);
        UserStatus::create([
            'id' => 6,
            "code" => "PAUS",
            "variant" => "warning",
            'name' => '{"en":"Paused","ar":"متوقف"}'
        ]);
    }
}
