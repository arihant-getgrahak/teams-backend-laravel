<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationCreateRequest;
use App\Models\Organization;

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
}
