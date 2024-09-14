<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\MessageDeleteRequest;
use App\Transformers\MessageTransform;
class MessageController extends Controller
{
    public function display()
    {
        $message = Message::where('sender_id', auth()->user()->id)
            ->orWhere('receiver_id', auth()->user()->id)
            ->with(["sender:id,name", "receiver:id,name"])
            ->get();
        // ->get([
        //     "message",
        //     "sender_id",
        //     "receiver_id",
        // ]);

        // dd($message);
        $message = [$message];
        $response = fractal($message, new MessageTransform())->toArray();
        if (count($response) == 1) {
            $response = $response["data"][0];
        }

        // dd(count($response) == 1 ? $response[0]: $response);

        // echo "<pre>";
        // print_r($response["data"][0]);
        // echo "</pre>";

        return response()->json([
            "status" => true,
            "message" => $response,
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
