<?php

namespace App\Http\Controllers;
use App\Http\Requests\GroupCreateRequest;
use App\Http\Requests\GroupAddUserRequest;
use App\Http\Requests\GroupChatRequest;
use App\Models\Group;
use App\Models\GroupMessage;
use DB;

class GroupController extends Controller
{
    public function create(GroupCreateRequest $request)
    {
        $group = Group::create($request->all());
        return response()->json([
            "message" => "Group created successfully",
            "data" => $group
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
            if($message->isDelete) {
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

