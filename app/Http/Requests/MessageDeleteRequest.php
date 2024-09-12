<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Message;

class MessageDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(!auth()->check()) {
            return false;
        }
        $message_id = $this->message_id;
        $user_id = auth()->user()->id;
        if(Message::where('id', $message_id)->where('sender_id', $user_id)->exists()){
            return true;
        }
        // $isUserisAuthorized = Message::where('id', $id)->where('sender_id', auth()->user()->id)->orWhere('receiver_id', auth()->user()->id)->exists();
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
            'message_id' => 'required|integer|exists:messages,id',
        ];
    }

    public function messages(): array
    {
        return [
            'message_id.exists' => 'The message you are trying to delete does not exist',
            'message_id.required' => 'The message you are trying to delete is required',
            'message_id.integer' => 'The message you are trying to delete must be an integer',
        ];
    }
}
