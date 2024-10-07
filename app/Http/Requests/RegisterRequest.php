<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
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
            'name' => 'required|min:6',
            'password' => 'required|min:6',
            'passwordConfirm' => 'required|same:password'
        ];
    }

    public function messages() {
        return [
            'email.required' => 'Email alanı doldurulması zorunludur',
            'name.required' => 'İsim alanı doldurulması zorunludur',
            'name.min:6' => 'İsim alanı en az 6 karakterden oluşmalıdır',
            'password.required' => 'Şifre alanı doldurulması zorunludur',
            'password.min' => 'Şifre alanı minimum 6 karakterden olması gerekmektedir',
            'passwordConfirm.same' => 'Şifreler uyuşmuyor'
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Kayıt olurket bir hata oluştu',
            'data' => $validator->errors()
        ], 422));
    }
}
