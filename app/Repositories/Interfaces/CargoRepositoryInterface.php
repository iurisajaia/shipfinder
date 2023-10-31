<?php

namespace App\Repositories\Interfaces;


use App\Http\Requests\Carrgo\CreateBidRequest;
use App\Http\Requests\Carrgo\CreateCarrgoRequest;
use App\Http\Requests\Carrgo\ResponseBidRequest;
use Illuminate\Http\Request;

Interface CargoRepositoryInterface{
    public function index();
    public function getMyCargos(Request $request);
    public function getPackageTypes();
    public function create(CreateCarrgoRequest $request);
    public function getUserContacts(Request $request);
    public function getDangerStatuses();
    public function createBid(CreateBidRequest $request);
    public function responseBid(ResponseBidRequest $request);


}
