<?php

namespace App\Models\Clue;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ClueImage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        parent::booted();
        self::deleting(function (ClueImage $clueImage){
            //Deleting image from storage on model deletion
            self::deleteSrcFromStorage($clueImage);
        });
    }

    /**
     * One image belongs to one clue
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clue(){
        return $this->belongsTo(Clue::class,'clue_id');
    }

    /**
     * Deletes the src referenced file
     * @return void
     */
    public static function deleteSrcFromStorage(ClueImage $clueImage){
        //We'll delete the old referenced file if it can be deleted
        if($clueImage->src && Storage::exists($clueImage->src)){
            Storage::delete($clueImage->src);
        }
    }
}
