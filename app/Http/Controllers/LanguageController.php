<?php

namespace App\Http\Controllers;

use App;

class LanguageController extends Controller
{
    public function index()
    {
        // dd(App::getLocale());

        return response()->json([
            "lang" => App::getLocale(),
            'message' => __('welcome.message'),
            "email" => __("validation.user.second_user_id_required"),
        ]);
    }
}
