<?php

namespace Database\Seeders;

use App\Models\TrailerType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrailerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('trailer_types')->count()){
            $types = [
                'Semitrailer',
                'Truck',
                'Coupling'
            ];

            foreach ($types as $type){
                TrailerType::create([
                    'title' => $type
                ]);
            }
        }
    }
}
