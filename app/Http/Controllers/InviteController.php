<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteRequest;
use App\Models\InviteUser;
use App\Models\User;
use Hash;
use Http;
use Str;
use App\Models\Organization;

class InviteController extends Controller
{
    protected string $url = "http://teams-backend-laravel.test";
    public function createToken(InviteRequest $request)
    {
        // InviteUser::truncate();
        // dd();
        $data = [
            "token" => Hash::make(Str::random(20)),
            "expires_at" => now()->addMinutes(10),
            "email" => $request->email,
            "invitedBy" => $request->invitedBy,
            "organization_id" => "jkvjkbk",
            "invitedTo" => $request->invitedTo
        ];

        $isOrganizationValid = Organization::find($request->organization_id)->exists();
        if (!$isOrganizationValid) {
            return response()->json([
                "status" => false,
                "message" => "Organization not found"
            ]);
        }

        $invite = InviteUser::where("email", $request->email)->first();
        if ($invite) {
            $invite->update($data);
        } else {
            $invite = InviteUser::create($data);
        }
        
        $user = User::where("email", $request->email)->first();
        $invited_to_name = User::where("id", $request->invitedTo)->first();

        if (!$user) {
            return response()->json([
                "status" => false,
                "message" => "User not found"
            ], 404);
        }

        if (auth()->user()->id == $user->id) {
            return response()->json([
                "status" => false,
                "message" => "You can't invite yourself"
            ], 400);
        }

        $sendData = [];
        $checkInvitedByisLegit = Organization::where("created_by",$request->invitedBy)->exists();
        if (!$checkInvitedByisLegit) {
            return response()->json([
                "status" => false,
                "message" => "You have to be admin to invite others."
            ]);
        }
        
        $urlencodeToken = urlencode($invite->token);

        if ($request->invitedBy === auth()->user()->id) {
            $sendData = [
                "body" => "<p>You are invited to join organization Arihant. Click the following link to accept invite. <a href=$this->url/api/invite/$request->invitedTo/verify/$urlencodeToken>Click Here</a></p>",
                "subject" => "You are invited in organization Arihant",
                "email" => $request->email
            ];
        } else {
            $sendData = [
                "body" => "<p>$invited_to_name->name is requesting to join organization Arihant. Click the following link to accept invite. <a href=$this->url/api/invite/$request->invitedTo/verify/$urlencodeToken>Click Here</a></p>",
                "subject" => "$invited_to_name->name is requesting to join organization Arihant",
                "email" => $request->email
            ];
        }

        Http::post("https://connect.pabbly.com/workflow/sendwebhookdata/IjU3NjYwNTZkMDYzMjA0M2M1MjY4NTUzZDUxMzQi_pc", $sendData);

        return response()->json([
            "status" => true,
            "message" => "Invite sent successfully"
        ], 200);
    }

    public function verifyToken($userId, $token)
    {
        $isUserValid = InviteUser::where("invitedTo", $userId)->first();
        if (!$isUserValid) {
            return response()->json([
                "status" => false,
                "message" => "Invalid Token or Expired"
            ], 500);
        }

        if (!urlencode($token) === $isUserValid->token) {
            return response()->json([
                "status" => false,
                "message" => "Invalid Token or Expired"
            ], 500);
        }

        $isUserValid->delete();
        return response()->json([
            "status" => true,
            "message" => "Invite verified successfully",
        ]);
    }
}


// thing add to forgot 
// -> who send to who
// -> organization id