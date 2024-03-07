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
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected static function booted()
    {
        parent::booted();
        /**
         * Implementing cascade delete on model
         */
        self::deleting(function (User $user){
            try {
                $user->treasure_hunts->map(fn($treasureHunt)=>$treasureHunt->deleteOrFail());
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
     * Returns all the pro clues of one user
     * @return Collection|\Illuminate\Support\Traits\EnumeratesValues
     */
    public function proClues(){
        return $this->clues()->where(fn($clue)=>$clue->isPro());
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
