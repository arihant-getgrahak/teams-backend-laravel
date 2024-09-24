<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupChatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!auth()->check()) {
            return false;
        }
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
            "message" => "required|string|max:255",
            "group_id" => "required|exists:groups,id",
            "user_id" => "required|exists:users,id"
        ];
    }

    public function messages(): array
    {
        return [
            "message.required" => __("validation.required", ["attribute" => "message"]),
            "message.max" => __("validation.max", ["attribute" => "message", "max" => 255]),
            "group_id.required" => __("validation.required", ["attribute" => "group"]),
            "group_id.exists" => __("validation.exists", ["attribute" => "group"]),
            "user_id.required" => __("validation.required", ["attribute" => "user_id"]),
            "user_id.exists" => __("validation.exists", ["attribute" => "user_id"]),
        ];
    }
}
