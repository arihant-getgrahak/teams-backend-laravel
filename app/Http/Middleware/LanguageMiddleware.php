<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->segment(2);
        $lang = ["en", "hi"];
        if (!in_array($locale, $lang)) {
            $locale = config('app.fallback_locale');
        }
        app()->setLocale($locale);

        return $next($request);
    }
}