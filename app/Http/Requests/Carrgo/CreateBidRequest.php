<?php

namespace App\Http\Requests\Carrgo;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateBidRequest extends FormRequest
{
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
                'comment' => 'string',
                'pick_up_date' => 'string',
                'delivery_date' => 'string',
                'price' => 'integer|required',
                'car_id' => 'integer|required',
                'cargo_id' => 'integer|required',
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
            'price.required' => 'Price is required!',
            'car_id.required' => 'Car is required!',
            'cargo_id.required' => 'Cargo is required!',
        ];
    }
}
