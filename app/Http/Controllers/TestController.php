<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index() {

        // return 111;
        if(Auth::user())
        {
            return 'logined';
            // $member = Auth::user();
            // return 9999;
            // echo 999;
            // print_r($member);
            //  return view('home')->with('member',$member);
        }
        else
        {
            return 'invalid';
            // return view('home');
        }
    }
    
}