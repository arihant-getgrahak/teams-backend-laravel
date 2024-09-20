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
        ], 200);
    }
}
