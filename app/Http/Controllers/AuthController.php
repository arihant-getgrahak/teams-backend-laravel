<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{

    //Register API (POST, Formdata)
    public function register(RegisterRequest $request)
    {
        // User Model
        User::create([
            "id" => Str::uuid(),
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        // Response
        return response()->json([
            "status" => true,
            "message" => "User registered successfully"
        ]);
    }

    //Login API (POST, Formdata)
    public function login(LoginRequest $request)
    {
        // JWTAuth
        $token = JWTAuth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);

        if (!empty($token)) {

            return response()->json([
                "status" => true,
                "message" => "User logged in succcessfully",
                "token" => $token
            ]);
        }

        // Response
        return response()->json([
            "status" => false,
            "message" => "Invalid details"
        ]);
    }

    //Profile API (GET, autherization token value JWT)
    public function profile()
    {
        $userdata = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "Profile data",
            "data" => $userdata,
        ]);
    }


    //Logout API(GET)
    public function logout()
    {
        $token = JWTAuth::getToken();

        // invalidate token
        $invalidate = JWTAuth::invalidate($token);

        if ($invalidate) {
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Successfully logged out',
                ],
                'data' => [],
            ]);
        }
    }
}
