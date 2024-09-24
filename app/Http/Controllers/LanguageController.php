<?php

namespace App\Http\Controllers;

use App;

class LanguageController extends Controller
{
    public function index()
    {
        return response()->json([
            "status" => "success",
            "message" => "Language fetched Successfully",
            "data" => [
                [
                    "name" => "Hindi",
                    "name_native" => "हिन्दी",
                    "iso_code" => "hi",
                    "greetings" => "नमस्ते"
                ],
                [
                    "name" => "English",
                    "name_native" => "English",
                    "iso_code" => "en",
                    "greetings" => "Howdy!"
                ]
            ]
        ]);
    }
    public function translation(string $lang)
    {
        App::setLocale($lang);
        return response()->json([
            "data" => [__("auth"), __("validation")],
        ]);
    }
}
