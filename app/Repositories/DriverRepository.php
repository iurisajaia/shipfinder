<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Driver;
use App\Enums\UserRolesEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Driver\CreateDriverRequest;
use App\Repositories\Interfaces\DriverRepositoryInterface;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;


class DriverRepository implements  DriverRepositoryInterface {

    private RoleRepositoryInterface $roleRepository;
    private MediaRepositoryInterface $mediaRepository;

    public function __construct(
        RoleRepositoryInterface $roleRepository,
        MediaRepositoryInterface $mediaRepository
    )
    {
        $this->roleRepository = $roleRepository;
        $this->mediaRepository = $mediaRepository;
    }


    public function saveDriverImages($request, $driver){
        if(isset($request->driver_passport)){
                $this->mediaRepository->addSingleImageToModel($request, $driver, 'driver_passport');
        }
        if(isset($request->drivers_license)){
                $this->mediaRepository->addSingleImageToModel($request, $driver, 'drivers_license');
        }
    }

    public function create(CreateDriverRequest $request) : JsonResponse{
        try {

            $existingDriver = User::where('phone' , $request->phone)->first();
            if($existingDriver) return response()->json(['error' => 'Driver already exists with this phone number'], 500);

            $driverData = $request->only(['room', 'series', 'issued_by', 'serial_number']);
            $userData = $request->only(['name', 'lastname', 'phone']);

            // create new user
            $user = $this->createUser($userData);

            // create driver
            $dateOfIssue = Carbon::createFromFormat('d/m/Y', $request->date_of_issue);
            $driver = new Driver([
                ...$driverData,
                'date_of_issue' => $dateOfIssue,
                'user_id' => $user->id,
                'carrier_id' => $request->user()->id
            ]);
            $driver->save();
            $this->saveDriverImages($request, $driver);


            return response()->json(['driver' => $driver, 'message' => 'Driver created successfully'], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function createUser($userData): User{
        $temporaryPassword = '12345678'; //Str::random(8);

        $user = new User([
            ...$userData,
            'password' => Hash::make($temporaryPassword)
        ]);
        $user->save();

        $this->roleRepository->attach(UserRolesEnum::DRIVER->value, $user);

        //TODO: send temporary password to driver

        return $user;
    }


}
