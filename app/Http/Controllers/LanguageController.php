<?php

namespace App\Http\Controllers;

use App;

class LanguageController extends Controller
{
    public function index(string $lang)
    {
        App::setLocale($lang);
        // dd(App::getLocale());

        return response()->json([
            "lang" => App::getLocale(),
            'message' => __('welcome.message'),
        ]);
    }
}
