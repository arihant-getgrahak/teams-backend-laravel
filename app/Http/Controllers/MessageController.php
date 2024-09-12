<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\MessageDeleteRequest;
class MessageController extends Controller
{
    public function display()
    {
        $message = Message::where('sender_id', auth()->user()->id)->orWhere('receiver_id', auth()->user()->id)->get([
            "message",
            "sender_id",
            "receiver_id"
        ]);

        return response()->json([
            "status" => true,
            "message" => $message
        ]);
    }

    public function store(MessageRequest $request)
    {
        $message = $request->message;
        $data = [
            "message" => $message,
            "sender_id" => auth()->user()->id,
            "receiver_id" => $request->receiver_id
        ];

        Message::create($data);
        return response()->json([
            "status" => true,
            "message" => "Message sent successfully"
        ]);
    }

    public function delete(MessageDeleteRequest $request)
    {
        $id = $request->message_id;

        $isDelete = Message::where("id", $id)->delete();
        if ($isDelete) {
            return response()->json([
                "status" => true,
                "message" => "Message deleted successfully",
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Unable to delete message",
        ]);
    }
}
