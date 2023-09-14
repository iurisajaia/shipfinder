<?php

namespace App\Repositories\Interfaces;


use App\Http\Requests\Carrgo\CreateCarrgoRequest;
use Illuminate\Http\Request;

Interface CarrgoRepositoryInterface{
    public function index();
    public function getPackageTypes();
    public function create(CreateCarrgoRequest $request);
    public function getUserContacts(Request $request);

}
