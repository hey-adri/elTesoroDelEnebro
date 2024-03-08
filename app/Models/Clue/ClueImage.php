<?php

namespace App\Models\Clue;

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
            if(Storage::exists($clueImage->src)){
                Storage::delete($clueImage->src);
            }
        });
    }

    /**
     * One image belongs to one clue
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clue(){
        return $this->belongsTo(Clue::class,'clue_id');
    }
}
