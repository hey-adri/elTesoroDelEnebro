<?php

namespace App\Models\Clue;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClueEmbeddedVideo extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    /**
     * One embedded Video belongs to one clue
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clue(){
        return $this->belongsTo(Clue::class,'clue_id');
    }

    /**
     * Returns the appropiate embed link depending on the tipe of the video and the inputLink
     * @param $type
     * @param $inputLink
     * @return string
     */
    private static function generateEmbeddedLink($type, $inputLink){
        switch ($type){
            case 'youtube':
                $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
                $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';

                if (preg_match($longUrlRegex, $inputLink, $matches)) {
                    $youtube_id = $matches[count($matches) - 1];
                }

                if (preg_match($shortUrlRegex, $inputLink, $matches)) {
                    $youtube_id = $matches[count($matches) - 1];
                }
                return 'https://www.youtube.com/embed/' . $youtube_id ;
            default:
                return $inputLink;
        }
    }



    /**
     * Mutators and Accessors
     */

    protected function src(): Attribute
    {
        return Attribute::make(
            set: function (string $value){
                return self::generateEmbeddedLink('youtube',$value); //Generating proper embed link from the input value
            }
        );
    }
}
