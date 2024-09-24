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
            "password" => "required|min:8",
            "designation" => "required"
        ];
    }

    public function messages(): array
    {
        return [
            "email.unique" => __("validation.unique", ["attribute" => "email"]),
            "email.email" => __("validation.email", ["attribute" => "email"]),
            "name.required" => __("validation.required", ["attribute" => "name"]),
            "designation.required" => __("validation.required", ["attribute" => "designation"]),
            "email.required" => __("validation.required", ["attribute" => "email"]),
            "password.required" => __("validation.required", ["attribute" => "password"]),
            "password.min" => __("validation.min", ["attribute" => "password", "min" => "8"]),
        ];
    }
}
