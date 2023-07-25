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
                'trailer_type_id' => 'integer',
                'payment_method_id' => 'integer',
                'model' => 'string',
                'description' => 'string',
                'registration_number' => 'string',
                'dimensions' => 'array',
                'dimensions.length' => 'integer',
                'dimensions.width' => 'integer',
                'dimensions.height' => 'integer',
                'dimensions.volume' => 'string',
                'dimensions.capacity' => 'string',
                'body_types' => 'array',
                'body_types.*' => 'integer',
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
