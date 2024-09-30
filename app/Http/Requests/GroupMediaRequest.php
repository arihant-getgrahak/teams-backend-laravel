<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupMediaRequest extends FormRequest
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
            'files' => 'required|array',
            'files.*' => 'file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,zip|max:2048',
            'group_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'file.mimes' => 'The :attribute must be a file of type: jpeg, png, jpg, gif, svg, pdf, doc, docx, zip.',
            'file.max' => 'The :attribute may not be greater than :max kilobytes.',
        ];
    }
}
