<?php

namespace App\Http\Controllers;


use App\Http\Requests\OrganizationCreateRequest;
use App\Models\Organization;
use App\Http\Requests\OrganizationUpdateRequest;
use App\Models\Group;
use DB;

class OrganizationController extends Controller
{
    public function create(OrganizationCreateRequest $request)
    {
        $data = [
            "name" => $request->name,
            "description" => $request->description,
            "created_by" => auth()->user()->id,
            "group_id" => $request->group_id,
            "user_id" => $request->user_id,
        ];
        $organization = Organization::create($data);
        return response()->json([
            "message" => "Organization created successfully",
            "data" => $organization
        ], 200);
    }

    public function updateOrganization(OrganizationUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $organization = Organization::find($request->id);
            if (!$organization) {
                return response()->json([
                    "status" => false,
                    "message" => "Organization not found",
                ], 500);
            }
            $name = Organization::find($request->id);
            if (!$name) {
                return response()->json([
                    "status" => false,
                    "message" => "name not found",
                ], 500);
            }

            if ($name->isUpdate) {
                return response()->json([
                    "status" => false,
                    "message" => "You can update name once",
                ], 500);
            }

            // update name of organization

            $name->update([
                "name" => $request->name, 
                "description" => $request->description,
                "updatedAt" => now(), 
                "isUpdate" => true
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Name updated successfully',
                'data' => $name,
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function deleteOrganization($id)
    {
        DB::beginTransaction();
        try {
            $organization = Organization::find($id);
            if (!$organization) {
                return response()->json([   
                    "status" => false,
                    "message" => "Organization not found",
                ], 500);
            }

            if ($organization->isDelete) {
                return response()->json([
                    "status" => false,
                    "message" => "Organization already deleted",
                ], 500);
            }
            
            $organization->update(["isDelete" => true, "deletedAt" => now()]);
            $organization->forceDelete();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Organization deleted successfully',
            ], 200);
        } 
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function getOrganization($id)
    {
        $organization = Organization::find($id);
        if (!$organization) {
            return response()->json([
                "status" => false,
                "message" => "Organization not found",
            ], 500);
        }
        return response()->json([
            'status' => true,
            'message' => 'Organization found successfully',
            'data' => $organization

use App\Http\Requests\AddUserToOrganizationRequest;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\StoreOrganizationRequest;
use App\Models\OrganizationGroup;
use App\Models\User;
use App\Http\Requests\addUserGroupRequest;
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
            return response()->json(['message' => 'A group with same name already exists'], 409);
        }
        $group = $organization->groups()->create($request->all());
        return response()->json($group);
    }


    public function addGroupUser(addUserGroupRequest $request)
    {
        $organization = Organization::where('id', $request->organization_id)->first();
        $userExists = $organization->users->contains('id', $request->user_id);
        if (!$userExists) {
            return response()->json([
                "status" => false,
                'message' => 'User have to be in the organization',
            ], 409);
        }

        $isGroupExist = OrganizationGroup::where('id', $request->group_id)->first();
        if (!$isGroupExist) {
            return response()->json([
                'message' => 'Group does not exist',
                "status" => false
            ], 409);
        }

        $userExists = $isGroupExist->users->contains('id', $request->user_id);
        if ($userExists) {
            return response()->json([
                'message' => 'User already added to group',
            ], 409);
        }
        $userExists = $isGroupExist->users->contains('id', $request->second_user_id);
        if ($userExists) {
            return response()->json([
                'message' => 'Second User already added to group',
            ], 409);
        }
        $isGroupExist->users()->attach($request->user_id);
        $isGroupExist->users()->attach($request->second_user_id);

        return response()->json([
            "status" => true,
            "message" => "User added to group successfully",
            "data" => $isGroupExist->users

        ], 200);
    }
}
