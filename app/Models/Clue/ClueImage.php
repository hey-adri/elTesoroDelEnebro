<?php

namespace App\Models\Clue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClueImage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * One image belongs to one clue
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clue(){
        return $this->belongsTo(Clue::class,'clue_id');
    }
}
