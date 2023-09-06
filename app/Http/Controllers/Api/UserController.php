<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckUserExistenceRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\GetLoginCodeRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
    ){
        $this->userRepository = $userRepository;
    }

    public function create(CreateUserRequest $request) : JsonResponse
    {
        try {
            return $this->userRepository->createUser($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(CreateUserRequest $request) : JsonResponse
    {
        try {
            return $this->userRepository->updateUser($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function changePassword(UpdateUserPasswordRequest $request) : JsonResponse
    {
        try {
            return $this->userRepository->changePassword($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function delete() : JsonResponse
    {
        try {
            return $this->userRepository->deleteUser();
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function roles() : JsonResponse{
        try {
            return response()->json($this->userRepository->getUserRoles());
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function verify(VerifyUserRequest $request) : JsonResponse
    {
        try {
            return $this->userRepository->verifyUser($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getLoginCode(GetLoginCodeRequest $request) : JsonResponse
    {
        try {
            return $this->userRepository->getLoginCode($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function login(LoginUserRequest $request) : JsonResponse
    {
        try {
            return $this->userRepository->loginUser($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request) : JsonResponse
    {
        try {
            return $this->userRepository->forgotPassword($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function checkUserExistence(CheckUserExistenceRequest $request) : JsonResponse
    {
        try {
            return $this->userRepository->checkUserExistence($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function currentUser(Request $request){
        try {
            return $this->userRepository->currentUser($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
