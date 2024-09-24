<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TwoPersonChatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->check()) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'message.required' => __('validation.required', ["attribute" => "संदेश"]),
            'message.max' => __('validation.max', ["attribute" => "संदेश", "max" => 255]),
            'message.string' => __('validation.string', ["attribute" => "संदेश"]),
        ];
    }
}
