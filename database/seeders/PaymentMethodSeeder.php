<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('payment_methods')->count()){
            $types = [
                [
                    'title' => 'In cash',
                    'key' => 'in_cash'
                ],
                [
                    'title' => 'Non-cash rate with VAT',
                    'key' => 'non_cash_rate_with_vat'
                ],
                [
                    'title' => 'Non-cash rate without VAT',
                    'key' => 'non_cash_rate_without_vat'
                ]

            ];

            foreach ($types as $type){
                PaymentMethod::create([
                    'title' => $type['title'],
                    'key' => $type['key']
                ]);
            }
        }
    }
}
