<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Transformers\UserSearchTransform;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function search($query)
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

