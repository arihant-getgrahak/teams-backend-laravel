<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreOrganizationGroupMessageRequest;
use App\Models\OrganizationGroup;
use App\Models\OrganizationGroupMessage;

class OrganizationGroupMessageController extends Controller
{
    public function store(StoreOrganizationGroupMessageRequest $request, $groupId)
    {
        
        $group = OrganizationGroup::findOrFail($groupId);
        $message = $group->messages()->create([
            'message' => $request->message,
            'user_id' => $request->user()->id,
        ]);
        return response()->json($message);
    }

    public function index($groupId)
    {
        $messages = OrganizationGroupMessage::where('organization_group_id', $groupId)->get();
        return response()->json($messages);
    }
}
