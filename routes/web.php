<?php

use App\Http\Controllers\API\ApiClueController;
use App\Models\Clue\Clue;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home.home',[
        'clueKey'=>null
    ]);
});

Route::get('/API/clues/{clueKey}', [ApiClueController::class,'show'])->name('apiClues');
Route::get('/API/clues/',function (){return response(['error'=>'You need to specify the clueKey in your request'],405);})->name('apiCluesRoot');
Route::get('/test/{clueKey}', [ApiClueController::class,'show']);

Route::get('hola',function (){
    return ['message'=>'adios'];
});

Route::get('/{clueKey}', function ($clueKey) {
    return view('home.home',[
        'clueKey'=>$clueKey
    ]);
});
