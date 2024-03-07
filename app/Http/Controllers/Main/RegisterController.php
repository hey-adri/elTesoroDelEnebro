<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperController;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function create(){
        return view('register.create');
    }

    public function store(){
        //Validating
        $attributes = request()->validate(
            [
                "name"=>["required","max:255"],
                "email"=>["required","email","max:255",Rule::unique('users','email')],
                "username"=>["required","regex:/^(?=.{4,20}$)[a-z0-9._-]+$/",Rule::unique('users','username')],
                "password"=>["required","regex:/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\d$&+,:;=?@#|'<>.^*()%! -]{8,30}$/","max:255"],
            ]
        );
        //Sanitizing
        HelperController::sanitizeArray($attributes); //Sanitizing input
        try {
            //Creating and storing the user
            $user = User::create([
                'name'=>$attributes['name'],
                'email'=>$attributes['email'],
                'username'=>$attributes['username'],
                'password'=>$attributes['password']
            ]); //Al crear un objeto usuario, la contraseña se guarda encriptada

            //Logging in the new user
            auth()->login($user);

            //Redirecting home
            return redirect(route('userArea.index'))->with('toast',[
                'icon' => 'success',
                'text'=>__('Te damos la bienvenida ').auth()->user()->name.'.'
            ]);
        } catch (Exception $exception) {
            Log::log('error',$exception->getMessage());
            return redirect()->back()->with('toast',[
                'icon' => 'error',
                'text'=>__('Vaya, ha habido un error.')
            ]);
        }
    }

}
