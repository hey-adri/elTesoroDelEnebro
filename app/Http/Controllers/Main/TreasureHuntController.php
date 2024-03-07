<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperController;
use App\Models\TreasureHunt;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function Laravel\Prompts\search;

class TreasureHuntController extends Controller
{
    public function index(){
        $user = auth()->user();
        /**
         * Querying all the users treasure_hunts
         */
        $treasureHunts = $user->treasure_hunts()->with('clues');

        /**
         * Searching by treasure_hunts.title or clues.title
         */
        $search = request('search');
        if ($search) {
            $treasureHunts->where(function ($treasureHunts) use ($search) { //Filtering by the treasureHunts that belong to the user and ...
                $treasureHunts->where('title', 'like', '%' . $search . '%') //  have the search on their title
                    ->orWhereHas('clues', function ($clues) use ($search) {// Or those which have clues that...
                        $clues->where(function ($query) use ($search) {
                            $query->where('title', 'like', '%' . $search . '%') // Have the search on their title
                                ->orWhere('body', 'like', '%' . $search . '%'); /// Have the search on their body
                        });
                    });
            });
        }
        /**
         * Filtering by pro Clues
         */
        if(in_array('ProOnly',(request('filters')?request('filters'):[]))){
            $treasureHunts->whereHas('clues', function ($clue) { //Filtering by the treasureHunts that have clues
                $clue->whereHas('image')->orWhereHas('embedded_video'); //That either have an image or video, pro clues
            });
        }

        /**
         * Sorting by most recent, having in account treasureHunts and their clues, whichever is latest
         */
        $treasureHunts->orderByDesc(function ($query) {
            $query->selectRaw('GREATEST(treasure_hunts.updated_at, COALESCE((SELECT MAX(updated_at) FROM clues WHERE treasure_hunt_id = treasure_hunts.id), \'1970-01-01 00:00:00\'))'); //Using coalesce to provide default date in case there are no clues
        });


        /**
         * Paginating
         */
        $treasureHunts = $treasureHunts->paginate(6);

        return view('treasureHunts.userArea.index',[
            'treasure_hunts'=>$treasureHunts
        ]);
    }
    public function show(TreasureHunt $treasureHunt){
        $clues = $treasureHunt->clues();
        /**
         * Searching by treasure_hunts.title or clues.title
         */
        $search = request('search');
        if ($search) {
            $clues->where(function ($clues) use ($search) {
                $clues->where('title', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%')
                    ->orWhere('help', 'like', '%' . $search . '%')
                    ->orWhere('footNote', 'like', '%' . $search . '%')
                    ->orWhere('clueKey', 'like', '%' . $search . '%');
            });
        }
        /**
         * Filtering by pro Clues
         */
        if(in_array('ProOnly',(request('filters')?request('filters'):[]))){
            $clues->where(function ($clues) {
                $clues->whereHas('image')->orWhereHas('embedded_video');
            });
        }
        /**
         * Sort the clues by id in ascending order
         */
        $clues->orderBy('order', 'asc');
        /**
         * Paginating
         */
        $clues = $clues->paginate(5);
        return view('treasureHunts.show',[
            'treasureHunt'=>$treasureHunt,
            'clues'=>$clues
        ]);
    }
    public function create(){
        return view('treasureHunts.create');
    }
    public function store(){
        $attributes = request()->validate(
            [
                "title"=>["required","max:255"],
            ]
        );
        HelperController::sanitizeArray($attributes); //Sanitizing input
        $attributes['user_id'] = auth()->user()->id;
        try {
            //Creating and storing the treasureHunt
            $treasureHunt = TreasureHunt::create(
                $attributes
            );
            //Redirecting to the new treasureHunt
            return redirect(route('treasureHunt.show',['treasureHunt'=>$treasureHunt->id]))->with('toast',[
                'icon' => 'success',
                'text'=>$treasureHunt->title.__(' creada!')
            ]);
        } catch (Exception $exception) {
            Log::log('error',$exception->getMessage());
            return redirect()->back()->with('toast',[
                'icon' => 'error',
                'text'=>__('Vaya, ha habido un error.')
            ]);
        }
    }

    public function edit(TreasureHunt $treasureHunt){
        return view('treasureHunts.edit',['treasureHunt'=>$treasureHunt]);
    }

    public function update(TreasureHunt $treasureHunt){
        $attributes = request()->validate(
            [
                "title"=>["required","max:255"],
            ]
        );
        HelperController::sanitizeArray($attributes); //Sanitizing input
        try {
            //Updating the treasureHunt
            $treasureHunt->updateOrFail($attributes);
            //Redirecting to the updated treasureHunt
            return redirect(route('treasureHunt.show',['treasureHunt'=>$treasureHunt->id]))->with('toast',[
                'icon' => 'success',
                'text'=>$treasureHunt->title.__(' actualizada!')
            ]);
        } catch (\Throwable | Exception $exception) {
            Log::log('error',$exception->getMessage());
            return redirect()->back()->with('toast',[
                'icon' => 'error',
                'text'=>__('Vaya, ha habido un error.')
            ]);
        }
    }

    public function destroy(TreasureHunt $treasureHunt){
        try {
            $treasureHunt->deleteOrFail();

            //Allowing other routes to go back to if received
            $back =  redirect()->back();
            if(!empty(request('backTo'))){
                $back = redirect(route(request('backTo')));
            }


            return $back->with('toast', [
                'icon' => 'success',
                'text' => __('Has eliminado ') . $treasureHunt->title
            ]);
        } catch (\Throwable $e) {
            return redirect()->back()->with('toast', [
                'icon' => 'error',
                'text' => __('Ha habido un error en el borrado')
            ]);
        }
    }

    public function generateQRCodes(TreasureHunt $treasureHunt){
        return 'Todo';
    }
}
