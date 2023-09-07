<?php

namespace App\Repositories;
use App\Http\Requests\CheckUserExistenceRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Models\PhoneOtp;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Requests\GetLoginCodeRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;
use App\Models\User;



class UserRepository implements  UserRepositoryInterface{


    public function createUser(CreateUserRequest $request) : JsonResponse{

        $user = User::query()->where('phone', $request->phone)->first();
        if($user) return response()->json(['error' => 'User already exists', 401]);

        // check if phone number is verified
        $phoneOtp  = PhoneOtp::where('phone_number', $request->phone)->whereNotNull('verified_at')->first();

        if(!isset($phoneOtp)){
            return response()->json(['error' => 'Phone number is not verified'], 404);
        }

        $user = User::create([
            ...$request->all(),
            'password' => Hash::make($request['password']),
            'phone_verified_at' => now()
        ]);

        $phoneOtp->delete(); // clear Phone Numbers table

        return response()->json([
            'message' => 'User Created Successfully',
            'user' => $user,
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);

    }

    public function updateUser(CreateUserRequest $request) : JsonResponse{

        $data = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'email' => $request->email,
            'user_role_id' => $request->user_role_id
        ];

        $user = User::query()->findOrFail($request->user()->id);
        $user->update(array_filter($data));

        if(isset($request->images)){
            foreach ($request->images as $key => $image){
                if($request->id){
                    $existingMedia = $user->getMedia($image['title'])->first();
                    if ($existingMedia) {
                        $existingMedia->delete();
                    }
                }
                $user->addMediaFromRequest("images.{$key}.uri")->toMediaCollection($image['title']);
            }
        }

        return response()->json([
            'message' => 'User Created Successfully',
            'user' => $user,
        ], 200);

    }
    public function changePassword(UpdateUserPasswordRequest $request) : JsonResponse{

        $user = User::query()->findOrFail($request->user()->id);

        if (!Hash::check($request->input('old_password'), $user->password)) {
            return response()->json(['error' => "Old password doesn't match"]);
        }

        $user->update([
            'password' => Hash::make($request['password'])
        ]);

        return response()->json([
            'message' => 'Password Updated Successfully',
            'user' => $user,
        ], 200);

    }

    public function deleteUser(int $id) : JsonResponse{
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'User deleted successfully', 200]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete user.'], 500);
        }

    }

    public function getLoginCode(GetLoginCodeRequest $request) : JsonResponse{
        $user = User::query()->where('phone', $request->phone)->first();

        if($user) return response()->json(['error' => 'User already exists', 401]);

        $phone = $request->phone;
        $code = 123456; // rand(123456, 999999);

        PhoneOtp::updateOrCreate(['phone_number' => $phone], [
            'phone_number' => $phone,
            'otp' => $code,
            'expire_at' => now()->addMinutes(10)
        ]);

        return response()->json(['message' => 'code sent successfully']);
    }

    public function loginUser(LoginUserRequest $request) : JsonResponse{

        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $user = Auth::user();
            return response()->json([
                'message' => 'User Logged in successfully',
                'user' => $user,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function forgotPassword(ForgotPasswordRequest $request) : JsonResponse{
        $phone = $request->phone;

        $user = User::where('phone', $phone)->first();

        if(!$user) return response()->json(['message' => 'Cannot find user'], 401);

        if(!$user->email) return response()->json(['message' => "User doesn't have an email" ], 401);


        return response()->json(['message' => 'Code sent successfully to ' . $user->email], 200);
    }

    public function checkUserExistence(CheckUserExistenceRequest $request) : JsonResponse{

        $user = User::where('phone', $request->phone)->first();

        if($user) return response()->json(['message' => 'User already exists'], 401);

        return response()->json(['message' => "User doesn't exists, you can use that number"], 200);
    }



    public function verifyUser(VerifyUserRequest $request) : JsonResponse{

        $phoneOtp  = PhoneOtp::where('phone_number', $request->phone)->where('otp', $request->otp)->first();

        if(!isset($phoneOtp)){
            return response()->json(['error' => 'Something went wrong'], 401);
        }

        $this->checkForOtpError($phoneOtp);


        $phoneOtp->update([
            'expire_at' => now(),
            'verified_at' => now(),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Phone verified successfully'
        ]);
    }

    public function checkForOtpError($userOtp){
        if (!$userOtp) {
            return response()->json(['error' => 'Your OTP is not correct'], 401);
        }else if($userOtp && now()->isAfter($userOtp->expire_at)){
            return response()->json(['error' => 'Your OTP has been expired'], 401);
        }
        return true;
    }

    public function sendSms($code,$number) : JsonResponse{
        try
        {
            $sid    = config('app.twilio')['TWILIO_ACCOUNT_SID'];
            $token  = config('app.twilio')['TWILIO_AUTH_TOKEN'];
            $messagingServiceSid  = config('app.twilio')['MESSAGING_SERVICE_SID'];
            $twilio = new Client($sid, $token);

            $message = $twilio->messages
                ->create($number, // to
                    array(
                        "messagingServiceSid" => $messagingServiceSid,
                        "body" => "Your forwarder verification code is " . $code
                    )
                );

            return response()->json([
                'success' => $message->sid
            ]);

        }
        catch (Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function getUserRoles(){
        try {
            return UserRole::query()->where('is_visible' , 1)->get();
        }catch(Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function currentUser(Request $request): JsonResponse{
        try {
            $user = User::with(['drivers' , 'drivers.driverInfo' , 'drivers.driverInfo.media'])->findOrFail($request->user()->id);
            return response()->json($user, 200);

        }catch(Exception $e)
        {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }



}
