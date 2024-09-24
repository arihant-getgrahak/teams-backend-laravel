<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddUserToOrganizationRequest;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\StoreOrganizationRequest;
use App\Models\OrganizationGroup;
use App\Http\Requests\AddUserGroupRequest;
use App\Models\Organization;
use Request;

class OrganizationController extends Controller
{
    public function store(StoreOrganizationRequest $request)
    {
        $data = [
            "name" => $request->name,
            "description" => $request->description ?? "",
            "created_by" => auth()->user()->id
        ];
        $organization = Organization::create($data);
        $organization->users()->attach(auth()->user()->id);
        return response()->json($organization);
    }

    public function createGroup(CreateGroupRequest $request, $organizationId)
    {
        $organization = Organization::findOrFail($organizationId);
        if ($organization->groups()->where('name', $request->name)->exists()) {
            return response()->json(['message' => __('auth.same', ['attribute' => 'Group'])], 409);
        }
        $group = $organization->groups()->create($request->all());
        return response()->json($group);
    }


    public function addGroupUser(AddUsergroupRequest $request)
    {
        $organization = Organization::where('id', $request->organization_id)->first();
        $userExists = $organization->users->contains('id', $request->user_id);
        if (!$userExists) {
            return response()->json([
                "status" => false,
                'message' => __('auth.user', ['attribute' => 'User']),
            ], 409);
        }

        $isGroupExist = OrganizationGroup::where('id', $request->group_id)->first();
        if (!$isGroupExist) {
            return response()->json([
                'message' => __('auth.notexists', ['attribute'=> 'Group']),
                "status" => false
            ], 409);
        }

        $userExists = $isGroupExist->users->contains('id', $request->user_id);
        if ($userExists) {
            return response()->json([
                'message' => __('auth.alreadyadded', ['attribute'=> 'User']),
            ], 409);
        }
        $userExists = $isGroupExist->users->contains('id', $request->second_user_id);
        if ($userExists) {
            return response()->json([
                'message' => __('auth.alreadyadded', ['attribute'=> 'SecondUser']),
            ], 409);
        }
        $isGroupExist->users()->attach($request->user_id);
        $isGroupExist->users()->attach($request->second_user_id);

        return response()->json([
            "status" => true,
            "message" => __('auth.added', ['attribute'=> 'User']),
            "data" => $isGroupExist->users
        ], 200);
    }
}
