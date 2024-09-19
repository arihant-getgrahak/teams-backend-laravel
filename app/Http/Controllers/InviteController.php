<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteRequest;
use App\Models\InviteUser;
use App\Models\User;
use Http;
use Str;

class InviteController extends Controller
{
    public function createToken(InviteRequest $request)
    {
        $data = [
            "token" => Str::random(20),
            "expires_at" => now()->addMinutes(10),
            "email" => $request->email
        ];
        $invite = InviteUser::create($data);
        $user = User::where("email", $invite->email)->first();

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

        $sendData = [
            "body" => "<p>You are invited in organization Arihant. Click the following link to accept invite. <a href=google.com/arihant>CLick Here</a></p>",
            "subject" => "You are invited in organization Arihant",
            "email" => $request->email
        ];

       Http::post("https://connect.pabbly.com/workflow/sendwebhookdata/IjU3NjYwNTZkMDYzMjA0M2M1MjY4NTUzZDUxMzQi_pc", $sendData);
    }

}

// thing add to forgot 
// -> who send to who
// -> organization id