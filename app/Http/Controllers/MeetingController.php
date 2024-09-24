<?php

namespace App\Http\Controllers;
use App\Http\Requests\MeetingRequest;
use App\Models\Group;
use App\Models\Meeting;


class MeetingController extends Controller
{
    public function scheduleMeeting(MeetingRequest $request)
    {
        $group = Group::find($request->group_id);
        if (auth()->user()->id !== $group->created_by) {
            return response()->json([
                "status" => false,
                "message"=> "You are not authorized to schedule meeting",
            ], 500);
        }

        $meeting = Meeting::create($request->all());
        return response()->json([
            "status" => true,
            "message" => "Meeting scheduled successfully",
            "data" => $meeting
        ], 200);

        
    }


}
