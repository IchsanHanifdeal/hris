<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    public function switch($locale)
    {
        if (in_array($locale, ['id', 'en'])) {
            
            Session::put('locale', $locale);

            if (Auth::check()) {
                $user = Auth::user();
                $user->locale = $locale;
                $user->save();
            }
        }

        return redirect()->back();
    }
}