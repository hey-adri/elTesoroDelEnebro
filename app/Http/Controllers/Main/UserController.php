<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperController;
use App\Models\Clue\Clue;
use App\Models\TreasureHunt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Returns the users.edit view
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit(User $user){
        return view('users.edit',[
            'user'=>$user,
            'backTo'=>[
                'route'=>route('userArea.index'),
                'icon'=>'fa-user',
                'name'=>__('Área Personal')
            ],
        ]);
    }

    /**
     * Updates one user
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user){
        //Validating current request
        $attributes = self::validateCurrentRequest('update',$user);

        //Sanitizing input
        HelperController::sanitizeArray($attributes);

        try {
            //Updating the user
            $user->updateOrFail($attributes);
            //Redirecting back
            return redirect()->route('userArea.index')->with('toast',[
                'icon' => 'success',
                'text'=>__('Actualización correcta.')
            ]);
        } catch (\Throwable | \Exception $exception) {
            Log::log('error',$exception->getMessage());
            return redirect()->back()->with('toast',[
                'icon' => 'error',
                'text'=>__('Vaya, ha habido un error.')
            ]);
        }
    }

    public function destroy(User $user){
        try {
            self::deleteProfileImageFromStorage($user);
            $user->deleteOrFail();
            auth()->logout();
            return redirect()->route('home')->with('toast', [
                'icon' => 'success',
                'text' => __('Cuenta Eliminada, Hasta Pronto')
            ]);
        } catch (\Throwable $e) {
            return redirect()->back()->with('toast', [
                'icon' => 'error',
                'text' => __('Ha habido un error en el borrado')
            ]);
        }
    }

    /**
     * Validates and returns attributes array for update or create
     * @param $method
     * @param null $user User to update, in case of update
     * @return array to update, or create
     */
    public static function validateCurrentRequest($method='create', $user=null){
        $attributes = [];
        if ($method=='create'){
            //On creation
            $attributes = request()->validate(
                [
                    "name"=>["required","max:255"],
                    "email"=>["required","email","max:255",Rule::unique('users','email')],
                    "username"=>["required","regex:/^(?=.{4,20}$)[a-z0-9._-]+$/",Rule::unique('users','username')],
                    "password"=>["required","regex:/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\d$&+,:;=?@#|'<>.^*()%! -]{8,30}$/","max:255"],
                ]
            );
            //Adding default max_pro_clues
            $attributes['max_pro_clues'] = env('USER_INITIAL_PRO_CLUES');
        }else if ($method=='update'){
            //On update
            //Validating required attributes
            $attributes = request()->validate(
                [
                    "name"=>["required","max:255"],
                    "email"=>["required","email","max:255",Rule::unique('users','email')->ignore($user->id,'id')], //Ignoring this user's fields in unique
                    "username"=>["required","regex:/^(?=.{4,20}$)[a-z0-9._-]+$/",Rule::unique('users','username')->ignore($user->id,'id')], //Ignoring this user's fields in unique
                ]
            );

            //Validating optional attributes
            if(!empty(\request("password"))){
                //Received a password, validating
                \request()->validate([
                    "password"=>["required","regex:/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\d$&+,:;=?@#|'<>.^*()%! -]{8,30}$/","max:255"],
                ]);
                //Storing the password to attributes
                $attributes['password'] = request("password");
            }
            if(!empty(\request('profile_image'))){
                //Received an image, validating
                \request()->validate([
                    "profile_image"=>["image","max:".env('MAX_PROFILE_IMAGE_SIZE')], //Image should be of type image
                ]);
                //Saving the new image and storing to attributes
                $attributes['profile_image'] = request()->file('profile_image')->store('user/profileImages');
                self::deleteProfileImageFromStorage($user);
            }

            //Deleting Profile image if requested
            if(!empty(\request('deleteImage'))) self::deleteProfileImageFromStorage($user);
        }

        //Having into account AdminFeaturesFields only if there's an admin signed in
        if(auth()?->user()?->isAdmin){
            $attributes= array_merge($attributes, \request()->validate([
                'isAdmin'=>['nullable','boolean'],
                'max_pro_clues'=>['nullable','integer']
            ]));
        }
        return $attributes;

    }

    /**
     * Sets an user Default profile image
     * @param User $user
     * @return void
     */
    protected static function setDefaultProfileImage(User $user){
        $user->profile_image = User::getRandomProfileImagePath();
    }

    /**
     * Deletes an user image if it isn't the default one and sets the default
     * @param User $user
     * @return void
     */
    protected static function deleteProfileImageFromStorage(User $user){
        if(!User::isImagePathDefault($user->profile_image)){
            if(Storage::exists($user->profile_image)){
                Storage::delete($user->profile_image);
            }
            self::setDefaultProfileImage($user);
        }
    }


}
