<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\CheckUserExistenceRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\GetLoginCodeRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Models\User;
use Illuminate\Http\Request;


Interface RoleRepositoryInterface{
    public function attach(int $roleId, User $user);
    public function detach(int $roleId, User $user);
    public function getRelationsByUserId(int $userId);
}
