<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InviteRequest extends FormRequest
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
            "invitedTo" => "required|exists:users,id",
            "invitedBy" => "required|exists:users,id",
            "organization_id" => "required|exists:organizations,id"
        ];
    }

    public function messages(): array
    {
        return [
            "invitedTo.required" => __("validation.required", ["attribute" => "invitedTo"]),
            "invitedBy.required" => __("validation.required", ["attribute" => "invitedBy"]),
            "invitedBy.exists" => __("validation.exists", ["attribute" => "invitedBy"]),
            "invitedTo.exists" => __("validation.exists", ["attribute" => "invitedTo"]),
            "organization_id.required" => __("validation.required", ["attribute" => "संगठन_आईडी"]),
            "organization_id.exists" => "The organization_id does not exist",
        ];
    }
}
