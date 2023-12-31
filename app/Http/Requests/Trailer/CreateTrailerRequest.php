<?php

namespace App\Http\Requests\Trailer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateTrailerRequest extends FormRequest
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
                'id' => 'integer',
                'description' => 'string',
                'model' => 'string',
                'registration_number' => 'string',
                'trailer_type_id' => 'integer',
                'tech_passport' => 'nullable|file|mimes:jpeg,png,gif,pdf',
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
        ];
    }
}
