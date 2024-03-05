<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SessionsController extends Controller
{
    /**
     * Returns the login view
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create (){
        return view('sessions.create');
    }


    public function store (){
        //Validating the request fields
        $attributes = request()->validate(
            [
                'username'=>['required','max:255'],
                'password'=>['required','max:255']
            ]
        );

        //Checking if credentials exist in database
//        $attributes['username'] = strtolower($attributes['username']);
        if (!auth()->attempt($attributes)){
            //Auth Failed, validation exception
            throw ValidationException::withMessages(
                ['login'=>__('Vaya! Parece que tus credenciales son incorrectos!')]
            );
        }

        //Regenerating the session to prevent attacks
        session()->regenerate();
        //Redirecting home
        return redirect(route('home'))->with('toast',[
            'icon' => 'success',
            'text'=>__('Sesión Iniciada como ').auth()->user()->username
        ]);
    }

    public function destroy(){
        auth()->logout();
        return redirect('/')->with('toast',[
            'icon' => 'success',
            'text'=>__('Has cerrado sesión')
        ]);
    }
}
