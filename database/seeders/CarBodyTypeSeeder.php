<?php

namespace Database\Seeders;

use App\Models\CarBodyType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarBodyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('car_body_types')->count()){
            $types = [
                'Ground',
                'Conteinter',
                'Freight carrier',
                'Aerial',
                'Scooter Deliver',
                'Trailers',
                'Deliver express'
            ];

            foreach ($types as $type){
                CarBodyType::create([
                    'title' => $type
                ]);
            }
        }
    }
}
