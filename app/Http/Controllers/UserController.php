<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Transformers\UserSearchTransform;

class UserController extends Controller
{
    public function search($lang,$query)
    {
        $user = User::where('name', 'like', '%' . $query . '%')->orWhere('email', 'like', '%' . $query . '%')->get();
        if (count($user) == 0) {
            return response()->json(['message' => 'No user found'], 404);
        }
        $user = [$user];
        $response = fractal($user, new UserSearchTransform())->toArray();
        return response()->json([
            "user" => $response["data"][0]["data"]
        ], 200);
    }
}

