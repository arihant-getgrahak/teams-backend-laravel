<?php

namespace App\Http\Requests;

use App\Models\Message;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class MessageUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    protected $error;
    public function authorize(): bool
    {
        if (!auth()->check()) {
            return false;
        }
        $message_id = $this->message_id;
        $user_id = auth()->user()->id;

        if (!$message_id) {
            $this->error = "Message id is required";
            return false;
        }
        $message = Message::find($message_id);
        if (!$message) {
            $this->error = "Message not found";
            return false;
        }
        if (!$user_id == $message->sender_id) {
            $this->error = "You are not authorized to update this message";
            return false;
        }
        // dd($message);
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
        // throw new AuthorizationException($this->error[0]);
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
            "message_id" => "required|string|exists:messages,id",
            "message" => " required|string|max:255",
        ];
    }

    public function messages()
    {
        return [
            "message.required" => "The message field is required.",
            "message.max" => "The message may not be greater than 255 characters.",
            "message.string" => "The message must be a string.",
            "message_id.exists" => "The message you are trying to update does not exist",
            "message_id.required" => "The message you are trying to update is required",
        ];
    }
}
