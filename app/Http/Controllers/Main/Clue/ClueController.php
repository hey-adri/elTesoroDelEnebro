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
        return view('clues.create',[
            'treasureHunt'=>$treasureHunt
        ]);
    }
    public function store(TreasureHunt $treasureHunt){
        //Validating core Attributes
        $clueAttributes = request()->validate(
            [
                "title"=>["required"],
                "body"=>["required"],
                "footNote"=>["max:255"],
                "help"=>[]
            ]
        );
        //Validating interDependent attributes
        //UnlockKey
        if (!empty(request('unlockKey'))){
            request()->validate(
                [
                    "unlockKey"=>["max:255"],
                    "unlockHint"=>["required","max:255"],
                ]
            );
            $clueAttributes["unlockKey"] = request('unlockKey');
            $clueAttributes["unlockHint"] = request('unlockHint');
        }
        //Clue EmbeddedVideo
        $videoAttributes = [];
        if(!empty(request('embedded_video_src'))){
            $videoValidation = \request()->validate([
                "embedded_video_src"=>["regex:/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube(-nocookie)?\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|live\/|v\/)?)([\w\-]+)(\S+)?$/"],
                "embedded_video_title"=>["max:255"],
                "embedded_video_caption"=>["max:255"],
            ]);
            //Saving the new image and storing to imageAttributes
            $videoAttributes['src'] = $videoValidation['embedded_video_src'];
            $videoAttributes["title"] = $videoValidation['embedded_video_title'];
            $videoAttributes["caption"] = $videoValidation['embedded_video_caption'];
        }
        //Clue Image
        $imageAttributes = [];
        if(!empty(request('image_src'))){
            $imageValidation = \request()->validate([
                "image_src"=>["image","max:".env('MAX_CLUE_IMAGE_SIZE')],
                "image_title"=>["max:255"],
                "image_caption"=>["max:255"],
            ]);
            //Saving the new image and storing to imageAttributes
            $imageAttributes['src'] = request()->file('image_src')->store('clues/images');
            $imageAttributes["title"] = $imageValidation['image_title'];
            $imageAttributes["image_caption"] = $imageValidation['image_caption'];
        }
        //Sanitizing input
        HelperController::sanitizeArray($clueAttributes);
        HelperController::sanitizeArray($clueAttributes);
        $clueAttributes['treasure_hunt_id'] = $treasureHunt->id;
        try {
            //Creating and storing the clue
            $clue = Clue::create($clueAttributes);
            //Creating video if set
            if(!empty($videoAttributes)){
                $videoAttributes['clue_id'] = $clue->id;
                ClueEmbeddedVideo::create($videoAttributes);
            }
            //Creating Image if set
            if(!empty($imageAttributes)){
                $imageAttributes['clue_id'] = $clue->id;
                ClueImage::create($imageAttributes);
            }
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
