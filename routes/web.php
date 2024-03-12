<?php

use App\Http\Controllers\Admin\AdminClueController;
use App\Http\Controllers\Admin\AdminTreaureHuntController;
use App\Http\Controllers\Admin\AdminUserController;
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
use Illuminate\Support\Facades\Mail;
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

//API Routes
Route::get('/API/clues/{clueKey}', [ApiClueController::class,'show'])->name('apiClues');
Route::get('/API/clues/',function (){return response(['error'=>'You need to specify the clueKey in your request'],405);})->name('apiCluesRoot');
Route::get('/test/{clueKey}', [ApiClueController::class,'show']);

//Helper Routes
Route::get('/localization/{locale}',[LocalizationController::class,'update'])->name('setLocale');


Route::middleware(['guest'])->group(function(){
    //Session Routes
    Route::get('/login',[SessionsController::class,'create'])->name('login')->middleware('guest');
    Route::post('/login',[SessionsController::class,'store'])->name('sessions.store')->middleware('guest');

    //Register routes
    Route::get("/register",[RegisterController::class,'create'])->name('register.create')->middleware('guest');
    Route::post("/register",[RegisterController::class,'store'])->name('register.store')->middleware('guest');
});

Route::middleware(['auth'])->group(function(){
    //Session
    Route::get('/logout',[SessionsController::class,'destroy'])->name('logout');

    //Treasure Hunts
    Route::get("/treasureHunts",[TreasureHuntController::class,'index'])->name('userArea.index');
    Route::get('/treasureHunts/new',[TreasureHuntController::class,'create'])->name('treasureHunt.create');
    Route::post('/treasureHunts/new',[TreasureHuntController::class,'store'])->name('treasureHunt.store');
    Route::middleware(['treasureHuntOwnersOny'])->group(function (){
        Route::get('/treasureHunt/{treasureHunt}',[TreasureHuntController::class,'show'])->name('treasureHunt.show');
        Route::get('/treasureHunt/{treasureHunt}/edit',[TreasureHuntController::class,'edit'])->name('treasureHunt.edit');
        Route::put('/treasureHunt/{treasureHunt}/update',[TreasureHuntController::class,'update'])->name('treasureHunt.update');
        Route::delete('/treasureHunt/{treasureHunt}/destroy',[TreasureHuntController::class,'destroy'])->name('treasureHunt.destroy');
        Route::get('/treasureHunt/{treasureHunt}/qrCodes',[TreasureHuntController::class,'generateQRCodes'])->name('treasureHunt.generateQRCodes');
        //Clues
        Route::get('/treasureHunt/{treasureHunt}/clues/new',[ClueController::class,'create'])->name('clue.create');
        Route::post('/treasureHunt/{treasureHunt}/clues/new',[ClueController::class,'store'])->name('clue.store');
    });

    //Clues
    Route::middleware(['cluesOwnerOnly'])->group(function (){
        Route::get('/clue/{clue:clueKey}',[ClueController::class,'show'])->name('clue.show');
        Route::get('/clue/{clue:clueKey}/edit',[ClueController::class,'edit'])->name('clue.edit');
        Route::put('/clue/{clue:clueKey}/update',[ClueController::class,'update'])->name('clue.update');
        Route::delete('/clue/{clue:clueKey}/destroy',[ClueController::class,'destroy'])->name('clue.destroy');
    });

    //Users
    Route::middleware(['currentUserOnly'])->group(function (){
        Route::get('/user/{user}/edit',[UserController::class,'edit'])->name('user.edit');
        Route::put('/user/{user}/update',[UserController::class,'update'])->name('user.update');
        Route::delete('/user/{user}/destroy',[UserController::class,'destroy'])->name('user.destroy');
    });

    //Admins Section
    Route::middleware('adminsOnly')->group(function (){
        //Users
        Route::get('admin/users',[AdminUserController::class,'index'])->name('admin.users.index');
        Route::get('admin/users/new',[AdminUserController::class,'create'])->name('admin.users.create');
        Route::post('admin/users/new',[AdminUserController::class,'store'])->name('admin.users.store');
        Route::get('admin/user/{user}/edit',[AdminUserController::class,'edit'])->name('admin.users.edit');
        Route::put('admin/user/{user}/edit',[AdminUserController::class,'update'])->name('admin.users.update');
        Route::delete('admin/user/{user}/destroy',[AdminUserController::class,'destroy'])->name('admin.users.destroy');

        //TreasureHunts
        Route::get('admin/treasureHunts',[AdminTreaureHuntController::class,'index'])->name('admin.treasureHunts.index');
        Route::delete('admin/treasureHunt/{treasureHunt}/destroy',[AdminTreaureHuntController::class,'destroy'])->name('admin.treasureHunts.destroy');
        Route::get('admin/treasureHunt/{treasureHunt}/qrCodes',[AdminTreaureHuntController::class,'generateQRCodes'])->name('admin.treasureHunts.generateQRCodes');

        //Clues
        Route::get('admin/clues',[AdminClueController::class,'index'])->name('admin.clues.index');
        Route::get('admin/clue/{clue:clueKey}',[AdminClueController::class,'show'])->name('admin.clues.show');
        Route::delete('admin/clue/{clue:clueKey}/destroy',[AdminClueController::class,'destroy'])->name('admin.clues.destroy');
    });
});

