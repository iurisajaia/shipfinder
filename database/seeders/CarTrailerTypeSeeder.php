<?php

namespace Database\Seeders;

use App\Models\CarTrailerType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarTrailerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('car_trailer_types')->count()){
            $types = [
                'Semitrailer',
                'Truck',
                'Coupling'
            ];

            foreach ($types as $type){
                CarTrailerType::create([
                    'title' => $type
                ]);
            }
        }
    }
}
