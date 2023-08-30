<?php

namespace Database\Seeders;

use App\Models\PackageType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('package_types')->count()){
            $types = [
                'Standard cargo',
                'Boxes',
                'Transit',
                'Container',
                'Liquid'
            ];

            foreach ($types as $type){
                PackageType::create([
                    'title' => $type
                ]);
            }
        }
    }
}
