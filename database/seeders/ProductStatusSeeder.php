<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\StatusType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $listStatusType = [
            "id" => 2,
            "name" => "Product Status",
            "desc" => "New status",
            "active" => 1,
        ];
        StatusType::insert($listStatusType);

        $listStatus = [
            [
                'id' => 4,
                'status_type_id' => 2,
                'name' => 'READY',
                "desc" => 'Status for ready',
                'active' => true,
            ],
            [
                'id' => 5,
                'status_type_id' => 2,
                'name' => 'NOT_STOCK',
                "desc" => 'Status for non stock',
                'active' => true,
            ],
            [
                'id' => 6,
                'status_type_id' => 2,
                'name' => 'DISCONTINUED',
                "desc" => 'Status for discontinued',
                'active' => true,
            ],
        ];
        Status::insert($listStatus);
    }
}
