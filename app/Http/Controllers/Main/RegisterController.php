<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    //todo
    public function create(){
        return view('register.create');
    }

    //todo
    public function store(){
//        //todo Validamos los datos recogido del formulario, si no son válidos se redirecciona al formulario
//        //Guardamos el array de datos validados en attributes
//        $attributes = request()->validate(
//        //Recibe array asociativo de name del campo => regla
//            [
//                "name"=>["required","max:255"], //Cada regla se define como un array de cadenas
//                "username"=>["required","min:3","max:255",Rule::unique('users','username')], //Todo comprobar campos únicos en BD
//                "password"=>["required","min:7","max:255"],
//                "email"=>["required","email","max:255",Rule::unique('users','email')]
//
//            ]
//        );
//        //todo Si llegamos a este punto, los datos son válidos
//
//        //todo Creamos y guardamos el usuario
//        $user = User::create($attributes); //Al crear un objeto usuario, la contraseña se guarda encriptada
//
//        //todo Hacemos el login de usuario
//        auth()->login($user);
//
//        //todo Guardamos mensaje de sesión para próximo refresco, flash la borra después del 1er refresco
//        session()->flash('success','Your account has been created');
//
//        //Return to main view
//        return redirect('/');
    }

}
