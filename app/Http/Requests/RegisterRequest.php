<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required",
            "designation" => "required"
        ];
    }

    public function messages(): array
    {
        return [
            "email.unique" => __("validation.unique", ["attribute" => "ईमेल"]),
            "email.email" => __("validation.email", ["attribute" => "ईमेल"]),
            "name.required" => __("validation.required", ["attribute" => "नाम"]),
            "designation.required" => __("validation.required", ["attribute" => "पद का नाम"]),
            "email.required" => __("validation.required", ["attribute" => "ईमेल"]),
            "password.required" => __("validation.required", ["attribute" => "पासवर्ड"]),
        ];
    }
}
