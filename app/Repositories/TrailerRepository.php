<?php

namespace App\Repositories;

use App\Models\Trailer;
use App\Models\TrailerType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Trailer\CreateTrailerRequest;
use App\Repositories\Interfaces\TrailerRepositoryInterface;


class TrailerRepository implements TrailerRepositoryInterface
{

    public function getTrailerTypes(): JsonResponse
    {
        try {
            return response()->json([
                'data' => TrailerType::query()->orderByDesc('id')->get()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function index(Request $request): JsonResponse{
        try {
            $trailers = Trailer::query()
                ->where('user_id', $request->user()->id)
                ->orderByDesc('id')
                ->get();

            return response()->json([
                'data' => $trailers
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function create(CreateTrailerRequest $request): JsonResponse
    {
        try {
            $trailer = new Trailer([
                ...$request->all(),
                'user_id' => $request->user()->id
            ]);
            $trailer->save();


            return response()->json([
                'data' => $trailer
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }


}
