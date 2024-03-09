<?php

namespace App\Http\Controllers\Main\Clue;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperController;
use App\Models\Clue\Clue;
use App\Models\Clue\ClueEmbeddedVideo;
use App\Models\Clue\ClueImage;
use Illuminate\Support\Facades\Storage;

class ClueImageController extends Controller
{
    /**
     * To be run every time a clue is created, only creates an associated clueImage if the validation detected that there was a request
     * @param $validatedAttributes
     * @param Clue $parentClue
     * @return void
     */
    public static function create($validatedAttributes, Clue $parentClue){
        //We'll get populated attributes only if we need to create an image, checking
        if(!empty($validatedAttributes)){
            $validatedAttributes['clue_id'] = $parentClue->id;
            ClueImage::create($validatedAttributes);
        }
    }

    public static function update(){
        //Todo update,  Deletion of the old files, in case of update,will occur on update for $attributes['src'] is not empty
    }

    /**
     * Validates and returns attributes array for update or create, handling the storing of the new files
     * Deletion of the old files, in case of update,will occur on update for $attributes['src'] is not empty
     * @param $method
     * @return array to update, or create, need to check if empty in case of non-necessary operations
     */
    public static function validateCurrentRequest($method='update'){
        $attributes = [];
        if ($method=='create'){
            //On creation
            //Returning populated attributes only if image_src present, required for creation
            if(!empty(request('image_src'))){
                \request()->validate([
                    "image_src"=>['required',"image","max:".env('MAX_CLUE_IMAGE_SIZE')],
                    "image_title"=>["max:255"],
                    "image_caption"=>["max:255"],
                ]);
                //Saving the new image and storing to imageAttributes
                $attributes['src'] = request()->file('image_src')->store('clues/images');
                $attributes["title"] = request('image_title');
                $attributes["caption"] = request('image_caption');
            }
        }else{
            //On update
            //Returning populated attributes even if image_src is not present, for that means we are patching
            \request()->validate([
                "image_src"=>["image","max:".env('MAX_CLUE_IMAGE_SIZE')],
                "image_title"=>["max:255"],
                "image_caption"=>["max:255"],
            ]);
            //Saving the new image and storing to imageAttributes
            if(!empty(request('image_src'))){
                //If img_src is present, we'll save the file, deletion will occur on update for $attributes['src'] is not empty
                $attributes['src'] = request()->file('image_src')->store('clues/images');
            }
            $attributes["title"] =request('image_title');
            $attributes["caption"] =  request('image_caption');
        }
        return $attributes;

    }


    /**
     * Handles the CRUD of this entity
     * -> Create -> Request with valid attributes and no image on this clue
     * -> Update -> Request with valid attributes and no there's an image on this clue
     * -> Delete -> Request with deleteImage present
     * -> Runs on any other situation, does nothing, to be run each time a clue is created or updated with preceding validation
     * @param $validatedAttributes
     * @param Clue $clue
     * @return void
     */
    public static function createUpdateOrDeleteOnRequest($validatedAttributes, Clue $clue){
        if(!empty($clue->image)){
            //There's an image present, update, delete or nothing
            if(!empty(request('deleteImage'))){
                //Delete image request
                $clue->image->deleteOrFail();
            }else if(!empty($validatedAttributes)){
                //Update image request
                if(!empty($validatedAttributes['src'])){
                    //Updating the src, need to delete old file
                    ClueImage::deleteSrcFromStorage($clue->image);
                }
                //Updating
                $clue->image->updateOrFail($validatedAttributes);
            }
            //Nothing
        }else if(!empty($validatedAttributes)){
            //There's no image created and there's a valid request, creating
            $validatedAttributes['clue_id'] = $clue->id;
            ClueImage::create($validatedAttributes);
        }
        //There's no image and no valid requests have been made, do nothing
    }

}
