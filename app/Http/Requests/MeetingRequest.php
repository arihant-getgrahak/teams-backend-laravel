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
            'group_id' => 'required|exists:groups,id',
            'scheduled_at'=> 'required|date',
            'title'=> 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'group_id.required' => 'Group is required',
            'group_id.exists' => 'Group does not exist',
            'scheduled_at.required' => 'Scheduled time is required',
            'agenda.required' => 'Agenda is required',
            'agenda.max' => 'Agenda is too long',
        ];
    }
}
