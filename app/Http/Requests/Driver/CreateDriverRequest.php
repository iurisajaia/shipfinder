<?php

namespace App\Http\Requests\Driver;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateDriverRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            [
                'room' => 'string',
                'series' => 'string',
                'issued_by' => 'string',
                'date_of_issue' => 'string',
                'serial_number' => 'string',
                'driver_passport' => 'string',
                'drivers_license' => 'string',
                'firstname' => 'string',
                'lastname' => 'string',
                'phone' => 'string|required',
            ]
        ];
    }

    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()->messages()

        ], 401));

    }

    public function messages()
    {
        return [
            'phone.required' => 'Phone is required!'
        ];
    }
}
