<?php

namespace App\Http\Controllers;
use App\Http\Requests\GroupCreateRequest;
use App\Http\Requests\GroupAddUserRequest;
use App\Http\Requests\GroupChatRequest;
use App\Http\Requests\GroupChatUpdateRequest;
use App\Models\Group;
use App\Models\GroupMessage;
use DB;
use App\Transformers\GroupDisplayTransform;

class GroupController extends Controller
{
    public function create(GroupCreateRequest $request)
    {
        $data = [
            "name" => $request->name,
            "created_by" => auth()->user()->id,
        ];
        $group = Group::create($data);
        return response()->json([
            "message" => "Group created successfully",
            "data" => $group
        ], 200);
    }

    public function displayGroup()
    {
        $group = Group::with(['createdBy:id,name', "users:id,name"])->get();
        $group = [$group];
        $response = fractal($group, new GroupDisplayTransform())->toArray();
        return response()->json([
            "status" => true,
            "message" => "Group fetched successfully",
            "data" => $response["data"][0]["data"]
            // "Data" => $group
        ], 200);
    }

    public function addUser(GroupAddUserRequest $request)
    {
        // Add user to group
        $group = Group::find($request->group_id);

        if ($group->users()->find($request->user_id)) {
            return response()->json([
                "message" => "User already added to group",
                "status" => false
            ], 500);
        }
        $group->users()->attach($request->user_id);
        return response()->json([
            "status" => true,
            "message" => "User added to group successfully",
            "data" => $group
        ], 200);
    }

    public function deleteGroup($group_id)
    {
        $group = Group::find($group_id);
        if (!$group) {
            return response()->json([
                "status" => false,
                "message" => "Group not found",
            ], 500);
        }
        $group->delete();
        return response()->json([
            'status' => true,
            'message' => 'Group deleted successfully',
        ], 200);
    }


    public function addMessage(GroupChatRequest $request)
    {
        DB::beginTransaction();
        try {
            // dd($request->all());
            $data = GroupMessage::create($request->all());
            DB::commit();
            return response()->json([
                "status" => true,
                "message" => "Message sent successfully",
                "data" => $data
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function getGroupMessages($group_id)
    {
        $group = Group::find($group_id);
        if (!$group) {
            return response()->json([
                "status" => false,
                "message" => "Group not found",
            ], 500);
        }

        $message = GroupMessage::where("group_id", $group_id)
            ->with('user:id,name')->paginate(20);
        return response()->json([
            'status' => true,
            'message' => 'Group message fetched successfully',
            'data' => $message,
        ], 200);
    }
    public function updateMessage(GroupChatUpdateRequest $request, $message_id)
    {
        DB::beginTransaction();
        try {
            $group = Group::find($request->group_id);
            if (!$group) {
                return response()->json([
                    "status" => false,
                    "message" => "Group not found",
                ], 500);
            }
            $message = GroupMessage::find($message_id);
            if (!$message) {
                return response()->json([
                    "status" => false,
                    "message" => "Message not found",
                ], 500);
            }

            if ($message->isUpdate) {
                return response()->json([
                    "status" => false,
                    "message" => "You can update message once",
                ], 500);
            }

            // update group chat message

            $message->update(["message" => $request->message, "updatedAt" => now(), "isUpdate" => true]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Message updated successfully',
                'data' => $message
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function deleteMessage($group_id, $message_id)
    {
        DB::beginTransaction();
        try {
            $group = Group::find($group_id);
            if (!$group) {
                return response()->json([
                    "status" => false,
                    "message" => "Group not found",
                ], 500);
            }
            $message = GroupMessage::find($message_id);
            if (!$message) {
                return response()->json([
                    "status" => false,
                    "message" => "Message not found",
                ], 500);
            }
            if ($message->isDelete) {
                return response()->json([
                    "status" => false,
                    "message" => "Message already deleted",
                ], 500);
            }
            $message->update(["message" => "This Message has been deleted", "isDelete" => true, "deletedAt" => now()]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Message deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}

