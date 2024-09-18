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
            dd($request->all());
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

    public function display($id)
    {
        $checkIsGroupExist = Group::find($id);
        if (!$checkIsGroupExist) {
            return response()->json([
                "status" => false,
                "message" => "Group not found"
            ], 500);
        }

        $message = GroupMessage::where("group_id", $id);
        // if ($message->count() > 0) {
        //     return response()->json([
        //         "status" => true,
        //         "data" => "Group found",
        //         "message" => $message
        //     ], 200);
        // }
        return response()->json([
            "message" => $message 
        ]);
    }
}
