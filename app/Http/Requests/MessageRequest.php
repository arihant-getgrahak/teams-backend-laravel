<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'message' => 'required|string|max:255',
            'receiver_id' => 'required|string|exists:users,id',
            "type" => "required|string|in:individual,group"
        ];
    }

    public function messages(): array{
        return [
            'receiver_id.exists' => 'The user you are trying to send a message to does not exist',
            'receiver_id.required' => 'The user you are trying to send a message to is required',
            'receiver_id.string' => 'The user you are trying to send a message to must be a string',
            'message.required' => 'The message you are trying to send is required',
            'message.max' => 'The message you are trying to send is too long',
            'message.string' => 'The message you are trying to send must be a string',
            'type.in'=> 'The type you are trying to send is not valid',
            "type.required"=>"The type you are trying to send is required"
        ];
    }
}
