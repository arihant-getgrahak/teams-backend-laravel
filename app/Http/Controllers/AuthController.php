<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "designation" => $request->designation,
            "language" => $request->language,
        ]);

        // Response
        return response()->json([
            "status" => true,
            "message" => __('auth.register', ['attribute'=> 'user']),
        ], 200);
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
                "message" => __('auth.login'),
                "token" => $token
            ], 200);
        }

        // Response
        return response()->json([
            "status" => false,
            "message" => __('auth.failed'),
        ], 401);
    }

    //Profile API (GET, autherization token value JWT)
    public function profile()
    {
        $userdata = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "__(auth.profile)",
            "data" => $userdata,
        ], 200);
    }


    //Logout API(GET)
    public function logout()
    {
        $token = JWTAuth::getToken();

        $invalidate = JWTAuth::invalidate($token);

        if ($invalidate) {
            return response()->json([
                'status' => 'success',
                'message' => '__(auth.logout)',
            ], 200);
        }
    }
}
