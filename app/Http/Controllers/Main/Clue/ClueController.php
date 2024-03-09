<?php

namespace App\Http\Controllers\Main\Clue;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperController;
use App\Models\Clue\Clue;
use App\Models\Clue\ClueEmbeddedVideo;
use App\Models\Clue\ClueImage;
use App\Models\TreasureHunt;
use Illuminate\Support\Facades\Log;

class ClueController extends Controller
{
    //index is performed in the same view as treasureHunt.show

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
                'route'=>route('treasureHunt.show',['treasureHunt'=>$clue->treasure_hunt]),
                'icon'=>'fa-book',
                'name'=>$clue->treasure_hunt->title
            ],
        ]);
    }

    /**
     * Returns the view clues.create
     * @param TreasureHunt $treasureHunt
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create(TreasureHunt $treasureHunt){
        return view('clues.create',[
            'treasureHunt'=>$treasureHunt,
            'backTo'=>[
                'route'=>route('treasureHunt.show',['treasureHunt'=>$treasureHunt]),
                'icon'=>'fa-book',
                'name'=>$treasureHunt->title
            ],
        ]);
    }

    /**
     * Stores a new clue as a treasureHunt child
     * @param TreasureHunt $treasureHunt
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TreasureHunt $treasureHunt){
        //Validating clueAttributes
        $clueAttributes = self::validateCurrentRequest('create');
        //Validating clueEmbeddedVideo
        $clueEmbeddedVideoAttributes = ClueEmbeddedVideoController::validateCurrentRequest('create');
        //Validating clueImage
        $clueImageAttributes = ClueImageController::validateCurrentRequest('create');
        //Sanitizing input
        HelperController::sanitizeArray($clueAttributes);
        HelperController::sanitizeArray($clueImageAttributes);
        HelperController::sanitizeArray($clueEmbeddedVideoAttributes);

        try {
            //Creating and storing the clue
            $clueAttributes['treasure_hunt_id'] = $treasureHunt->id;
            $clue = Clue::create($clueAttributes);
            //Creating clueEmbeddedVideo if requested to
            ClueEmbeddedVideoController::createUpdateOrDeleteOnRequest($clueEmbeddedVideoAttributes, $clue);
            //Creating clueImage if requested to
            ClueImageController::create($clueImageAttributes,$clue);
            //Redirecting to the parent treasureHunt
            return redirect(route('treasureHunt.show',['treasureHunt'=>$treasureHunt->id]))->with('toast',[
                'icon' => 'success',
                'text'=>__('Pista con clave ').$clue->clueKey.__(' creada!')
            ]);
        } catch (\Exception $exception) {
            Log::log('error',$exception->getMessage());
            return redirect()->back()->with('toast',[
                'icon' => 'error',
                'text'=>__('Vaya, ha habido un error.')
            ]);
        }
    }

    /**
     * Returns the clues.edit view
     * @param Clue $clue
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit(Clue $clue){
        return view('clues.edit',[
            'clue'=>$clue,
            'backTo'=>[
                'route'=>route('treasureHunt.show',['treasureHunt'=>$clue->treasure_hunt]),
                'icon'=>'fa-book',
                'name'=>$clue->treasure_hunt->title
            ],
        ]);
    }

    /**
     * Updates a clue, performing a CRUD of its embeddedVideo and image, redirects to treasureHunt.show
     * @param Clue $clue
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Clue $clue){
        //Validating clueAttributes
        $clueAttributes = self::validateCurrentRequest('update');
        //Validating clueEmbeddedVideo
        $clueEmbeddedVideoAttributes = ClueEmbeddedVideoController::validateCurrentRequest(
            ((!empty($clue->embedded_video))?'update':'create') //Validating creation or update depending on current clue state
        );
        //Validating clueImage
        $clueImageAttributes = ClueImageController::validateCurrentRequest(
            ((!empty($clue->image))?'update':'create') //Validating creation or update depending on current clue state
        );
        //Sanitizing input
        HelperController::sanitizeArray($clueAttributes);
        HelperController::sanitizeArray($clueImageAttributes);
        HelperController::sanitizeArray($clueEmbeddedVideoAttributes);
        try {
            //Updating the clue
            $clue->updateOrFail($clueAttributes);
            //Updating, creating or deleting clue's extras depending on request
            //clueEmbeddedVideo
            ClueEmbeddedVideoController::createUpdateOrDeleteOnRequest($clueEmbeddedVideoAttributes, $clue);
            //clueImage
            ClueImageController::createUpdateOrDeleteOnRequest($clueImageAttributes, $clue);
            //Redirecting to the updated treasureHunt
            return redirect(route('treasureHunt.show',['treasureHunt'=>$clue->treasure_hunt->id]))->with('toast',[
                'icon' => 'success',
                'text'=>$clue->title.__(' actualizada!')
            ]);
        } catch (\Throwable | Exception $exception) {
            Log::log('error',$exception->getMessage());
            return redirect()->back()->with('toast',[
                'icon' => 'error',
                'text'=>__('Vaya, ha habido un error.')
            ]);
        }
    }

    /**
     * Deletes a clue and redirects to back() or to the route with the name specified in request('backTo')
     * @param Clue $clue
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Clue $clue){
        try {
            $clue->deleteOrFail();
            //Allowing other routes to go back to if received
            $back =  redirect()->back();
            if(!empty(request('backTo'))){
                $back = redirect(route(request('backTo')));
            }
            return $back->with('toast', [
                'icon' => 'success',
                'text' => __('Has eliminado ') . $clue->title
            ]);
        } catch (\Throwable $e) {
            return redirect()->back()->with('toast', [
                'icon' => 'error',
                'text' => __('Ha habido un error en el borrado')
            ]);
        }
    }

    /**
     * Validates and returns attributes array for update or create
     * @param $method
     * @return array to update, or create
     */
    public static function validateCurrentRequest($method='update'){
        $attributes = [];
        if ($method=='create'||$method=='update'){
            //On creation
            $validation = request()->validate(
                [
                    "title"=>["required"],
                    "body"=>["required"],
                    "footNote"=>["max:255"],
                    "help"=>[],
                    "unlockKey"=>["max:255"],
                    "unlockHint"=>["max:255"],
                ]
            );
            $attributes = $validation;
            if(empty($attributes['unlockKey'])) $attributes['unlockKey'] = 'default';
        }
        return $attributes;

    }
}
