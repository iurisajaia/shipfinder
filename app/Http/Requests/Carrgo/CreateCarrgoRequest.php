<?php

namespace App\Http\Requests\Carrgo;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCarrgoRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            [
                'description' => 'string',
                'from' => 'object',
                'to' => 'object',
                'pick_up_date' => 'string',
                'delivery_date' => 'string',

                'contact_info' => 'required|array',
                'contact_info.sender' => 'required|array',
                'contact_info.sender.*.contact_person_firstname' => 'required|string',
                'contact_info.sender.*.contact_person_lastname' => 'required|string',
                'contact_info.sender.*.contact_person_phone' => 'required|string',
                'contact_info.receiver' => 'required|array',
                'contact_info.receiver.*.contact_person_firstname' => 'required|string',
                'contact_info.receiver.*.contact_person_lastname' => 'required|string',
                'contact_info.receiver.*.contact_person_phone' => 'required|string',

                'price' => 'integer',
                'bidding_end_date' => 'string',

                'package' => 'required|object',
                'package.name' => 'string',
                'package.code' => 'string',
                'package.danger_status' => 'string',
                'package.weight' => 'string',
                'package.height' => 'string',
                'package.length' => 'string',
                'package.temp' => 'string',
                'package.pcs' => 'string',
                'package.package_type_id' => 'integer|required',
            ]
        ];
    }

    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()->messages()

        ]));

    }

    public function messages()
    {
        return [
            'package.required' => 'Package is required!',
            'package.package_type_id.required' => 'Package type is required!',
        ];
    }
}
