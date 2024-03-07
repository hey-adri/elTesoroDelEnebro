<?php

namespace App\Models\Clue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClueImage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        parent::booted();
        self::deleting(function (ClueImage $clueImage){
            //Todo delete clue image from Storage
            echo 'Todo delete clue image: '.$clueImage->title;
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
