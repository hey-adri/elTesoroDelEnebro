<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Clue\Clue;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];

    //Upon clue creation, we'll generate a random profile image if not set
    protected static function boot()
    {
        parent::boot();
        self::creating(function (User $user){
            if(empty($user->profile_image)) $user->profile_image = self::getRandomProfileImagePath();
        });
    }

    protected static function booted()
    {
        parent::booted();

        self::deleting(function (User $user){
            try {
                //Implementing cascade delete on model
                $user->treasure_hunts->map(fn($treasureHunt)=>$treasureHunt->deleteOrFail());
                //Deleting profile picture from storage
                if((!User::isImagePathDefault($user->profile_image)) && (Storage::exists($user->profile_image))){
                    Storage::delete($user->profile_image);
                }
            }catch (\Exception $exception){
                Log::log('error',$exception->getMessage());
            }
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * One user is the owner of many treasureHunts
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function treasure_hunts(){
        return $this->hasMany(TreasureHunt::class);
    }


    /**
     * Returns all the clues of this user
     * @return Collection
     */
    public function clues(){
        $treasureHunts = $this->treasure_hunts()->with('clues')->get();
        $clues = new Collection([]);
        foreach ($treasureHunts as $treasureHunt){
            $clues = $clues->merge($treasureHunt->clues);
        }
        return $clues;
    }

    /**
     * Returns all the pro clues of this user
     * @return mixed
     */
    public function proClues(){
        $user = $this;
        return Clue::whereHas('treasure_hunt', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where(function ($query) {
            $query->whereHas('image')
                ->orWhereHas('embedded_video');
        })->get();
    }

    /**
     * Returns the number of pro clues that an user has left
     * @return int|mixed
     */
    public function proCluesLeft(){
        $left = $this->max_pro_clues-count($this->proClues());
        return ($left>0? $left: 0);
    }

    /**
     * Returns an array of all the available default profile images
     * @return array
     */
    public static function getDefaultProfileImagesPaths(){
        $rootPath = "defaults/user/profileImages/";
        $paths = [];
        for($i = 1; $i<5;$i++){
            $paths[]=$rootPath."defaultProfileImage".$i.".jpg";
        }
        return $paths;
    }

    /**
     * Returns a random default profile images
     * @return string
     */
    public static function getRandomProfileImagePath(){
        $defaultImages = self::getDefaultProfileImagesPaths();
        return $defaultImages[array_rand($defaultImages)];
    }

    /**
     * Returns if an image is a default one
     * @param $imagePath
     * @return bool
     */
    public static function isImagePathDefault($imagePath){
        $rootPath = "defaults/user/profileImages/";
        return str_contains($imagePath,$rootPath);
    }

    /**
     * Mutators and Accessors
     */

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucwords($value),
            set: fn (string $value) => ucwords($value),
        );
    }
    protected function username(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtolower($value),
            set: fn (string $value) => strtolower($value),
        );
    }


}
