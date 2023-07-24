<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentMethodsController extends Controller
{
    public function index(): JsonResponse {
        return response()->json(['data' => PaymentMethod::all()], 200);
    }
}
