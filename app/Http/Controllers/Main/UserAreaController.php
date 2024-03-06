<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAreaController extends Controller
{
    public function index(){
        return view('userArea.index');
    }
}
