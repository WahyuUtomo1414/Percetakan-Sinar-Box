<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                "id" => 1,
                'name' => 'Admin',
                'email' => "admin@gmail.com",
                'password' => bcrypt('12345678'),
                'phone_number' => '08123456789',
                'address' => 'Jl. Raya No. 1, Jakarta',
                'role_id' => 1,
                'status_id' => 1,         
            ],
            [
                "id" => 2,
                'name' => 'Wahyu Tomo',
                'email' => "doctor@gmail.com",
                'password' => bcrypt('12345678'),
                'phone_number' => '08123456789',
                'address' => 'Jl. Raya No. 1, Jakarta',
                'role_id' => 2,
                'status_id' => 1,
            ],
        ];
        User::insert($user);
    }
}
