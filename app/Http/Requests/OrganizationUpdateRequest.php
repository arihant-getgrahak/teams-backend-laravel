<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(!auth()->check()){
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
            "name" => "required|string|max:255",
            "description" => "required|string|max:255",
            // "group_id" => "required|exists:groups,id",
            // "user_id" => "required|exists:users,id",
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'name.string' => 'The name must be a string.',

            'description.required' => 'The description field is required.',
            'description.max' => 'The description may not be greater than 255 characters.',
            'description.string' => 'The description must be a string.',

            'group_id.required' => 'The group id field is required.',
            'group_id.exists' => 'The group id does not exist.',
        ];
    }
}
