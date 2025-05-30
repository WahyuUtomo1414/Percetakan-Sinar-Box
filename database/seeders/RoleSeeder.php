<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'Admin',
                'desc' => 'Administrator with full access',
                'status_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'CUSTOMER',
                'desc' => 'Custome with limited access',
                'status_id' => 1,
            ],
        ];

        Role::insert($roles);
    }
}
