<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Enums\UserRolesEnum;
use App\Repositories\Interfaces\RoleRepositoryInterface;



class RoleRepository implements  RoleRepositoryInterface {


    public function attach(int $roleId, User $user){
        $role = Role::find($roleId);
        $user->roles()->attach($role);
    }

    public function detach(int $roleId, User $user){
        $role = Role::find($roleId);
        $user->roles()->detach($role);
    }

    public function getRelationsByUserId(int $userId): array{
        $user = User::query()->with('roles')->find($userId);

        $roles = $user->roles->pluck('id')->toArray();

        if(in_array(UserRolesEnum::CARRIER_LEGAL->value, $roles)) return ['drivers', 'drivers.user', 'drivers.media'];

        return [];
    }


}
