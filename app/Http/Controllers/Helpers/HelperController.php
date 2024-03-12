<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Models\Clue\Clue;
use App\Models\Clue\ClueImage;
use App\Models\TreasureHunt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class HelperController extends Controller
{
    public static function sanitizeArray(Array &$array){
        foreach ($array as $key => $value){
            if(gettype($value)=='string')
            $array[$key] = str_replace('<','&lt;',
                str_replace('>','&gt;',$value)
            );
        }
    }

    /**
     * Removes all null values from arrays, used after validation cleanup
     * @param array $array
     * @return void
     */
    public static function removeNullValuesFromArray(Array &$array){
        foreach ($array as $key => $value){
            if($array[$key]===null)
               unset($array[$key]);
        }
    }

    /**
     * Generates Localized Demo clues, to be called on seeder in production
     * @param User $user the admin user who will own the demo clues
     * @return void
     */
    public static function generateLocalizedDemoClues(User $user){
        //Creating Demo Treasure Hunt for user
        $treasureHunt = TreasureHunt::create([
            'title'=>'Demo',
            'user_id'=>$user->id
        ]);

        //Creating Clues for each locale
        $availableLocales = array_values(config('app.available_locales'));
        foreach ($availableLocales as $locale){
            //Translating clue to specific locale
            $clueAttributes=[
                'title'=> __('El significado del Tesoro del Enebro',[],$locale),
                'body'=> __("Cuenta la leyenda, que, en lo más profundo de las marismas, entre chumberas y pinos, un viejo sabio enterró su Tesoro junto a un Enebro.\r\n\r\nLos lugareños, cuando se enteraron de que eso era así, se lanzaron a la búsqueda del tesoro del anciano, pero por más que buscaron, no encontraron nada especial.\r\n\r\nPasado un tiempo, se le preguntó al sabio ¿Qué era aquello tan preciado que había escondido? \r\n\r\nAnte esto, el sabio respondió que no había escondido nada. Su tesoro había sido el poder dar un paseo con su nieto y descansar a la sombra de aquel Enebro.\r\n\r\nSu tesoro había sido el poder haber compartido un momento, totalmente presente, con sus seres queridos.\r\n\r\nDe aquí, El Tesoro del Enebro, un proyecto con la intención de motivarnos a pasar momentos con aquellos que nos rodean, cara a cara, siendo conscientes de nuestra suerte de poder seguir estando con ellos.",[],$locale),
                'footNote'=> __('Para nosotros este es el verdadero tesoro.',[],$locale),
                'treasure_hunt_id'=>$treasureHunt->id
            ];
            //Creating clue
            $clue =Clue::create($clueAttributes);
            //Setting custom clueKey, overwritten by defauld
            $clue->update([
                'clueKey'=> strtoupper("DEMO_".$locale)
            ]);
            $imageAttributes=[
                'src'=>asset('assets/img/homeImages/demoImage.jpg'),
                'clue_id'=>$clue->id
            ];
            //Creating image
            ClueImage::create($imageAttributes);

        }

    }
}
