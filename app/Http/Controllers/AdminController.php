<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;



class AdminController extends Controller
{
    public function index()
    {
    }

    public function login(Request $request)
    {
        if($request)
        {
            
            $username=$request['username'];
            $password=$request['password'];
    
            if(Auth::attempt(['username' => $username, 'password' => $password]))
                {
                    $tk=Auth::attempt(['username' => $username, 'password' => $password]);
                    return response()->json([
                        'code' => 1,
                        'msg' => 'login successfully',
                        'tk'=> $tk
                    ]);
                }

        }
        
     
            
            

        // echo $user;

        
        // if($request['submit'])
        // {
        //     $email=$request['email'];
        //     $password=$request['password'];
          
        //     $m=Member::where('email',$email)->first();
        //     $db_pw=$m['password'];
            
        //     if(Hash::check($password, $db_pw))
        //     {
        //      if(Auth::attempt(['email' => $email, 'password' => $password]))
        //         {
        //             return view('/login')->with('login_status','success'); 
        //         }
        //     }
        //     else
        //     {   
        //         return view('/login')->with('login_status','fail');
        //     }
  
          

        // }
        // else
        // {
        //     return view('login');
        // }
        
    }

}