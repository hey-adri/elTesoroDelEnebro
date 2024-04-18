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
        $query->when($filters['pro'] ?? false, function ( $query, $pro) {
            if ($pro) {
                $query->whereHas('clues', function ($query) {
                    $query->whereHas('image')->orWhereHas('embedded_video');
                });
            }
        })
            ->when($filters['has_images'] ?? false, function ( $query, $pro) {
                if ($pro) {
                    $query->whereHas('clues', function ($query) {
                        $query->whereHas('image');
                    });
                }
            })
            ->when($filters['has_embedded_videos'] ?? false, function ( $query, $pro) {
                if ($pro) {
                    $query->whereHas('clues', function ($query) {
                        $query->whereHas('embedded_video');
                    });
                }
            })
            ->when($filters['username'] ?? false, function ( $query, $username) {
                $query->whereHas('owner', function ( $query) use ($username) {
                    $query->where('username', $username);
                });
            })
            ->when($filters['search'] ?? false, function ( $query, $search) {
                $query->where(function ( $query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhereHas('owner', function ( $query) use ($search) {
                            $query->where('username', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($filters['search_internal'] ?? false, function ( $query, $searchInternal) {
                $query->where(function ( $query) use ($searchInternal) {
                    $query->where('title', 'like', '%' . $searchInternal . '%')
                        ->orWhereHas('clues', function ( $query) use ($searchInternal) {
                            $query->where('title', 'like', '%' . $searchInternal . '%');
                        });
                });
            });
        if($sortBy=='updated_at'){
            //Sorting by most recent, having in account treasureHunts and their clues, whichever is latest
            if($sortDirection=='desc')
            $query->orderByDesc(function ($query) {
                $query->selectRaw('GREATEST(treasure_hunts.updated_at, COALESCE((SELECT MAX(updated_at) FROM clues WHERE treasure_hunt_id = treasure_hunts.id), \'1970-01-01 00:00:00\'))'); //Using coalesce to provide default date in case there are no clues
            });
            else
            $query->orderBy(function ($query) {
                $query->selectRaw('GREATEST(treasure_hunts.updated_at, COALESCE((SELECT MAX(updated_at) FROM clues WHERE treasure_hunt_id = treasure_hunts.id), \'9999-01-01 00:00:00\'))'); //Using coalesce to provide default date in case there are no clues
            });
        }else if ($sortBy === 'clues_count') {
            // Sort by the number of associated clues
                $query->withCount('clues')->orderBy('clues_count', $sortDirection);
        }if ($sortBy === 'pro_clues_count') {
            // Sort by the number of associated clues with images or embedded videos
            $query->withCount(['clues' => function ($query) {
                $query->whereHas('image')->orWhereHas('embedded_video');
            }])
            ->orderBy('clues_count', $sortDirection);
        }else{
            //Sort by attributes
            $query->orderBy($sortBy, $sortDirection);
        }
        return $query;

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
        return $this->clues()
                ->where(function ($query) {
                    $query->whereHas('image')->orWhereHas('embedded_video');
                })
                ->get();
    }


    /**
     * A treasure hunt is pro if it has pro clues
     * @return bool
     */
    public function isPro(){
        return (($this->clues()->where(function ($query) {
                $query->whereHas('image')->orWhereHas('embedded_video');
            })->count())>0);
    }

    /**
     * Get the count of pro clues
     *
     * @return int
     */
    public function proCluesCount()
    {
        return $this->clues()
            ->where(function ($query) {
                $query->whereHas('image')->orWhereHas('embedded_video');
            })
            ->count();
    }


    public function countCluesWithImages(){
        return $this->clues()->whereHas('image')->count();
    }

    public function countCluesWithEmbeddedVideos(){
        return $this->clues()->whereHas('embedded_video')->count();
    }
    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => ucfirst($value),
        );
    }
}
