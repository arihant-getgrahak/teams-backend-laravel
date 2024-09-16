<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function search($query)
    {
        $user = User::where('name', 'like', '%' . $query . '%')->orWhere('email', 'like', '%' . $query . '%')->get();
        if (count($user) == 0) {
            return response()->json(['message' => 'No user found'], 404);
        }
        return response()->json([
            "user" => $user
        ], 200);
    }

    function startChat(Request $request){}
}

