<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddUserToOrganizationRequest;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\StoreOrganizationRequest;
use App\Models\User;
use App\Models\Organization;

class OrganizationController extends Controller
{
    public function store(StoreOrganizationRequest $request)
    {
        $organization = Organization::create($request->all());
        return response()->json($organization);
    }

    public function addUser(AddUserToOrganizationRequest $request, $organizationId)
    {
        $organization = Organization::findOrFail($organizationId);
        $user = User::findOrFail($request->user_id);

        if ($organization->users()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'User already exists in the organization'], 409);
        }

        $organization->users()->attach($user);
        return response()->json('User added to organization');
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
}
