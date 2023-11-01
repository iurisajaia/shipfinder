<?php

namespace App\Http\Requests\Car;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCarRequest extends FormRequest
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
                'model' => 'string',
                'description' => 'string',
                'danger' => 'boolean',
                'registration_number' => 'string',

                'payment_method_id' => 'integer',
                'car_body_type_id' => 'integer',
                'trailer_id' => 'integer',

                'dimensions' => 'array',
                'dimensions.length' => 'integer',
                'dimensions.width' => 'integer',
                'dimensions.height' => 'integer',
                'dimensions.volume' => 'string',
                'dimensions.capacity' => 'string',

                'loading_types' => 'array',
                'loading_types.*' => 'integer',

                'countries' => 'array',
                'countries.*' => 'integer',

                'drivers' => 'array',
                'drivers.*' => 'integer',


            ]
        ];
    }

    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'success' => false,

            'message' => 'Validation errors',

            'data' => $validator->errors()->messages()

        ]));

    }

    public function messages()
    {
        return [
        ];
    }
}
