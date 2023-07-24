<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\Driver\CreateDriverRequest;


Interface DriverRepositoryInterface{
    public function create(CreateDriverRequest $request);
}
