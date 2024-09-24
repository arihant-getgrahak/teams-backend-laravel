<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'receiver_id' => 'required|string|exists:users,id',
            "type" => "required|string|in:individual,group"
        ];
    }

    public function messages(): array
    {
        return [
            'receiver_id.exists' => __('validation.required', ["attribute" => "user_id"]),
            'receiver_id.required' => __('validation.required', ["attribute" => "user_id"]),
            'receiver_id.string' => __('validation.string', ["attribute" => "user_id"]),
            'message.required' => __('validation.required', ["attribute" => "message"]),
            'message.max' => __('validation.max', ["attribute" => "message", "max" => 255]),
            'message.string' => __('validation.string', ["attribute" => "message"]),
            'type.in' => __('validation.in', ["attribute" => "type"]),
            "type.required" => __('validation.required', ["attribute" => "type"]),
        ];
    }
}
