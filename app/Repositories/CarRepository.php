<?php

namespace App\Repositories;

use App\Models\Car;
use App\Models\CarBodyType;
use App\Models\CarLoadingType;
use App\Models\Dimension;
use App\Repositories\Interfaces\CarRepositoryInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Car\CreateCarRequest;
use Illuminate\Http\Request;


class CarRepository implements CarRepositoryInterface
{

    public function getCarBodyTypes(): JsonResponse
    {
        $carBodyTypes = CarBodyType::query()->orderByDesc('id')->get();
        return response()->json(['data' => $carBodyTypes], 200);
    }

    public function getCarLoadingTypes(): JsonResponse
    {
        $carLoadingTypes = CarLoadingType::query()->orderByDesc('id')->get();
        return response()->json(['data' => $carLoadingTypes], 200);
    }

    public function index(Request $request): JsonResponse{
        try {
            $cars = Car::with(
                ['dimension', 'payment_method', 'trailer_type','body_types','loading_types','countries','drivers','drivers.driverInfo']
                )
                ->where('user_id' , $request->user()->id)
                ->orderByDesc('id')
                ->get();

            return response()->json([
                'data' => $cars
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function create(CreateCarRequest $request): JsonResponse
    {
        try {
            $carData = $request->only(['car_body_type_id' , 'payment_method_id', 'model', 'description', 'registration_number', 'danger']);

            $car = new Car([
                ...$carData,
                'user_id' => $request->user()->id
            ]);
            $car->save();

            if(isset($request['drivers']) && count($request['drivers'])){
                $car->drivers()->sync($request['drivers']);
            }
            if(isset($request['body_types']) && count($request['body_types'])){
                $car->body_types()->sync($request['body_types']);
            }
            if(isset($request['loading_types']) && count($request['loading_types'])){
                $car->loading_types()->sync($request['loading_types']);
            }
            if(isset($request['countries']) && count($request['countries'])){
                $car->countries()->sync($request['countries']);
            }
            if(isset($request['trailer_id'])){
                $car->trailer_id = $request['trailer_id'];
                $car->save();
            }



            if (isset($request['dimensions']) && count($request['dimensions'])) {
                $dimension = new Dimension([
                    'length' => $request['dimensions']['length'],
                    'width' => $request['dimensions']['width'],
                    'height' => $request['dimensions']['height'],
                    'volume' => $request['dimensions']['volume'],
                    'capacity' => $request['dimensions']['capacity'],
                    'car_id' => $car->id]);
                $dimension->save();
            }


            return response()->json([
                'data' => Car::with(['dimension'])->findOrFail($car->id)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }


}
