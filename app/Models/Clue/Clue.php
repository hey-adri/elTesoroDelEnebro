<?php

namespace App\Models\Clue;

use App\Models\TreasureHunt;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Clue extends Model
{
    use HasFactory;

    protected $guarded=['id'];
    protected $with = ['image','embedded_video'];

    /**
     * Scope filters supported:
     * $filters = [
     * 'has_image' => true,
     * 'has_embedded_video' => false,
     * 'pro' => true,
     * 'username' => 'example_username',
     * 'search' => 'example_search_string',
     * ];
     * @param $query
     * @param array $filters
     * @return mixed
     */
    public function scopeFilter($query, array $filters, $sortBy = 'updated_at', $sortDirection = 'desc')
    {
        $query->when($filters['has_image'] ?? false, function ($query, $hasImage) {
            return $query->whereHas('image');
        })
            ->when($filters['has_embedded_video'] ?? false, function ($query, $hasEmbeddedVideo) {
                return $query->whereHas('embedded_video');
            })
            ->when($filters['pro'] ?? false, function ($query, $isPro) {
                return $query->whereHas('image')
                    ->orWhereHas('embedded_video');
            })
            ->when($filters['username'] ?? false, function ($query, $username) {
                return $query->whereHas('treasure_hunt.owner', function ($query) use ($username) {
                    $query->where('username', $username);
                });
            })
            ->when($filters['search_internal'] ?? false, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('body', 'like', '%' . $search . '%')
                        ->orWhere('help', 'like', '%' . $search . '%')
                        ->orWhere('clueKey', 'like', '%' . $search . '%')
                        ->orWhere('footNote', 'like', '%' . $search . '%');
                });
            })
            ->when($filters['search'] ?? false, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('clueKey', 'like', '%' . $search . '%')
                        ->orWhere('unlockKey', 'like', '%' . $search . '%')
                        ->orWhereHas('treasure_hunt', function ($query) use ($search) {
                            $query->where('title', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('treasure_hunt.owner', function ($query) use ($search) {
                            $query->where('username', 'like', '%' . $search . '%');
                        });
                });
            });
        //Custom sorting
        $query->orderBy($sortBy, $sortDirection);
        return $query;

    }

    //Upon clue creation, we'll generate an unique clueKey, making sure it doesn't exist already
    protected static function boot()
    {
        parent::boot();
        self::creating(function (Clue $clue){
            $clue->clueKey = self::generateRandomClueKey();
            //Making sure the order stays consistent
            if(!$clue->order) $clue->order = $clue->treasure_hunt->clues()->count()+1;
            else{
                //There's a order on creation, not from seeder, reorder clues
                self::orderChanged($clue,null,$clue->order);
            }
        });
    }

    protected static function booted()
    {
        parent::booted();
        /**
         * Implementing cascade delete on model
         */
        self::deleting(function (Clue $clue){
            try {
                if(isset($clue->image)){
                    $clue->image->deleteOrFail();
                }
                if(isset($clue->embedded_video)){
                    $clue->embedded_video->deleteOrFail();
                }
            }catch (\Exception $exception){
                Log::log('error',$exception->getMessage());
            }
            //Reordering clues
            self::orderChanged($clue,$clue->order,null);
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
     * A Pro clue is one that has either a video or an image
     * @return bool
     */
    public function isPro(){
        return (($this->image)||($this->embedded_video));
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

    /**
     * Reorders the clues so that they stay consistently ordered, to be called on delete, create and update
     * @param int|null $oldValue null on create
     * @param int|null $newValue null on delete
     * @return void
     * @throws \Exception
     */
    public static function orderChanged(Clue $clue, int|null $oldValue, int|null $newValue){
        if ($oldValue!=$newValue){
            if($oldValue){
                //If there's an old value, we'll decrement all subsequent clues to fill the spot
                //Querying all affected clues, straight from the database, to perform a mass update
                $query = DB::table('clues')
                    ->where('treasure_hunt_id', $clue->treasure_hunt_id)
                    ->where('order', '>', $oldValue)
                    ->where('id', '!=', $clue->id) //Excluding this clue to prevent changes
                    ->decrement('order');
            }
            if($newValue){
                //If there's a nes value, we'll shift all the clues to make room for this one
                $query = DB::table('clues')
                    ->where('treasure_hunt_id', $clue->treasure_hunt_id)
                    ->where('order', '>=', $newValue)
                    ->where('id', '!=', $clue->id) //Excluding this clue to prevent changes
                    ->increment('order');
            }
        }
    }

    /**
     * Mutators and Accessors
     */

    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => ucfirst($value),
        );
    }

    protected function clueKey(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtoupper($value),
            set: fn (string $value) => strtoupper($value),
        );
    }

}
