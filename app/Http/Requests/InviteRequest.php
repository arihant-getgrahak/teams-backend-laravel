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
            "email" => "required|email|exists:users",
            "invitedTo" => "required|exists:users,id",
            "invitedBy" => "required|exists:users,id",
            "organization_id" => "required|exists:organizations,id"
        ];
    }

    public function messages(): array
    {
        return [
            "email.exists" => "The email does not exist",
            "email.required" => "The email field is required.",
            "email.email" => "Please enter valid email address",
            "invitedTo.required" => "The invitedTo field is required.",
            "invitedBy.required" => "The invitedBy field is required.",
            "invitedBy.exists" => "The invitedBy does not exist",
            "invitedTo.exists" => "The invitedTo does not exist",
            "organization_id.required" => "The organization_id field is required.",
            "organization_id.exists" => "The organization_id does not exist",
        ];
    }
}
