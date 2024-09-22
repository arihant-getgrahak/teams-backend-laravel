<?php

namespace App\Http\Controllers;

use App\Http\Requests\TwoPersonChatRequest;
use App\Models\OrganizationTwoPersonChat;
use App\Models\Organization;

class OrganizationTwoPersonChatController extends Controller
{
    public function store(TwoPersonChatRequest $request, $organizationId)
    {
        $organization = Organization::findOrFail($organizationId);
        $message = OrganizationTwoPersonChat::create([
            'organization_id' => $organization->id,
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json($message);
    }

    public function index($organizationId, $senderId, $receiverId)
    {
        $messages = OrganizationTwoPersonChat::where('organization_id', $organizationId)
            ->where(function ($query) use ($senderId, $receiverId) {
                $query->where('sender_id', $senderId)
                    ->where('receiver_id', $receiverId)
                    ->orWhere(function ($query) use ($senderId, $receiverId) {
                        $query->where('sender_id', $receiverId)
                            ->where('receiver_id', $senderId);
                    });
            })
            ->get();

        return response()->json($messages);
    }
}
