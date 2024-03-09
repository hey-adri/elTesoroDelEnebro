<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
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
}
