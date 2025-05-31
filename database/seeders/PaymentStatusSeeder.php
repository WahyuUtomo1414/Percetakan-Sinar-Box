<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\StatusType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $listStatusType = [
            "id" => 4,
            "name" => "Payment Status",
            "desc" => "New status",
            "active" => 1,
        ];
        StatusType::insert($listStatusType);

        $listStatus = [
            [
                'id' => 13,
                'status_type_id' => 4,
                'name' => 'PENDING',
                "desc" => 'Status for pending',
                'active' => true,
            ],
            [
                'id' => 14,
                'status_type_id' => 3,
                'name' => 'CONFIRMED',
                "desc" => 'Status for confirmed',
                'active' => true,
            ],
            [
                'id' => 15,
                'status_type_id' => 4,
                'name' => 'FAILED',
                "desc" => 'Status for failed',
                'active' => true,
            ],
        ];
        Status::insert($listStatus);
    }
}
