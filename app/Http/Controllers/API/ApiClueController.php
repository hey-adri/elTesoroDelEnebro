<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Clue\Clue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class ApiClueController extends Controller
{
    public function show(string $clueKey){
        //Getting the unlockKey from the request if it is set
        $unlockKey = request('unlock_key');
        $response = [
            'data'=>[]
        ];
        try {
            //Finding of Failing by clueKey field
            $clue = Clue::firstWhere('clueKey',$clueKey);
            if(empty($clue)) throw new ModelNotFoundException('No clue found for key '.$clueKey);

            //Clue exists, checking if the unlockKey received will unlock it
            if($this->checkUnlockKey($clue,$unlockKey)){
                //Clue unlocked
                $response['message']="Congrats! You've successfully unlocked a clue";
                $response['data']['locked']=false;
                $response['data']['treasure_hunt']=[
                    'title'=>$clue->treasure_hunt->title
                ];
                $response['data']['owner']=[
                    'name'=>$clue->treasure_hunt->owner->name
                ];
                //Removing all the sensitive data from clue before sending
                unset(
                    $clue->id,
                    $clue->unlockKey,
                    $clue->unlockHint,
                    $clue->image->id,
                    $clue->image->clue_id,
                    $clue->treasure_hunt_id,
                    $clue->embedded_video->id,
                    $clue->embedded_video->clue_id,
                    $clue->treasure_hunt
                );
                $response['data']['clue']=$clue;
            }else{
                //Clue Locked
                $response['message']="You've found a Clue but it seems locked, you'll need to provide the 'unlockKey' as a parameter to get the Clue's contents";
                $response['data']['locked']=true;
                if($clue->unlockHint==null){
                    $response['data']['unlock_hint']="default";
                }else{
                    $response['data']['unlock_hint']=$clue->unlockHint;
                }
                $response['data']['clue']=[
                    'title'=>$clue->title
                ];
            }


            return response($response,200);

        }catch (ModelNotFoundException $e){
            //Error handling
            $response['error']=$e->getMessage();
            return response($response,404);
        }

    }

    /**
     * Checks whether the unlockKey will unlock a hint, without having in mind casing, spaces or punctuation
     * @param Clue $clue
     * @param string|null $testUnlockKey
     * @return bool Whether the unlock key is correct or not
     */
    private function checkUnlockKey(Clue $clue, string|null $testUnlockKey){
        if(empty($testUnlockKey)) return false;
        return (Str::lower(preg_replace("#[[:punct:]\\s]#", "", $clue->unlockKey))) == (Str::lower(preg_replace("#[[:punct:]\\s]#", "", $testUnlockKey)));
    }
}
