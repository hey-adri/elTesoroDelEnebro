<?php

namespace App\Http\Controllers\Main\Clue;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperController;
use App\Models\Clue\Clue;
use App\Models\Clue\ClueEmbeddedVideo;

class ClueEmbeddedVideoController extends Controller
{
    /**
     * Validates and returns attributes array for update or create
     * @param $method
     * @return array to update, or create, need to check if empty in case of non-necessary operations
     */
    public static function validateCurrentRequest($method='update'){
        $attributes = [];
        if ($method=='create'){
            //On creation
            //Creating only if user has some pro clues left
            if(auth()?->user()?->proCluesLeft()>0){
                //Returning populated attributes only if embedded_video_src present, required for creation
                if(!empty(request('embedded_video_src'))){
                    $validation = \request()->validate([
                        "embedded_video_src"=>['required',"regex:/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube(-nocookie)?\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|live\/|v\/)?)([\w\-]+)(\S+)?$/"],
                        "embedded_video_title"=>["max:255"],
                        "embedded_video_caption"=>["max:255"],
                    ]);
                    //Saving the new image and storing to imageAttributes
                    $attributes['src'] = request('embedded_video_src');
                    $attributes["title"] = request('embedded_video_title');
                    $attributes["caption"] = request('embedded_video_caption');
                }
            }
        }else{
            //On update
            //Returning populated attributes even if embedded_video_src is not present, for that means we are patching
            $validation = \request()->validate([
                "embedded_video_src"=>["regex:/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube(-nocookie)?\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|live\/|v\/)?)([\w\-]+)(\S+)?$/"],
                "embedded_video_title"=>["max:255"],
                "embedded_video_caption"=>["max:255"],
            ]);
            if(!empty(request('embedded_video_src')))
            //Saving the new image and storing to imageAttributes
            $attributes['src'] = request('embedded_video_src');
            $attributes["title"] = request('embedded_video_title');
            $attributes["caption"] = request('embedded_video_caption');
        }
        return $attributes;

    }

    /**
     * Handles the CRUD of this entity
     * -> Create -> Request with valid attributes and no embedded_video on this clue
     * -> Update -> Request with valid attributes and no there's an embedded_video on this clue
     * -> Delete -> Request with deleteEmbeddedVideo present
     * -> Runs on any other situation, does nothing, to be run each time a clue is created or updated with preceding validation
     * @param $validatedAttributes
     * @param Clue $clue
     * @return void
     */
    public static function createUpdateOrDeleteOnRequest($validatedAttributes, Clue $clue){
        if(!empty($clue->embedded_video)){
            //There's a video present, update, delete or nothing
            if(!empty(request('deleteEmbeddedVideo'))){
                //Delete video request
                $clue->embedded_video->deleteOrFail();
            }else if(!empty($validatedAttributes)){
                //Update video request
                $clue->embedded_video->updateOrFail($validatedAttributes);
            }
            //Nothing
        }else if(!empty($validatedAttributes)){
            //There's no embedded_video created and there's a valid request, creating
            $validatedAttributes['clue_id'] = $clue->id;
            ClueEmbeddedVideo::create($validatedAttributes);
        }
        //There's no video and no valid requests have been made, do nothing
    }
}
