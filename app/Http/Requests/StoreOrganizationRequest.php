<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(auth()->check()) {
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
            'name' => 'required|string|max:255',
            'description'=> 'nullable|string',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'=> 'name is required',
            'name.string'=> 'name must be string',
            'name.max' => 'The name may not be greater than 255 characters.',
            'description.string'=> 'description must be string',
        ];
    }
}
