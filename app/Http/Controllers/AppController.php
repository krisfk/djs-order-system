<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{

    public function index() {
        return view('home');
    }

    public function cms(){
        // dd(54);
        return view('cms');        
    }
    //
}