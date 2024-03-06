<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    //todo
    public function create(){
        return view('register.create');
    }

    //todo
    public function store(){
        //todo Validamos los datos recogido del formulario, si no son válidos se redirecciona al formulario
        //Guardamos el array de datos validados en attributes
        $attributes = request()->validate(
        //Recibe array asociativo de name del campo => regla
            [
                "name"=>["required","max:255"],
                "email"=>["required","email","max:255",Rule::unique('users','email')],
                "username"=>["required","regex:/^(?=.{4,20}$)[a-z0-9._-]+$/",Rule::unique('users','username')],
                "password"=>["required","regex:/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\d$&+,:;=?@#|'<>.^*()%! -]{8,30}$/","max:255"],
            ]
        );
        HelperController::sanitizeArray($attributes); //Sanitizing input
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
        return redirect(route('home'))->with('toast',[
            'icon' => 'success',
            'text'=>__('Bienvenido ').auth()->user()->username
        ]);
    }

}
