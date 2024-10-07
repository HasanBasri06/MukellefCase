<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangeSubscribeRenewalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'change_renewal' => 'required',
            'user_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'change_renewal.required' => 'Değiştirme isteği zorunludur',
            'user_id.required' => 'userId isteği zorunludur',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Hata oluştu',
            'data' => $validator->errors()
        ], 422));
    }
}
