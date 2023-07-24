<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Driver\CreateDriverRequest;
use App\Repositories\Interfaces\DriverRepositoryInterface;

class DriverController extends Controller
{

    private DriverRepositoryInterface $driverRepository;

    public function __construct(
        DriverRepositoryInterface $driverRepository,
    ){
        $this->driverRepository = $driverRepository;
    }

    public function create(CreateDriverRequest $request) : JsonResponse
    {
        try {
            return $this->driverRepository->create($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
