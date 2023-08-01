<?php

namespace App\Repositories;
use App\Http\Requests\Driver\CreateDriverRequest;
use App\Models\DriverInfo;
use App\Models\User;
use App\Models\UserRole;
use App\Repositories\Interfaces\DriverRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DriverRepository implements  DriverRepositoryInterface {

    public function createUser($userData, $driver, $request){
        $driverRole = UserRole::where('key', 'driver')->first();
        $temporaryPassword = '12345678'; //Str::random(8);

        $user = new User([
            ...$userData,
            'password' => Hash::make($temporaryPassword),
            'driver_info_id' => $driver->id,
            'carrier_id' => $request->user()->id,
            'user_role_id' => $driverRole->id ?? 4
        ]);
        $user->save();
        //TODO: send temporary password to driver
    }

    public function saveDriverImages($request, $driver){
        if(isset($request->driver_passport)){
            $existingMedia = $driver->getMedia('driver_passport')->first();
            if ($existingMedia) {
                $existingMedia->delete();
            }
            $driver->addMediaFromRequest('driver_passport')->toMediaCollection('driver_passport');
        }
        if(isset($request->drivers_license)){
            $existingMedia = $driver->getMedia('drivers_license')->first();
            if ($existingMedia) {
                $existingMedia->delete();
            }
            $driver->addMediaFromRequest('drivers_license')->toMediaCollection('drivers_license');
        }
    }

    public function create(CreateDriverRequest $request) : JsonResponse{
        try {

            $existingDriver = User::where('phone' , $request->phone)->first();

            if($existingDriver) return response()->json(['error' => 'Driver already exists with this phone number'], 500);

            $driverData = $request->only(['room', 'series', 'issued_by', 'date_of_issue', 'serial_number']);
            $userData = $request->only(['firstname', 'lastname', 'phone']);

            // create driver info
            $driver = new DriverInfo($driverData);
            $driver->save();
            $this->saveDriverImages($request, $driver);

            // create new user
            $this->createUser($userData, $driver , $request);


            return response()->json(['driver' => $driver, 'message' => 'Driver created successfully'], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }


}
