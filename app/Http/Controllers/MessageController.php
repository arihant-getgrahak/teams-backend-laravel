<?php

namespace App\Http\Controllers;

use App\Events\MessageSendEvent;
use App\Models\Message;
use App\Models\User;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\MessageDeleteRequest;
use App\Transformers\MessageTransform;
use App\Http\Requests\MessageUpdateRequest;
use DB;

class MessageController extends Controller
{
    public function display(string $id)
    {
        if(!User::where("id", $id)->exists()){
            return response()->json([
                "status"=>false,
                "message" => __('auth.notfound', ['attribute'=> 'User']),
            ], 404);
        }
        $message = Message::where(function ($query) use ($id) {
            $query->where('sender_id', auth()->user()->id)
                ->where('receiver_id', $id);
        })
            ->orWhere(function ($query) use ($id) {
                $query->where('receiver_id', auth()->user()->id)
                    ->where('sender_id', $id);
            })
            ->with(["sender:id,name", "receiver:id,name"])
            ->paginate(20);

        $totalCount = $message->total();

        $message = [$message];

        $response = fractal($message, new MessageTransform())->toArray();
        if (count($response) == 1) {
            $response = $response["data"][0];
        }

        return response()->json([
            "status" => true,
            "message" => "Display Message",
            "totalMessageCount" => $totalCount,
            "data" => $response["data"]
        ], 200);
    }

    public function store(MessageRequest $request)
    {
        $message = $request->message;
        $data = [
            "message" => $message,
            "sender_id" => auth()->user()->id,
            "receiver_id" => $request->receiver_id,
            "type"=> $request->type
        ];

        Message::create($data);

        broadcast(new MessageSendEvent($data))->toOthers();
        // SendMessage::dispatch($message);
        return response()->json([
            "status" => true,
            "message" => __('auth.sent', ['attribute'=> 'Message']),
        ], 200);
    }

    public function delete(MessageDeleteRequest $request)
    {
        DB::beginTransaction();
        try {
            $message = Message::where("id", $request->message_id)->first();
            if ($message->isDelete) {
                return response()->json([
                    "status" => false,
                    "message" => __('auth.deleteonce'),
                ], 500);
            }

            $message->update(["message" => "This Message has been deleted", "isDelete" => true, "deletedAt" => now()]);

            DB::commit();
            return response()->json([
                "status" => true,
                "data" => $message,
                "message" => __('auth.deleted', ['attribute'=> 'Message']),
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
                    "message" => __('auth.once'),
                ], 500);
            }

            $message->update(["message" => $request->message, "isUpdate" => true, "updated_at" => now()]);

            DB::commit();

            return response()->json([
                "status" => true,
                "message" => __('auth.updated', ['attribute'=> 'Message']),
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
