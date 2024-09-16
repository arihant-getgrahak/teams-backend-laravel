<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function search($id)
    {
        $user = User::find($id);
        dd($user);
    }
}
