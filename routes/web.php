<?php

use App\Http\Controllers\API\ApiClueController;
use App\Http\Controllers\Helpers\LocalizationController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Main\RegisterController;
use App\Http\Controllers\Main\SessionsController;
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

//Session Routes
Route::get('/login',[SessionsController::class,'create'])->name('sessions.create')->middleware('guest');
Route::post('/login',[SessionsController::class,'store'])->name('sessions.store')->middleware('guest');
Route::get('/logout',[SessionsController::class,'destroy'])->name('sessions.destroy')->middleware('auth');

//Register routes
Route::get("/register",[RegisterController::class,'create'])->name('register.create')->middleware('guest');
Route::post("/register",[RegisterController::class,'store'])->name('register.store')->middleware('guest');


//API Routes
Route::get('/API/clues/{clueKey}', [ApiClueController::class,'show'])->name('apiClues');
Route::get('/API/clues/',function (){return response(['error'=>'You need to specify the clueKey in your request'],405);})->name('apiCluesRoot');
Route::get('/test/{clueKey}', [ApiClueController::class,'show']);

//Helper Routes
Route::get('/localization/{locale}',[LocalizationController::class,'update'])->name('setLocale');
Route::get('hola',function (){
    return ['message'=>'adios'];
});


