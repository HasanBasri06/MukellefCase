<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ];
    }

    public function messages() {
        return [
            'email.required' => 'Email alanı doldurulması zorunludur',
            'password.required' => 'Şifre alanı doldurulması zorunludur',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Giriş yapılırken bir hata oluştu',
            'data' => $validator->errors()
        ], 422));
    }
}
