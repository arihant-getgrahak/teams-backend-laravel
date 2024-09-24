<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddUserToOrganizationRequest;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\StoreOrganizationRequest;
use App\Models\User;
use App\Models\Organization;

use Illuminate\Support\Facades\Http;


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
        $response = Http::post('https://eoruufmvgo77mg2.m.pipedream.net', 
        [
            'userName' => $user->name,
            'userEmail' => $user->email,
            'organizationName' => $organization->name,
            'message' => 'You have been added to the organization ' . $organization->name,
        ]);
    
        // Check if the request to Pipedream was successful
        if ($response->successful()) {
            return response()->json('User added to organization and email sent');
        } else {
            return response()->json('User added to organization, but email failed', 500);
        }
        // return response()->json('User added to organization');
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
