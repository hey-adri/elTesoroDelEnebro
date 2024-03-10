<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Main\Clue\ClueController;
use App\Models\Clue\Clue;
use Illuminate\Http\Request;

class AdminClueController extends ClueController
{
    public function index()
    {
        $filters=[];
        //Getting filters and sorting from request
        if($reqFilters = request('filters')){
            if (in_array('pro',$reqFilters)) $filters['pro']=true;
            if (in_array('has_embedded_video',$reqFilters)) $filters['has_embedded_video']=true;
            if (in_array('has_image',$reqFilters)) $filters['has_image']=true;
        }
        if(request('search'))$filters['search']=request('search');
        $sortBy=request('sortBy','updated_at');
        $sortDirection = request('sortDirection','desc');

        //Getting all clues filtered
        $clues = Clue::filter($filters,$sortBy,$sortDirection);

        $clues = $clues->paginate(10)->fragment('searchBar');
        return view('admin.clues.index',[
            'clues'=>$clues,
            'backTo'=>[
                'route'=>route('home'),
                'icon'=>'fa-home',
                'name'=>__('Home')
            ],
        ]);
    }

    /**
     * Shows the preview of one clue after the user inputs its clueKey
     * @param Clue $clue
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show(Clue $clue){
        return view('clues.show',[
            'clue'=>$clue,
            'clueKey'=>$clue->clueKey,
            'backTo'=>[
                'route'=>route('admin.clues.index'),
                'icon'=>'fa-scroll',
                'name'=>__('Admin. Pistas')
            ],
        ]);
    }
}
