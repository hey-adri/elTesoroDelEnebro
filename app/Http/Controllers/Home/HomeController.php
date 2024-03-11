<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    /**
     * Returns the main home view, allowing the user to manually search for clues
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(){
        return view('home.home',[
            'backTo'=>[
                'route'=>route('userArea.index'),
                'icon'=>'fa-user',
                'name'=>__('Área Personal')
            ],
        ]);
    }

    /**
     * Returns the homeView showing the details of one clue
     * @param $clueKey
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show($clueKey){
        return view('home.home',[
            'clueKey'=>$clueKey,
            'backTo'=>[
                'route'=>route('userArea.index'),
                'icon'=>'fa-user',
                'name'=>__('Área Personal')
            ],
        ]);
    }
}
