<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserGroupRequest extends FormRequest
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
            "organization_id" => "required|exists:organizations,id",
            'user_id' => 'required|exists:users,id',
            'second_user_id' => 'required|exists:users,id',
            'group_id' => 'required|exists:organization_groups,id'
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => __("validation.required", ["attribute" => "उपयोगकर्ता आईडी"]),
            'user_id.exists' => __("validation.exists", ["attribute" => "उपयोगकर्ता आईडी"]),
            'second_user_id.required' => __("validation.required", ["attribute" => "दुसरा उपयोगकर्ता आईडी"]),
            'second_user_id.exists' => __("validation.exists", ["attribute" => "दुसरा उपयोगकर्ता आईडी"]),
            'group_id.required' => __("validation.required", ["attribute" => "समूह आईडी"]),
            'group_id.exists' => __("validation.exists", ["attribute" => "समूह आईडी"]),
        ];
    }
}
