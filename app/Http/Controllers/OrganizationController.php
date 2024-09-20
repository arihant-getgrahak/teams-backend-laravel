<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganizationCreateRequest;
use App\Models\Organization;
use App\Http\Requests\OrganizationUpdateRequest;
use App\Models\organization_groups;
use App\Models\organization_user;
use DB;

class OrganizationController extends Controller
{
    public function create(OrganizationCreateRequest $request)
    {
        $data = [
            "organization_name" => $request->organization_name,
            "created_by" => auth()->user()->id,
        ];
        // DB::beginTransaction();
        // try {
        $organization = Organization::create($data);
        return response()->json([
            "message" => "Organization created successfully",
            "data" => $organization
        ], 200);

        foreach ($request->group as $groupData) {
            // Create each group and associate it with the organization
            $group = Group::create([
                'group_name' => $groupData['group_name'],
                'organization_id' => $organizations->id,
            ]);
        
            foreach ($groupData['users'] as $userData) {
                User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'group_id' => $group->id,
            ]);
            }
        }

        DB::commit();
        return response()->json([
            'message' => 'Organization, groups, and users created successfully',
            'data' => $organization,
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
            $organization = Organization::find($request->id);
            if (!$organization) {
                return response()->json([
                    "status" => false,
                    "message" => "name not found",
                ], 500);
            }

            if ($organization->isUpdate) {
                return response()->json([
                    "status" => false,
                    "message" => "You can update name once",
                ], 409);
            }

            // update name of organization

            $organization->update([
                "organization_name" => $request->organization_name,
                "updated_at" => now(),
                "isUpdate" => true,
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Name updated successfully',
                'data' => $organization,
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
        } catch (\Exception $e) {
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
        ], 200);
    }
}
