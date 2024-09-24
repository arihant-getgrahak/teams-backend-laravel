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
            $this->error = __("validation.login");
            return false;
        }
        $message_id = $this->message_id;
        if (!$message_id) {
            $this->error = __("validation.required", ["attribute" => "message"]);
            return false;
        }
        $user_id = auth()->user()->id;
        $message = Message::find($message_id);

        if (!$message) {
            $this->error = __("validation.message");
            return false;
        }
        if (!$user_id == $message->sender_id) {
            $this->error = __("validation.delete_authorize");
            return false;
        }

        if ($message->type !== "group") {
            $this->error = __("validation.group");
            return false;
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
            'message_id.exists' => __("validation.exists", ["attribute" => "message"]),
            'message_id.required' => __('validation.required', ["attribute" => "message"]),
            'message_id.string' => __('validation.string', ["attribute" => "message"]),
        ];
    }
}
