<?php

namespace Database\Seeders;

use App\Models\Shiping;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShipingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shipping = [
            [
                'name' => 'JNE',
                'desc' => '',
                'price' => 12000,
                'status_id' => 1,
            ],
            [
                'name' => 'JNT',
                'desc' => '',
                'price' => 15000,
                'status_id' => 1,
            ],
            [
                'name' => 'POS Indonesia',
                'desc' => '',
                'price' => 10000,
                'status_id' => 1,
            ],
            [
                'name' => 'Gojek',
                'desc' => '',
                'price' => 20000,
                'status_id' => 1,
            ],
            [
                'name' => 'Grab',
                'desc' => '',
                'price' => 20000,
                'status_id' => 1,
            ],
            [
                'name' => 'SiCepat',
                'desc' => '',
                'price' => 15000,
                'status_id' => 1,
            ],
        ];
        Shiping::insert($shipping);
    }
}
