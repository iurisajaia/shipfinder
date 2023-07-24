<?php

namespace Database\Seeders;

use App\Models\CarLoadingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarLoadingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('car_loading_types')->count()){
            $types = [
                'Upper',
                'Lateral',
                'Back',
                'With Full Cover',
                'With the removal of the crossbars',
                'With the removal of tracks',
                'No gate',
                'Tall lift',
                'With sides',
                'Lateral from 2 sides'
            ];

            foreach ($types as $type){
                CarLoadingType::create([
                    'title' => $type
                ]);
            }
        }
    }
}
