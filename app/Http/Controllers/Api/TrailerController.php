<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trailer\CreateTrailerRequest;
use App\Repositories\Interfaces\TrailerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrailerController extends Controller
{

    private TrailerRepositoryInterface $trailerRepository;

    public function __construct(TrailerRepositoryInterface $trailerRepository)
    {
        $this->trailerRepository = $trailerRepository;
    }

    public function index(Request $request){
        return $this->trailerRepository->index($request);
    }

    public function create(CreateTrailerRequest $request){
        return $this->trailerRepository->create($request);
    }

    public function getTrailerTypes(): JsonResponse{
        return $this->trailerRepository->getTrailerTypes();
    }
}
