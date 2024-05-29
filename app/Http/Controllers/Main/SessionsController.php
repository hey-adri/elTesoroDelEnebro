<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

class SessionsController extends Controller
{
    /**
     * Returns the login view
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create (){
        return view('sessions.create');
    }


    /**
     * Checks if credentials from login are OK and logs the user in
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws ValidationException
     */
    public function store (){
        //Validating captcha
        \request()->validate([
            'g-recaptcha-response' => 'required|recaptchav3:login,0.7'
        ]);
        //Validating the request fields
        $attributes = request()->validate(
            [
                'username'=>['required','max:255'],
                'password'=>['required','max:255'],
            ]
        );

        //Checking if credentials exist in database
        if (!auth()->attempt($attributes)){
            //Auth Failed, validation exception
            throw ValidationException::withMessages(
                ['login'=>__('Vaya! Parece que tus credenciales son incorrectos!')]
            );
        }

        //Regenerating the session to prevent attacks
        session()->regenerate();
        //Redirecting home
        return redirect(route('userArea.index'))->with('toast',[
            'icon' => 'success',
            'text'=>__('Sesión Iniciada como ').auth()->user()->name
        ]);
    }

    /**
     * Logs the user out
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(){
        auth()->logout();
        return redirect(route('home'))->with('toast',[
            'icon' => 'success',
            'text'=>__('Has cerrado sesión')
        ]);
    }
}
