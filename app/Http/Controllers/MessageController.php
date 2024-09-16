<?php

namespace App\Http\Controllers;

use App\Events\MessageSendEvent;
use App\Jobs\SendMessage;
use App\Models\Message;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\MessageDeleteRequest;
use App\Transformers\MessageTransform;
use App\Http\Requests\MessageUpdateRequest;
use DB;

class MessageController extends Controller
{
    public function display()
    {
        $message = Message::where('sender_id', auth()->user()->id)
            ->orWhere('receiver_id', auth()->user()->id)
            ->with(["sender:id,name", "receiver:id,name"])
            ->get();

        $message = [$message];

        $response = fractal($message, new MessageTransform())->toArray();
        if (count($response) == 1) {
            $response = $response["data"][0];
        }

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

        broadcast(new MessageSendEvent($data))->toOthers();
        // SendMessage::dispatch($message);
        return response()->json([
            "status" => true,
            "message" => "Message sent successfully"
        ]);
    }

    public function delete(MessageDeleteRequest $request)
    {
        // $id = $request->message_id;

        // $isDelete = Message::where("id", $id)->delete();
        // if ($isDelete) {
        //     return response()->json([
        //         "status" => true,
        //         "message" => "Message deleted successfully",
        //     ]);
        // }

        // return response()->json([
        //     "status" => false,
        //     "message" => "Unable to delete message",
        // ]);

        DB::beginTransaction();
        try {
            $message = Message::where("id", $request->message_id)->first();
            if ($message->isDelete) {
                return response()->json([
                    "status" => false,
                    "message" => "Message already deleted"
                ], 500);
            }

            $message->update(["message" => "This Message has been deleted", "isDelete" => true, "deletedAt" => now()]);

            DB::commit();
            return response()->json([
                "status" => true,
                "data" => $message,
                "message" => "Message deleted successfully"
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
            ], 500);
        }
    }

    public function update(MessageUpdateRequest $request)
    {

        DB::beginTransaction();
        try {

            $message = Message::where("id", $request->message_id)->first();
            // dd($message);
            if ($message->isUpdate) {
                return response()->json([
                    "status" => false,
                    "message" => "Message already updated"
                ], 500);
            }

            $message->update(["message" => $request->message, "isUpdate" => true, "updated_at" => now()]);

            DB::commit();

            return response()->json([
                "status" => true,
                "message" => "Message updated successfully",
                "data" => $message
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
            ], 500);
        }
    }
}
