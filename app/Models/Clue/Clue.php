<?php

namespace App\Models\Clue;

use App\Models\TreasureHunt;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        return $query->when($filters['has_image'] ?? false, function ($query, $hasImage) {
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
            ->when($filters['search'] ?? false, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('body', 'like', '%' . $search . '%')
                        ->orWhere('help', 'like', '%' . $search . '%')
                        ->orWhere('clueKey', 'like', '%' . $search . '%')
                        ->orWhere('footNote', 'like', '%' . $search . '%');
                });
            })->orderBy($sortBy, $sortDirection);
    }

    //Upon clue creation, we'll generate an unique clueKey, making sure it doesn't exist already
    protected static function boot()
    {
        parent::boot();
        self::creating(function (Clue $clue){
            $clue->clueKey = self::generateRandomClueKey();
            $clue->order = $clue->treasure_hunt->clues()->count()+1;
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
