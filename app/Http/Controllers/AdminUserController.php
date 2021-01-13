<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Config;
use Auth;


class AdminUserController extends Controller
{
    public function index() {
           
    }

    public function adminLogout()
    {
        Auth::logout();
        return response()->json([
            'code' => 200,
            'msg' => 'logged out successfully',
        ]); 
    }

    public function getAdminUser(){

        return Auth::user() ?  response()->json([
            'code' => 200,
            'msg' => 'Admin User is fetched',
            'username' => Auth::user()->username
            // 'tk'=> $tk
        ]) : response()->json([
            'code' => 401,
            'msg' => 'Please login',
        ]);

    }

    public function adminLogin(Request $request)
    {
        if($request)
        {
            
            $username=$request['username'];
            $password=$request['password'];
 

            $user=User::where('username',$username)->first();
            $db_pw=$user['password'];

            $match=false;
            
            if(Hash::check($password, $db_pw))
            {
                if(Auth::attempt(['username' => $username, 'password' => $password]))
                {
                    // $tk=Auth::attempt(['username' => $username, 'password' => $password]);
                    $match=true;                    
                }
            }
            
            return $match ?  response()->json([
                'code' => 200,
                'msg' => 'Login successfully'
                // 'tk'=> $tk
            ]) : response()->json([
                'code' => 401,
                'msg' => 'Login fail. (Wrong Username/Password)',
            ]);
           
            

         

        }
    }

    public function getAllAdminUsers()
    {
        $users = User::where('admin', '1')->get();
        return response()->json($users);
    }

    public function deleteAdminUser(Request $request)
    {

        $user_id=$request['id'];
        $user = User::find($user_id);    
        
        if($user->delete())
        {
            return response()->json(['code'=>'200','msg'=>'Admin User has been deleted']);
        }
        else{
            return response()->json(['code'=>'500','msg'=>'Query error']);
        }
        

    }

    public function createAdminUser(Request $request)
    {       
        $user = new User();
        $user->admin = 1;
        $user->chi_name = '';//isset($request['chi_name']) ? $request['chi_name'] : '';
        $user->en_name = '';//isset($request['en_name']) ? $request['en_name'] : ''; 
        $user->phone_country_code = '';//isset($request['phone_country_code']) ? $request['phone_country_code'] : '';
        $user->phone = '';//isset($request['phone']) ? $request['phone'] : '';
        $user->address = '';//isset($request['address']) ? $request['address'] : '';
        $user->username = $request['username'];//isset($request['username']) ? $request['username'] : '';
        // $user->pregnant = '';//isset($request['pregnant']) ? $request['pregnant'] : 0;
        $user->due_date = '';//isset($request['due_date']) ? $request['due_date'] : '';
        $user->hospital = '';//isset($request['hospital']) ? $request['hospital'] : '';
        $user->doctor= '';//isset($request['doctor']) ? $request['doctor'] : '';
        $user->upload_doc= '';//isset($request['upload_doc']) ? $request['upload_doc'] : '';
        // $user->approve_doc='';// isset($request['approve_doc']) ? $request['approve_doc'] : 0;
        $user->email= $request['email'];//isset($request['email']) ? $request['email'] : '';
        $user->password= Hash::make(isset($request['password']) ? $request['password'] : '');
        $user->email_verified_at=date("Y-m-d h:i:s");
        if($user->save())
        {
            return response()->json(['code'=>'201','msg'=>'User has been created','last_insert_id' => $user->id]);
        }
        else
        {
            return response()->json(['code'=>'500','msg'=>'Query error']);
        }
        // }
    }


    public function editAdminUser(Request $request)
    {
       
        //no file
        // else
        // {
            $user_id = $request['user_id'];
            $user = User::find($user_id);    
            $user->admin = 1;
            
            // $user->admin = isset($request['admin']) ? $request['admin'] : 0;
            // $user->chi_name = isset($request['chi_name']) ? $request['chi_name'] : '';
            // $user->en_name = isset($request['en_name']) ? $request['en_name'] : '';
            // $user->phone_country_code = isset($request['phone_country_code']) ? $request['phone_country_code'] : '';
            // $user->phone = isset($request['phone']) ? $request['phone'] : '';
            // $user->address = isset($request['address']) ? $request['address'] : '';
            $user->username = isset($request['username']) ? $request['username'] : '';
            // $user->pregnant = isset($request['pregnant']) ? $request['pregnant'] : 0;
            // $user->due_date = isset($request['due_date']) ? $request['due_date'] : '';
            // $user->hospital = isset($request['hospital']) ? $request['hospital'] : '';
            // $user->doctor= isset($request['doctor']) ? $request['doctor'] : '';
            // $user->upload_doc= isset($request['upload_doc']) ? $request['upload_doc'] : '';
            // $user->approve_doc= isset($request['approve_doc']) ? $request['approve_doc'] : 0;
            $user->email= isset($request['email']) ? $request['email'] : '';
            // return isset($request['password']).' '.$request['password'];
            if(isset($request['password']))
            {
                $user->password= Hash::make($request['password']);
            }
            
            if($user->save())
            {
                return response()->json(['code'=>'201','msg'=>'User information has been updated']);
            }
            else
            {
                return response()->json(['code'=>'500','msg'=>'Query error']);
            }
        // }
         
       

    }

 
    

    
}