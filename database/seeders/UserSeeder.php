<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'user_status'=> 2,
                'password' => Hash::make('123456789'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'user_status'=> 2,
                'password' => Hash::make('123456789'),
                'remember_token' => Str::random(10),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
