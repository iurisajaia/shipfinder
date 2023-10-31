<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Carrgo\CreateBidRequest;
use App\Http\Requests\Carrgo\CreateCarrgoRequest;
use App\Http\Requests\Carrgo\ResponseBidRequest;
use App\Repositories\Interfaces\CargoRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    private CargoRepositoryInterface $cargoRepository;

    public function __construct(
        CargoRepositoryInterface $cargoRepository,
    ){
        $this->cargoRepository = $cargoRepository;
    }


    public function getMyCargos(Request $request){
        return $this->cargoRepository->getMyCargos($request);
    }

    public function index(){
        return $this->cargoRepository->index();
    }

    public function getPackageTypes(): JsonResponse{
        return $this->cargoRepository->getPackageTypes();
    }

    public function getDangerStatuses(): JsonResponse{
        return $this->cargoRepository->getDangerStatuses();
    }

    public function getUserContacts(Request $request): JsonResponse{
        return $this->cargoRepository->getUserContacts($request);
    }

    public function create(CreateCarrgoRequest $request): JsonResponse {
        return $this->cargoRepository->create($request);
    }

    public function createBid(CreateBidRequest $request) : JsonResponse{
        return $this->cargoRepository->createBid($request);
    }

    public function responseBid(ResponseBidRequest $request) : JsonResponse{
        return $this->cargoRepository->responseBid($request);
    }



}
