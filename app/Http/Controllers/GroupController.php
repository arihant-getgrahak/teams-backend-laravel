<?php

namespace App\Http\Controllers;
use App\Http\Requests\GroupCreateRequest;
use App\Http\Requests\GroupAddUserRequest;
use App\Models\Group;

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
        $group->users()->attach($request->user_id);
        return response()->json([
            "message" => "User added to group successfully",
            "data" => $group
        ], 200);
    }
}
