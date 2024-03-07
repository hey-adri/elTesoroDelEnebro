<?php

namespace App\Http\Controllers\Main\Clue;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperController;
use App\Models\Clue\Clue;
use App\Models\TreasureHunt;
use Illuminate\Support\Facades\Log;

class ClueController extends Controller
{
    public function index(){
        return 'todo';
//        $treasure_hunts = TreasureHunt::latest()->where('user_id','=',auth()->user()->id)->paginate(3);
//        return view('treasureHunts.userArea.index',[
//            'treasure_hunts'=>$treasure_hunts
//        ]);
    }
    public function show(Clue $clue){
        return 'todo';
//        return view('treasureHunts.show',[
//            'treasureHunt'=>$treasureHunt
//        ]);
    }
    public function create(TreasureHunt $treasureHunt){
//        return view('treasureHunts.create');
        return 'todo';
    }
    public function store(){
//        $attributes = request()->validate(
//            [
//                "title"=>["required","max:255"],
//            ]
//        );
//        HelperController::sanitizeArray($attributes); //Sanitizing input
//        $attributes['user_id'] = auth()->user()->id;
//        try {
//            //Creating and storing the treasureHunt
//            $treasureHunt = TreasureHunt::create(
//                $attributes
//            );
//            //Redirecting to the new treasureHunt
//            return redirect(route('treasureHunt.show',['treasureHunt'=>$treasureHunt->id]))->with('toast',[
//                'icon' => 'success',
//                'text'=>$treasureHunt->title.__(' creada!')
//            ]);
//        } catch (Exception $exception) {
//            Log::log('error',$exception->getMessage());
//            return redirect()->back()->with('toast',[
//                'icon' => 'error',
//                'text'=>__('Vaya, ha habido un error.')
//            ]);
//        }
        return 'todo';
    }

    public function edit(Clue $clue){
//        return view('treasureHunts.edit',['treasureHunt'=>$treasureHunt]);
        return 'todo';
    }

    public function update(Clue $clue){
//        $attributes = request()->validate(
//            [
//                "title"=>["required","max:255"],
//            ]
//        );
//        HelperController::sanitizeArray($attributes); //Sanitizing input
//        try {
//            //Updating the treasureHunt
//            $treasureHunt->updateOrFail($attributes);
//            //Redirecting to the updated treasureHunt
//            return redirect(route('treasureHunt.show',['treasureHunt'=>$treasureHunt->id]))->with('toast',[
//                'icon' => 'success',
//                'text'=>$treasureHunt->title.__(' actualizada!')
//            ]);
//        } catch (\Throwable | Exception $exception) {
//            Log::log('error',$exception->getMessage());
//            return redirect()->back()->with('toast',[
//                'icon' => 'error',
//                'text'=>__('Vaya, ha habido un error.')
//            ]);
//        }
        return 'todo';
    }

    public function destroy(Clue $clue){
//        try {
//            $treasureHunt->deleteOrFail();
//
//            //Allowing other routes to go back to if received
//            $back =  redirect()->back();
//            if(!empty(request('backTo'))){
//                $back = redirect(route(request('backTo')));
//            }
//
//
//            return $back->with('toast', [
//                'icon' => 'success',
//                'text' => __('Has eliminado ') . $treasureHunt->title
//            ]);
//        } catch (\Throwable $e) {
//            return redirect()->back()->with('toast', [
//                'icon' => 'error',
//                'text' => __('Ha habido un error en el borrado')
//            ]);
//        }
        return 'todo';
    }
}
