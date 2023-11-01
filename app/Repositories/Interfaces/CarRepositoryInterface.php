<?php

namespace App\Repositories\Interfaces;


use App\Http\Requests\Car\CreateCarRequest;
use Illuminate\Http\Request;


Interface CarRepositoryInterface{
    public function getCarBodyTypes();
    public function getCarLoadingTypes();
    public function index(Request $request);
    public function create(CreateCarRequest $request);
}
