<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AddController extends Controller
{
    public function index()
    {
        return view("app.aggiunta-page");
    }
}    