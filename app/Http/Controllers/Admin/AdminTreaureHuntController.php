<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Main\TreasureHuntController;
use App\Models\TreasureHunt;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTreaureHuntController extends TreasureHuntController
{
    public function index(){
        $filters=[];
        //Getting filters and sorting from request
        if($reqFilters = request('filters')){
            if (in_array('pro',$reqFilters)) $filters['pro']=true;
            if (in_array('has_images',$reqFilters)) $filters['has_images']=true;
            if (in_array('has_embedded_videos',$reqFilters)) $filters['has_embedded_videos']=true;
        }
        if(request('search'))$filters['search']=request('search');
        $sortBy=request('sortBy','updated_at');
        $sortDirection = request('sortDirection','desc');

        //Getting all TreasureHunts filtered
        $query = TreasureHunt::filter($filters,$sortBy,$sortDirection);

        //Pagination
        $treasureHunts = $query->paginate(5)->fragment('searchBar');
        return view('admin.treasureHunts.index',[
            'treasureHunts'=>$treasureHunts,
            'backTo'=>[
                'route'=>route('home'),
                'icon'=>'fa-home',
                'name'=>__('Home')
            ],
        ]);
    }

}
