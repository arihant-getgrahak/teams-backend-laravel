<?php

namespace App\Http\Controllers;
use App\Http\Requests\GroupCreateRequest;
use App\Http\Requests\GroupAddUserRequest;
use App\Models\Group;

class GroupController extends Controller
{
    public function create(GroupCreateRequest $request){
        $group = Group::create($request->all());
        return response()->json([
            "message" => "Group created successfully",
            "data" => $group
        ],200);
    }

    // public function addUser(GroupAddUserRequest $request){
    //     dd($request->all());
    // }
}
