<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Carrgo\CreateCarrgoRequest;
use App\Repositories\Interfaces\CarrgoRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarrgoController extends Controller
{
    private CarrgoRepositoryInterface $carrgoRepository;

    public function __construct(
        CarrgoRepositoryInterface $carrgoRepository,
    ){
        $this->carrgoRepository = $carrgoRepository;
    }

    public function index(){
        return $this->carrgoRepository->index();
    }

    public function create(CreateCarrgoRequest $request): JsonResponse {
        return $this->carrgoRepository->create($request);
    }

    public function getPackageTypes(): JsonResponse{
        return $this->carrgoRepository->getPackageTypes();
    }
    public function getUserContacts(Request $request): JsonResponse{
        return $this->carrgoRepository->getUserContacts($request);
    }

}
