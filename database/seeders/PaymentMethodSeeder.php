<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'name' => 'BRI',
                'logo' => 'bri.png',
                'account_number' => '1234567890',
                'account_name' => 'Abdul Somad',
                'payment_procedures' => '.',
                'status_id' => 1,
            ],
            [
                'name' => 'BCA',
                'logo' => 'bca.png',
                'account_number' => '0987654321',
                'account_name' => 'Abdul Somad',
                'payment_procedures' => '.',
                'status_id' => 1,
            ],
            [
                'name' => 'Mandiri',
                'logo' => 'mandiri.png',
                'account_number' => '1122334455',
                'account_name' => 'Abdul Somad',
                'payment_procedures' => '.',
                'status_id' => 1,
            ],
            [
                'name' => 'OVO',
                'logo' => 'ovo.png',
                'account_number' => '08123456789',
                'account_name' => 'Abdul Somad',
                'payment_procedures' => '.',
                'status_id' => 1,
            ],
            [
                'name' => 'DANA',
                'logo' => 'dana.png',
                'account_number' => '08123456789',
                'account_name' => 'Abdul Somad',
                'payment_procedures' => '.',
                'status_id' => 1,
            ],
        ];

        PaymentMethod::insert($paymentMethods);
    }
}
