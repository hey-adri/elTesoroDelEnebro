<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Clue\Clue;
use Illuminate\Database\Eloquent\Builder;
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


    /**
     *
     * Scope filters supported:
     *  $filters = [
     *  'pro' => true,
     *  'isAdmin' => true,
     *  'search' => 'in username, name or email',
     *  ];
     * @param $query
     * @param array $filters
     * @return mixed
     */
    public function scopeFilter(Builder $query, array $filters, $sortBy = 'updated_at', $sortDirection = 'desc')
    {
        return $query->when($filters['pro'] ?? false, function ( $query) {
            return $query->whereHas('treasure_hunts.clues', function ( $query) {
                $query->whereHas('image')->orWhereHas('embedded_video');
            });
        })
            ->when($filters['has_images'] ?? false, function ($query) {
                return $query->whereHas('treasure_hunts.clues', function ($query) {
                    $query->whereHas('image');
                });
            })
            ->when($filters['has_embedded_videos'] ?? false, function ($query) {
                return $query->whereHas('treasure_hunts.clues', function ($query) {
                    $query->whereHas('embedded_video');
                });
            })
            ->when($filters['isAdmin'] ?? false, function ( $query) {
                return $query->where('isAdmin', true);
            })
            ->when($filters['search'] ?? false, function ( $query, $search) {
                return $query->where(function ( $query) use ($search) {
                    $query->where('username', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->when($sortBy === 'treasure_hunt_count', function ($query) use ($sortDirection) {
                return $query->withCount('treasure_hunts')->orderBy('treasure_hunts_count', $sortDirection);
            }, function ($query) use ($sortBy, $sortDirection) {
                return $query->orderBy($sortBy, $sortDirection);
            });
    }




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
        return Clue::whereIn('treasure_hunt_id', $this->treasure_hunts()->pluck('id'))->get();
    }

    /**
     * Returns the number of one user's pro clues
     * @return mixed
     */
    public function countProClues()
    {
        $user = $this;
        return Clue::whereHas('treasure_hunt', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where(function ($query) {
            $query->whereHas('image')
                ->orWhereHas('embedded_video');
        })->count();
    }

    /**
     * Returns the number of one user's clues with images
     * @return mixed
     */
    public function countCluesWithImages()
    {
        return Clue::whereIn('treasure_hunt_id', $this->treasure_hunts()->pluck('id'))
            ->whereHas('image')
            ->count();
    }

    /**
     * Returns the number of one user's clues with embedded_video
     * @return mixed
     */
    public function countCluesWithEmbeddedVideos()
    {
        return Clue::whereIn('treasure_hunt_id', $this->treasure_hunts()->pluck('id'))
            ->whereHas('embedded_video')
            ->count();
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
        $left = $this->max_pro_clues-$this->countProClues();
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
