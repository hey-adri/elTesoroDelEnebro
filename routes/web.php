<?php

use App\Http\Controllers\API\ApiClueController;
use App\Http\Controllers\Helpers\LocalizationController;
use App\Http\Controllers\Home\HomeController;
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

//Home Routes, available to every user, logged in or not
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/keys/{clueKey}', [HomeController::class,'show'])->name('home.showKey');

Route::get('/API/clues/{clueKey}', [ApiClueController::class,'show'])->name('apiClues');
Route::get('/API/clues/',function (){return response(['error'=>'You need to specify the clueKey in your request'],405);})->name('apiCluesRoot');
Route::get('/test/{clueKey}', [ApiClueController::class,'show']);

//Helper Routes
Route::get('/localization/{locale}',[LocalizationController::class,'update'])->name('setLocale');
Route::get('hola',function (){
    return ['message'=>'adios'];
});


