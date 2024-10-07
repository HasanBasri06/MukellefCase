<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubscribeRegisterRequest extends FormRequest
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
            'card.name' => 'required',
            'card.number' => 'required|min:16|max:16',
            'card.cvv' => 'required|min:3|max:3',
            'card.expire_date' => 'required',
            'user_id' => 'required',
            'card.saved' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'card.name.required' => 'Kart ismi zorunludur',
            'card.number.required' => 'Kart numarası zorunludur',
            'card.number.min' => 'Kart numarası minimum 16 karakter olmalıdır',
            'card.number.max' => 'Kart numarası maximum 16 karakterden oluşmaktadır.',
            'card.cvv.required' => 'Kart cvv zorunludur',
            'card.cvv.min' => 'Kart cvv yanlış uzunlukta',
            'card.cvv.max' => 'Kart cvv yanlış uzunlukta',
            'card.expire_date.required' => 'Kart bitiş tarihi zorunludur',
            'user_id.required' => 'User id verilmesi zorunludur',
            'card.saved.required' => 'Kartı kaydetme boş olamaz'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Abone olma işleminde hata oluştu',
            'data' => $validator->errors()
        ], 422));
    }
}
