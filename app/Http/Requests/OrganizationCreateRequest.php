<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationCreateRequest extends FormRequest
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
            'organization_name' => 'required|string|max:255',
            'groups' => 'required|array',
            'groups.*.group_name' => 'required|string|max:255',
            'groups.*.users' => 'required|array',
            'groups.*.users.*.name' => 'required|string|max:255',
            'groups.*.users.*.email' => 'required|email|max:255|unique:users,email',
        ];
    }

    public function messages(): array
    {
        return [
            'organization_name.required' => 'The organization name is required.',
            'groups.required' => 'You must provide at least one group.',
            'groups.*.group_name.required' => 'Each group must have a name.',
            'groups.*.users.required' => 'Each group must have at least one user.',
            'groups.*.users.*.name.required' => 'The user name is required.',
            'groups.*.users.*.email.required' => 'The user email is required.',
            'groups.*.users.*.email.unique' => 'The email has already been taken.',
        ];
    }
}
