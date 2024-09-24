<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Auth;
class LanguageController extends Controller
{
    public function setLanguage(Request $request)
    {
        // Assuming the language is passed in the request
        $locale = $request->input('language', 'en'); // Default to English if not provided
        
        // Check if the locale is valid and available in your `resources/lang` directory
        if (!in_array($locale, ['en', 'hi'])) { // Add more locales if needed
            return response()->json([
                'status' => false,
                'message' => __('auth.setuserlanguage'),
            ]);
        }
        
        // Set the application locale
        App::setLocale($locale);
        
        if (Auth::check()) {
            $user = Auth::user();
            $user->language = $locale;
            $user->save();
        }

        // Return success response
        return response()->json([
            'status' => true,
            'message' => __('auth.setlanguage') . " " . $locale,
        ]);
    }
}
