<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Car\CreateCarRequest;
use App\Models\CarBodyType;
use App\Models\CarLoadingType;
use App\Models\CarTrailerType;
use App\Repositories\Interfaces\CarRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarController extends Controller
{
    private CarRepositoryInterface $carRepository;

    public function __construct(
        CarRepositoryInterface $carRepository,
    ){
        $this->carRepository = $carRepository;
    }


    public function create(CreateCarRequest $request){
        return $this->carRepository->create($request);
    }

    public function getCarBodyTypes(): JsonResponse {
        return response()->json(['data' => CarBodyType::all()], 200);
    }

    public function getCarTrailerTypes(): JsonResponse {
        return response()->json(['data' => CarTrailerType::all()], 200);
    }

    public function getCarLoadingTypes(): JsonResponse {
        return response()->json(['data' => CarLoadingType::all()], 200);
    }





}
