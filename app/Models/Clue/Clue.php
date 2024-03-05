<?php

namespace App\Models\Clue;

use App\Models\TreasureHunt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Clue extends Model
{
    use HasFactory;

    protected $guarded=['id','clueKey'];
    protected $with = ['image','embedded_video'];

    //Upon clue creation, we'll generate an unique clueKey, making sure it doesn't exist already
    protected static function boot()
    {
        parent::boot();
        self::creating(function (Clue $clue){
            $clue->clueKey = self::generateRandomClueKey();
        });
    }

    protected static function booted()
    {
        parent::booted();
        self::deleting(function (Clue $clue){
            if(isset($clue->image)){
                //Todo delete clue image from Storage
                echo 'Todo delete clue image: '.$clue->image->title;
            }
        });
    }


    /**
     * One Clue belongs to one treasure hunt
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function treasure_hunt(){
        return $this->belongsTo(TreasureHunt::class,'treasure_hunt_id');
    }

    /**
     * One clue May have one image
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function image(){
        return $this->hasOne(ClueImage::class);
    }

    /**
     * One clue May have one embeddedVideo
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function embedded_video(){
        return $this->hasOne(ClueEmbeddedVideo::class);
    }

    /**
     * Returns a random clueKey making sure it's unique
     * @return string
     */
    public static function generateRandomClueKey(){
        //Getting the minimum length from .env
        $length = env('CLUE_KEY_MIN_LENGTH');
        $length+=floor(
            log(
                (Clue::count()<1?1:Clue::count()),
                26
            )
        ); //Adding to the minimum length based on the number of already existing clues
        do{
            $generatedKey = strtoupper(Str::random($length)); //Generating a random key, making sure it's unique
        }while (Clue::pluck('clueKey')->contains($generatedKey));
        return $generatedKey;
    }
}
