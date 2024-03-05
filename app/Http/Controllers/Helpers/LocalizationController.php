<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    /**
     * Updates the session locale with the selected one
     * @param $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update ($locale) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
        return redirect(route('home'));
    }
}
