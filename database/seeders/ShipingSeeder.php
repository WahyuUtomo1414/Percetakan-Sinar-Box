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
                'desc' => 'Delivery within 5-7 business days',
                'price' => 12000,
                'status_id' => 1,
            ],
            [
                'name' => 'JNT',
                'desc' => 'Delivery within 3-5 business days',
                'price' => 15000,
                'status_id' => 1,
            ],
            [
                'name' => 'POS Indonesia',
                'desc' => 'Delivery within 7-10 business days',
                'price' => 10000,
                'status_id' => 1,
            ],
            [
                'name' => 'Gojek',
                'desc' => 'Delivery within 1-2 business days',
                'price' => 20000,
                'status_id' => 1,
            ],
            [
                'name' => 'Grab',
                'desc' => 'Delivery within 1-2 business days',
                'price' => 20000,
                'status_id' => 1,
            ],
            [
                'name' => 'SiCepat',
                'desc' => 'Delivery within 1-2 business days',
                'price' => 15000,
                'status_id' => 1,
            ],
        ];
        Shiping::insert($shipping);
    }
}
