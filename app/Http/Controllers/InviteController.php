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
            "token" => Str::random(20),
            "expires_at" => now()->addMinutes(10),
            "email" => $request->email,
            "invitedBy" => $request->invitedBy,
            "organization_id" => $request->organization_id,
            "invitedTo" => $request->invitedTo
        ];

        if ($request->invitedBy === $request->invitedTo) {
            return response()->json([
                "status" => false,
                "message" => "you cannot invite yourself"
            ], 500);
        }

        $isOrganizationValid = Organization::findOrFail($request->organization_id);

        if (!$isOrganizationValid) {
            return response()->json([
                "status" => false,
                "message" => "Organization not found"
            ]);
        }

        $checkInvitedByisLegit = Organization::where("created_by", $request->invitedBy)->exists();

        if (!$checkInvitedByisLegit) {
            return response()->json([
                "status" => false,
                "message" => "You have to be admin to invite others."
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


        if (auth()->user()->id === $user->id) {
            return response()->json([
                "status" => false,
                "message" => "You can't invite yourself"
            ], 400);
        }

        $sendData = [];
        $urlencodeToken = urlencode($invite->token);

        $orgName = $isOrganizationValid->name;



        if ($request->invitedBy === auth()->user()->id) {
            $sendData = [
                "body" => "<p>You are invited to join organization $orgName. Click the following link to accept invite. <a href=$this->url/api/invite/$request->invitedTo/verify/$urlencodeToken>Click Here</a></p>",
                "subject" => "You are invited in organization $orgName",
                "email" => $request->email
            ];
        } else {
            $sendData = [
                "body" => "<p>$invited_to_name->name is requesting to join organization $orgName. Click the following link to accept invite. <a href=$this->url/api/invite/$request->invitedTo/verify/$urlencodeToken>Click Here</a></p>",
                "subject" => "$invited_to_name->name is requesting to join organization $orgName",
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
        $invite = InviteUser::where('invitedTo', $userId)
            ->where('token', $token)
            ->first();

        if (!$invite) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Token or Expired'
            ], 500);
        }

        if ($invite->expires_at < now()) {
            return response()->json([
                'status' => false,
                'message' => 'Token Expired'
            ], 500);
        }

        $organization = Organization::where('id', $invite->organization_id)->first();
        if (!$organization) {
            return response()->json([
                'status' => false,
                'message' => 'Organization not found'
            ], 404);
        }

        $userExists = $organization->users->contains('id', $userId);
        if ($userExists) {
            return response()->json([
                'message' => 'User already exists in the organization'
            ], 409);
        }

        $organization->users()->attach($userId);

        $invite->delete();

        return response()->json([
            'status' => true,
            'message' => 'Invite verified successfully',
        ]);
    }

}


// thing add to forgot 
// -> who send to who
// -> organization id