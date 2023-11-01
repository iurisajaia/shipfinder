<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(): JsonResponse {
        $countries = Country::query()->orderByDesc('id')->get();
        return response()->json(['data' => $countries]);
    }
}
