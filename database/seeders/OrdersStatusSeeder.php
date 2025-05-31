<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\StatusType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrdersStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $listStatusType = [
            "id" => 3,
            "name" => "Order Status",
            "desc" => "New status",
            "active" => 1,
        ];
        StatusType::insert($listStatusType);

        $listStatus = [
            [
                'id' => 7,
                'status_type_id' => 3,
                'name' => 'PENDING',
                "desc" => 'Status for pending',
                'active' => true,
            ],
            [
                'id' => 8,
                'status_type_id' => 3,
                'name' => 'CONFIRMED',
                "desc" => 'Status for confirmed',
                'active' => true,
            ],
            [
                'id' => 9,
                'status_type_id' => 3,
                'name' => 'SHIPPED',
                "desc" => 'Status for shipped',
                'active' => true,
            ],
            [
                'id' => 10,
                'status_type_id' => 3,
                'name' => 'SHIPPED',
                "desc" => 'Status for shipped',
                'active' => true,
            ],
            [
                'id' => 11,
                'status_type_id' => 3,
                'name' => 'DELIVERED',
                "desc" => 'Status for delivered',
                'active' => true,
            ],
            [
                'id' => 12,
                'status_type_id' => 3,
                'name' => 'CANCELED',
                "desc" => 'Status for canceled',
                'active' => true,
            ],
        ];
        Status::insert($listStatus);

    }
}
