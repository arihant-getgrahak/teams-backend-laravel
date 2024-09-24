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
            "password" => "required|min:5|confirmed",
            "designation"=>"required",
            'language' => 'required|in:en,hi',
        ];
    }

    public function messages(): array
    {
        return [
            "email.unique" => "The email has already been taken.",
            "email.required" => "The email field is required.",
            "email.email" => "The email must be a valid email address.",
            "password.required" => "The password field is required.",
            "name.required" => "The name field is required.",
            "designation.required" => "The designation field is required.",
            'language.required' => __('auth.language'),
        ];
    }
}
