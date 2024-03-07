<?php

use App\Http\Controllers\API\ApiClueController;
use App\Http\Controllers\Helpers\LocalizationController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Main\Clue\ClueController;
use App\Http\Controllers\Main\RegisterController;
use App\Http\Controllers\Main\SessionsController;
use App\Http\Controllers\Main\TreasureHuntController;
use App\Http\Controllers\Main\UserAreaController;
use App\Http\Controllers\Main\UserController;
use App\Models\Clue\Clue;
use App\Models\User;
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
Route::get('/home', fn()=>redirect(\route('home')));
Route::get('/keys/{clueKey}', [HomeController::class,'show'])->name('home.showKey');

//Session Routes
Route::get('/login',[SessionsController::class,'create'])->name('login')->middleware('guest');
Route::post('/login',[SessionsController::class,'store'])->name('sessions.store')->middleware('guest');
Route::get('/logout',[SessionsController::class,'destroy'])->name('logout')->middleware('auth');

//Register routes
Route::get("/register",[RegisterController::class,'create'])->name('register.create')->middleware('guest');
Route::post("/register",[RegisterController::class,'store'])->name('register.store')->middleware('guest');

//Treasure Hunts
Route::get("/treasureHunts",[TreasureHuntController::class,'index'])->name('userArea.index')->middleware('auth');
Route::get('/treasureHunts/new',[TreasureHuntController::class,'create'])->name('treasureHunt.create')->middleware('auth');
Route::post('/treasureHunts/new',[TreasureHuntController::class,'store'])->name('treasureHunt.store')->middleware('auth');
Route::get('/treasureHunt/{treasureHunt}',[TreasureHuntController::class,'show'])->name('treasureHunt.show')->middleware('auth');
Route::get('/treasureHunt/{treasureHunt}/edit',[TreasureHuntController::class,'edit'])->name('treasureHunt.edit')->middleware('auth');
Route::put('/treasureHunt/{treasureHunt}/update',[TreasureHuntController::class,'update'])->name('treasureHunt.update')->middleware('auth');
Route::delete('/treasureHunt/{treasureHunt}/destroy',[TreasureHuntController::class,'destroy'])->name('treasureHunt.destroy')->middleware('auth');
Route::get('/treasureHunt/{treasureHunt}/qrCodes',[TreasureHuntController::class,'generateQRCodes'])->name('treasureHunt.generateQRCodes')->middleware('auth');

//Clues
Route::get('/treasureHunt/{treasureHunt}/clues/new',[ClueController::class,'create'])->name('clue.create')->middleware('auth');
Route::post('/treasureHunt/{treasureHunt}/clues/new',[ClueController::class,'store'])->name('clue.store')->middleware('auth');
Route::get('/clue/{clue:clueKey}',[ClueController::class,'show'])->name('clue.show')->middleware('auth');
Route::get('/clue/{clue:clueKey}/edit',[ClueController::class,'edit'])->name('clue.edit')->middleware('auth');
Route::put('/clue/{clue:clueKey}/update',[ClueController::class,'update'])->name('clue.update')->middleware('auth');
Route::delete('/clue/{clue:clueKey}/destroy',[ClueController::class,'destroy'])->name('clue.destroy')->middleware('auth');

//Users
Route::get('/users/{user:username}',[UserController::class,'show'])->name('user.show')->middleware('auth');
Route::get('/user/{user:username}/edit',[UserController::class,'edit'])->name('user.edit')->middleware('auth');
Route::put('/user/{user:username}/update',[UserController::class,'update'])->name('user.update')->middleware('auth');
Route::delete('/user/{user:username}/destroy',[UserController::class,'destroy'])->name('user.destroy')->middleware('auth');

//API Routes
Route::get('/API/clues/{clueKey}', [ApiClueController::class,'show'])->name('apiClues');
Route::get('/API/clues/',function (){return response(['error'=>'You need to specify the clueKey in your request'],405);})->name('apiCluesRoot');
Route::get('/test/{clueKey}', [ApiClueController::class,'show']);

//Helper Routes
Route::get('/localization/{locale}',[LocalizationController::class,'update'])->name('setLocale');
Route::get('hola',function (){
    $clue = Clue::factory()->create();
    ddd($clue);
});




