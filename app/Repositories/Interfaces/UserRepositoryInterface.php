<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\CheckUserExistenceRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\GetLoginCodeRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\VerifyUserRequest;
use Illuminate\Http\Request;


Interface UserRepositoryInterface{
    public function getUserRoles();
    public function deleteUser(int $id);
    public function sendSms($code,$number);
    public function currentUser(Request $request);
    public function loginUser(LoginUserRequest $request);
    public function createUser(CreateUserRequest $request);
    public function verifyUser(VerifyUserRequest $request);
    public function getLoginCode(GetLoginCodeRequest $request);
    public function forgotPassword(ForgotPasswordRequest $request);
    public function checkUserExistence(CheckUserExistenceRequest $request);
}
