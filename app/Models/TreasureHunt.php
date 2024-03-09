<?php

namespace App\Models;

use App\Models\Clue\Clue;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Log;

class TreasureHunt extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Scope filters supported:
     * $filters = [
     * 'username' => 'example_username',
     * 'pro' => true,
     * 'search' => 'in owner's username or title',
     * 'searchInternal' => 'in title',
     * ];
     * @param $query
     * @param array $filters
     * @return mixed
     */
    public function scopeFilter($query, array $filters, $sortBy = 'updated_at', $sortDirection = 'desc')
    {
        return $query->when($filters['pro'] ?? false, function (Builder $query, $pro) {
            if ($pro) {
                $query->whereHas('clues', function (Builder $query) {
                    $query->whereHas('image')->orWhereHas('embedded_video');
                });
            }
        })
            ->when($filters['username'] ?? false, function (Builder $query, $username) {
                $query->whereHas('owner', function (Builder $query) use ($username) {
                    $query->where('username', $username);
                });
            })
            ->when($filters['search'] ?? false, function (Builder $query, $search) {
                $query->where(function (Builder $query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhereHas('owner', function (Builder $query) use ($search) {
                            $query->where('username', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($filters['searchInternal'] ?? false, function (Builder $query, $searchInternal) {
                $query->whereHas('clues', function (Builder $query) use ($searchInternal) {
                    $query->where('title', 'like', '%' . $searchInternal . '%');
                });
            })
            ->orderBy($sortBy, $sortDirection);
    }

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
        $latestTreasureHuntUpdate = $this->updated_at;

        // Get the latest update date of clues, if any
        $latestClueUpdate = $this->clues()->latest('updated_at')->value('updated_at');

        // Compare and update $latestTreasureHuntUpdate if necessary
        if ($latestClueUpdate && $latestClueUpdate->gt($latestTreasureHuntUpdate)) {
            $latestTreasureHuntUpdate = $latestClueUpdate;
        }

        return $latestTreasureHuntUpdate;
    }

    /**
     * Returns all the Pro Clues in a treasure Hunt
     * @return mixed
     */
    public function proClues(){
        return $this->clues()->whereHas('image')->orWhereHas('embedded_video')->get();
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
