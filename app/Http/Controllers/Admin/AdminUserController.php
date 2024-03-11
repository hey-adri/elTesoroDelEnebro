<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperController;
use App\Http\Controllers\Main\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminUserController extends UserController
{

    public function index(){
        $filters=[];
        //Getting filters and sorting from request
        if($reqFilters = request('filters')){
            if (in_array('pro',$reqFilters)) $filters['pro']=true;
            if (in_array('isAdmin',$reqFilters)) $filters['isAdmin']=true;
            if (in_array('has_images',$reqFilters)) $filters['has_images']=true;
            if (in_array('has_embedded_videos',$reqFilters)) $filters['has_embedded_videos']=true;
        }
        if(request('search'))$filters['search']=request('search');
        $sortBy=request('sortBy','updated_at');
        $sortDirection = request('sortDirection','desc');

        //Getting all users filtered
        $query = User::filter($filters,$sortBy,$sortDirection);


        //Pagination
        $users = $query->paginate(5)->fragment('searchBar');
        return view('admin.users.index',[
            'users'=>$users,
            'backTo'=>[
                'route'=>route('home'),
                'icon'=>'fa-home',
                'name'=>__('Home')
            ],
        ]);
    }

    /**
     * Returns the view admin.users.create
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        return view('admin.users.create',[
            'backTo'=>[
                'route'=>route('admin.users.index'),
                'icon'=>'fa-users-gear',
                'name'=>__('Admin. Usuarios')
            ],
        ]);
    }

    public function store(){
        //Validating
        $attributes = UserController::validateCurrentRequest('create');
        //Sanitizing
        HelperController::sanitizeArray($attributes); //Sanitizing input
        try {
            //Creating and storing the user
            $user = User::create($attributes); //Al crear un objeto usuario, la contraseña se guarda encriptada
            //Redirecting to users.index
            return redirect(route('admin.users.index'))->with('toast', [
                'icon' => 'success',
                'text' => __('Usuario').' '.$user->username.' '.__('creado')
            ]);
        } catch (\Exception $exception) {
            Log::log('error',$exception->getMessage());
            return redirect()->back()->with('toast',[
                'icon' => 'error',
                'text'=>__('Vaya, ha habido un error.')
            ]);
        }
    }

    /**
     * Returns the view admin.users.edit
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit(User $user)
    {
        return view('admin.users.edit',[
            'user'=>$user,
            'backTo'=>[
                'route'=>route('admin.users.index'),
                'icon'=>'fa-users-gear',
                'name'=>__('Admin. Usuarios')
            ],
        ]);
    }

    /**
     * Uses the default user Controller to update an user
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user)
    {
        //Running update
        $returnValue = parent::update($user);
        if (session('toast')['icon']=='success'){
            //There were no errors, returning
            return redirect()->route('admin.users.index');
        }else{
            //There were errors, different response was issued, return it
            return $returnValue;
        }
    }

    /**
     * Deletes an user
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        try {
            self::deleteProfileImageFromStorage($user);
            $user->deleteOrFail();
            return redirect()->back()->with('toast', [
                'icon' => 'success',
                'text' => __('Usuario Eliminado')
            ]);
        } catch (\Throwable $e) {
            return redirect()->back()->with('toast', [
                'icon' => 'error',
                'text' => __('Ha habido un error en el borrado')
            ]);
        }
    }
}
