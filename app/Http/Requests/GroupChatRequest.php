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

    public function messages(): array{
        return [
            "message.required" => "Message is required",
            "message.max" => "Message must be less than 255 characters",
            "group_id.required" => "Group id is required",
            "group_id.exists" => "Group id does not exist",
            "user_id.required" => "User id is required",
            "user_id.exists" => "User id does not exist"
        ];
    }
}
