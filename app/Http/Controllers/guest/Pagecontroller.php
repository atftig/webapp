<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Pagecontroller extends Controller
{
    public function index(){
        return view('home');
    }

    public function header(){
        return view('home-page');
    }
}
