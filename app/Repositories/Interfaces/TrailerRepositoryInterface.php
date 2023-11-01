<?php

namespace App\Repositories\Interfaces;


use App\Http\Requests\Car\CreateCarRequest;
use App\Http\Requests\Trailer\CreateTrailerRequest;
use Illuminate\Http\Request;


Interface TrailerRepositoryInterface{
    public function getTrailerTypes();
    public function index(Request $request);
    public function create(CreateTrailerRequest $request);
}
