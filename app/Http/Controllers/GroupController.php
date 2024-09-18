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

    // public function addMessage(GroupChatRequest $request)
    // {
    //     try {
    //         DB::beginTransaction();
    //         $data = GroupMessage::create($request->all());
    //         DB::commit();
    //         return response()->json([
    //             "status" => true,
    //             "message" => "Message sent successfully",
    //             "data" => $data
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             "status" => false,
    //             "message" => $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function display($id)
    // {
    //     dd($id);
    // }
}
