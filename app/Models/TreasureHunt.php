<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreasureHunt extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

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
}
