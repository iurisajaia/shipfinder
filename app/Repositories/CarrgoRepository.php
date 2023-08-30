<?php

namespace App\Repositories;

use App\Models\Carrgo;
use App\Models\CarrgoDetails;
use App\Models\CarrgoRoute;
use App\Models\Package;
use App\Models\PackageType;
use App\Repositories\Interfaces\CarrgoRepositoryInterface;
use App\Http\Requests\Carrgo\CreateCarrgoRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Car;


class CarrgoRepository implements CarrgoRepositoryInterface
{

    public function index(): JsonResponse{
        return response()->json(['data' => Carrgo::query()->with(['package', 'package.type'])->orderByDesc('id')->get()]);
    }

    public function getPackageTypes(): JsonResponse{
        return response()->json(['data' => PackageType::query()->orderByDesc('id')->get()]);
    }

    public function create(CreateCarrgoRequest $request): JsonResponse
    {
        try {

            // create carrgo
            $carrgo = new Carrgo([...$request->except('package')]);

            $package = new Package([...$request->get('package')]);
            $package->save();

            $carrgo['package_id'] = $package->id;
            $carrgo['user_id'] = $request->user()->id;
            $carrgo->save();



            return response()->json(['message' => 'Carrgo created successfully', 'data' => Carrgo::with(['package', 'package.type'])->findOrFail($carrgo->id)]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }


}
