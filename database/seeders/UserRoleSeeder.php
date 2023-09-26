<?php

namespace Database\Seeders;

use App\Enums\UserRolesEnum;
use App\Models\Role;
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
                    'id' => UserRolesEnum::CARRIER_LEGAL,
                    'title' => [
                        'eng' => 'Carrier Legal'
                    ],
                    'key' => 'carrier_carrier',
                    'is_visible' => true
                ],
                [
                    'id' => UserRolesEnum::DRIVER,
                    'title' => [
                        'eng' => 'Carrier Physical'
                    ],
                    'key' => 'carrier_physical',
                    'is_visible' => true
                ],
                [
                    'id' => UserRolesEnum::SHIPPER_LEGAL,
                    'title' => [
                        'eng' => 'Shipper Legal'
                    ],
                    'key' => 'shipper_legal',
                    'is_visible' => true
                ],
                [
                    'id' => UserRolesEnum::SHIPPER_PHYSICAL,
                    'title' => [
                        'eng' => 'Shipper Physical'
                    ],
                    'key' => 'shipper_physical',
                    'is_visible' => true
                ],
                [
                    'id' => UserRolesEnum::ADMINISTRATOR,
                    'title' => [
                        'eng' => 'Administrator',
                    ],
                    'key' => 'administrator',
                    'is_visible' => false
                ],
                [
                    'id' => UserRolesEnum::MODERATOR,
                    'title' => [
                        'eng' => 'Moderator',
                    ],
                    'key' => 'moderator',
                    'is_visible' => false
                ],
            ];

            foreach ($userTypes as $type){
                Role::create([
                    'title' => $type['title'],
                    'key' => $type['key'],
                    'is_visible' => $type['is_visible']
                ]);
            }
        }
    }
}
