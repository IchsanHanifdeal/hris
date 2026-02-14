<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = config('app.locale');

        if (Auth::check()) {
            $userLocale = Auth::user()->locale;
            if ($userLocale) {
                $locale = $userLocale;
            }
        } 
        elseif (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        if (in_array($locale, ['id', 'en'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}