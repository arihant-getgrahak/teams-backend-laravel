<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Message;

class MessageDeleteRequest extends FormRequest
{
    protected $error;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!auth()->check()) {
            $this->error = "Please login first";
            return false;
        }
        $message_id = $this->message_id;
        if (!$message_id) {
            $this->error = "The message id is required";
            return false;
        }
        $user_id = auth()->user()->id;

        if (!Message::where('id', $message_id)->where('sender_id', $user_id)->exists()) {
            return true;
        }
        return true;
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException($this->error);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message_id' => 'required|string|exists:messages,id',
        ];
    }

    public function messages(): array
    {
        return [
            'message_id.exists' => 'The message you are trying to delete does not exist',
            'message_id.required' => 'The message you are trying to delete is required',
            'message_id.string' => 'The message id is of type string',
        ];
    }
}
