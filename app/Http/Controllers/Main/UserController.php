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
    public function index(){
        return 'todo';
//        $treasure_hunts = TreasureHunt::latest()->where('user_id','=',auth()->user()->id)->paginate(3);
//        return view('treasureHunts.userArea.index',[
//            'treasure_hunts'=>$treasure_hunts
//        ]);
    }
    public function show(User $user){
        return 'todo';
//        return view('treasureHunts.show',[
//            'treasureHunt'=>$treasureHunt
//        ]);
    }
    public function create(){
//        return view('treasureHunts.create');
        return 'todo';
    }
    public function store(){
//        $attributes = request()->validate(
//            [
//                "title"=>["required","max:255"],
//            ]
//        );
//        HelperController::sanitizeArray($attributes); //Sanitizing input
//        $attributes['user_id'] = auth()->user()->id;
//        try {
//            //Creating and storing the treasureHunt
//            $treasureHunt = TreasureHunt::create(
//                $attributes
//            );
//            //Redirecting to the new treasureHunt
//            return redirect(route('treasureHunt.show',['treasureHunt'=>$treasureHunt->id]))->with('toast',[
//                'icon' => 'success',
//                'text'=>$treasureHunt->title.__(' creada!')
//            ]);
//        } catch (Exception $exception) {
//            Log::log('error',$exception->getMessage());
//            return redirect()->back()->with('toast',[
//                'icon' => 'error',
//                'text'=>__('Vaya, ha habido un error.')
//            ]);
//        }
        return 'todo';
    }

    public function edit(User $user){
        return view('users.edit',[
            'user'=>$user
        ]);
    }

    public function update(User $user){
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
            $this->deleteProfileImageFromStorage($user);
        }

        //Deleting Profile image if requested
        if(!empty(\request('deleteImage'))) $this->deleteProfileImageFromStorage($user);

        //Sanitizing input
        HelperController::sanitizeArray($attributes);

        try {
            //Updating the user
            $user->updateOrFail($attributes);
            //Redirecting back
            return redirect()->back()->with('toast',[
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
            $this->deleteProfileImageFromStorage($user);
            $user->deleteOrFail();
            session()->flash('toast', [
                'icon' => 'success',
                'text' => __('Cuenta Eliminada, Hasta Pronto')
            ]);
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
     * Sets an user Default profile image
     * @param User $user
     * @return void
     */
    private function setDefaultProfileImage(User $user){
        $user->profile_image = User::getRandomProfileImagePath();
    }

    /**
     * Deletes an user image if it isn't the default one and sets the default
     * @param User $user
     * @return void
     */
    private function deleteProfileImageFromStorage(User $user){
        if(!User::isImagePathDefault($user->profile_image)){
            if(Storage::exists($user->profile_image)){
                Storage::delete($user->profile_image);
            }
            self::setDefaultProfileImage($user);
        }
    }


}
