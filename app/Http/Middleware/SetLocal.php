<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        if (!$locale) {
            $locale = Session::get('locale', 'fr');
        }

        if (in_array($locale, ['en', 'fr'])) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            App::setLocale('fr');
            Session::put('locale', 'fr');
        }

        return $next($request);
    }
}
