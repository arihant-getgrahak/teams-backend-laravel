<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingRequest extends FormRequest
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
            'group_id' => 'required|exists:groups,id',
            'scheduled_at' => 'required|date',
            'title' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'group_id.required' => __("validation.required", ["attribute" => "group"]),
            'group_id.exists' => __('validation.exists', ['attribute' => 'group']),
            'scheduled_at.required' => __('validation.required', ['attribute' => 'time']),
            'agenda.required' => __('validation.required', ['attribute' => 'agenda']),
            'agenda.max' => __('validation.max', ['attribute' => 'agenda', 'max' => 255]),
        ];
    }
}
