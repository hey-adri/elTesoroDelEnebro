<?php

namespace App\Models;

use App\Models\Clue\Clue;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class TreasureHunt extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        parent::booted();
        /**
         * Implementing cascade delete on model
         */
        self::deleting(function (TreasureHunt $treasureHunt){
            try {
                $treasureHunt->clues->map(fn($clue)=>$clue->deleteOrFail());
            }catch (\Exception $exception){
                Log::log('error',$exception->getMessage());
            }
        });
    }

    /**
     * One treasure hunt belongs to an owner user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(){
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * One treasure hunt has many clues
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clues(){
        return $this->hasMany(Clue::class);
    }

    /**
     * Returns the last update of the treasure hunt or its clues, whichever is more recent=
     */
    public function getLastUpdate(){
        $latestClue =  Clue::latest()->where('treasure_hunt_id','=',$this->id)->first();
        if($latestClue){
            return $this->updated_at>$latestClue->updated_at?$this->updated_at:$latestClue->updated_at;
        }else{
            return $this->updated_at;
        }
    }

    /**
     * Returns all the Pro Clues in a treasure Hunt
     * @return mixed
     */
    public function proClues(){
        $proClues = $this->clues->where(fn($clue)=>$clue->isPro());
        return $proClues;
    }

    /**
     * A treasure hunt is pro if it has pro clues
     * @return bool
     */
    public function isPro(){
        if(count($this->proClues())>0) return true;
        else return false;
    }

    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => ucfirst($value),
        );
    }
}
