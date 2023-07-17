<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('user_roles')->count()){
            $userTypes = [
                [
                    'id' => 1,
                    'title' => [
                        'eng' => 'Carrier Legal'
                    ],
                    'key' => 'carrier_carrier',
                    'is_visible' => true
                ],
                [
                    'id' => 2,
                    'title' => [
                        'eng' => 'Carrier Physical'
                    ],
                    'key' => 'carrier_physical',
                    'is_visible' => true
                ],
                [
                    'id' => 3,
                    'title' => [
                        'eng' => 'Shipper Legal'
                    ],
                    'key' => 'shipper_legal',
                    'is_visible' => true
                ],
                [
                    'id' => 4,
                    'title' => [
                        'eng' => 'Shipper Physical'
                    ],
                    'key' => 'shipper_physical',
                    'is_visible' => true
                ],
                [
                    'id' => 6,
                    'title' => [
                        'eng' => 'Administrator',
                    ],
                    'key' => 'administrator',
                    'is_visible' => false
                ],
                [
                    'id' => 7,
                    'title' => [
                        'eng' => 'Moderator',
                    ],
                    'key' => 'moderator',
                    'is_visible' => false
                ],


            ];

            foreach ($userTypes as $type){
                UserRole::create([
                    'title' => $type['title'],
                    'key' => $type['key'],
                    'is_visible' => $type['is_visible']
                ]);
            }
        }
    }
}
