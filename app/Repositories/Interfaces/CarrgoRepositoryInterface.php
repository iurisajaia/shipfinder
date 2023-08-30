<?php

namespace App\Repositories\Interfaces;


use App\Http\Requests\Carrgo\CreateCarrgoRequest;

Interface CarrgoRepositoryInterface{
    public function index();
    public function getPackageTypes();
    public function create(CreateCarrgoRequest $request);
}
