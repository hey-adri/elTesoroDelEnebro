<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\HelperController;
use App\Models\TreasureHunt;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Log;

class TreasureHuntController extends Controller
{
    /**
     * Returns the user Area view showing all the user's avilable clues
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(){
        $filters=[];
        //Getting filters and sorting from request
        if($reqFilters = request('filters')){
            if (in_array('pro',$reqFilters)) $filters['pro']=true;
        }
        if(request('search'))$filters['search_internal']=request('search');
        $sortBy=request('sortBy','updated_at');
        $sortDirection = request('sortDirection','desc');

        //Getting all treasureHunts filtered
        $user = auth()->user();
        $query = $user->treasure_hunts()->filter($filters,$sortBy,$sortDirection);


        //Pagination
        $treasureHunts = $query->paginate(6)->fragment('searchBar');

        return view('treasureHunts.index',[
            'treasure_hunts'=>$treasureHunts,
            'backTo'=>[
                'route'=>route('home'),
                'icon'=>'fa-house',
                'name'=>__('Home')
            ],
        ]);
    }

    /**
     * Returns the view treasureHunts.show which acts as index for the user's clues
     * @param TreasureHunt $treasureHunt
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show(TreasureHunt $treasureHunt){
        $filters=[];
        //Getting filters and sorting from request
        if($reqFilters = request('filters')){
            if (in_array('pro',$reqFilters)) $filters['pro']=true;
            if (in_array('has_embedded_video',$reqFilters)) $filters['has_embedded_video']=true;
            if (in_array('has_image',$reqFilters)) $filters['has_image']=true;
        }
        if(request('search'))$filters['search_internal']=request('search');
        $sortBy=request('sortBy','updated_at');
        $sortDirection = request('sortDirection','desc');

        //Getting all clues filtered
        $clues = $treasureHunt->clues()->filter($filters,$sortBy,$sortDirection);

        $clues = $clues->paginate(10)->fragment('searchBar');
        return view('treasureHunts.show',[
            'treasureHunt'=>$treasureHunt,
            'clues'=>$clues,
            'backTo'=>[
                'route'=>route('userArea.index'),
                'icon'=>'fa-user',
                'name'=>__('Área Personal')
            ],
        ]);
    }

    /**
     * Returns the view treasureHunts.create
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create(){
        return view('treasureHunts.create',[
            'backTo'=>[
                'route'=>route('userArea.index'),
                'icon'=>'fa-user',
                'name'=>__('Área Personal')
            ],
        ]);
    }

    /**
     * Creates a new treasure hunt and redirects to treasureHunt.show of the created resource
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(){
        $attributes = request()->validate(
            [
                "title"=>["required","max:255"],
            ]
        );
        HelperController::sanitizeArray($attributes); //Sanitizing input
        $attributes['user_id'] = auth()->user()->id;
        try {
            //Creating and storing the treasureHunt
            $treasureHunt = TreasureHunt::create(
                $attributes
            );
            //Redirecting to the new treasureHunt
            return redirect(route('treasureHunt.show',['treasureHunt'=>$treasureHunt->id]))->with('toast',[
                'icon' => 'success',
                'text'=>$treasureHunt->title.__(' creada!')
            ]);
        } catch (Exception $exception) {
            Log::log('error',$exception->getMessage());
            return redirect()->back()->with('toast',[
                'icon' => 'error',
                'text'=>__('Vaya, ha habido un error.')
            ]);
        }
    }

    /**
     * Returns the view treasureHunts.edit
     * @param TreasureHunt $treasureHunt
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit(TreasureHunt $treasureHunt){
        return view('treasureHunts.edit',[
            'treasureHunt'=>$treasureHunt,
            'backTo'=>[
                'route'=>route('treasureHunt.show',['treasureHunt'=>$treasureHunt]),
                'icon'=>'fa-book',
                'name'=>$treasureHunt->title
            ],
        ]
        );
    }

    /**
     * Updates a treasure hunt and returns to treasureHunt.show
     * @param TreasureHunt $treasureHunt
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(TreasureHunt $treasureHunt){
        $attributes = request()->validate(
            [
                "title"=>["required","max:255"],
            ]
        );
        HelperController::sanitizeArray($attributes); //Sanitizing input
        try {
            //Updating the treasureHunt
            $treasureHunt->updateOrFail($attributes);
            //Redirecting to the updated treasureHunt
            return redirect(route('treasureHunt.show',['treasureHunt'=>$treasureHunt->id]))->with('toast',[
                'icon' => 'success',
                'text'=>$treasureHunt->title.__(' actualizada!')
            ]);
        } catch (\Throwable | Exception $exception) {
            Log::log('error',$exception->getMessage());
            return redirect()->back()->with('toast',[
                'icon' => 'error',
                'text'=>__('Vaya, ha habido un error.')
            ]);
        }
    }

    /**
     * Deletes a treasure hunt and returns back to the last page, or, the route with the name that equals the request parameter "backTo"
     * @param TreasureHunt $treasureHunt
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(TreasureHunt $treasureHunt){
        try {
            $treasureHunt->deleteOrFail();
            //Allowing other routes to go back to if received
            $back =  redirect()->back();
            if(!empty(request('backTo'))){
                $back = redirect(route(request('backTo')));
            }


            return $back->with('toast', [
                'icon' => 'success',
                'text' => __('Has eliminado ') . $treasureHunt->title
            ]);
        } catch (\Throwable $e) {
            return redirect()->back()->with('toast', [
                'icon' => 'error',
                'text' => __('Ha habido un error en el borrado')
            ]);
        }
    }

    //Todo
    public function generateQRCodes(TreasureHunt $treasureHunt){
        $pdfFilename=str_replace("-", " ", __('El Tesoro Del Enebro'.' '.$treasureHunt->title.' '.now()).'.pdf');
        return Pdf::loadView('treasureHunts.qrCodes.pdf',['treasureHunt'=>$treasureHunt])->download($pdfFilename);

    }
}
