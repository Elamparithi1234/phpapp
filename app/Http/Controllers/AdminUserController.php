<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Log;
use Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class AdminUserController extends Controller
{

    public function index()
    {
        return view('backend.dashboard');
    }
    public function showLogin()
    {
        return view('backend.auth.login');
    }
    public function login(Request $request)
    {
        if(Auth::guard('admin')->attempt($request->only('email','password'))){
            //Authentication passed...
            return redirect(route('admin.home'))
                ->with('status','You are Logged in as Admin!');
        }
        else{
            return redirect(route('admin.auth.login'))
            ->with('status','Invalid Admin Credentials!');
        }
    }
    public function showRegister()
    {
        return view('backend.auth.register');
    }
    public function register(Request $request)
    {
        try{
            $user=Admin::where('email',$request->only('email'));
            if($user!=null)
            {
                $user->first_name=$request['first_name'];
                $user->last_name=$request['last_name'];
                $user->password=Hash::make($request['password']);
                $user->save();
            }
        }
        catch(Exception $re)
        {
            Log::error("Registration error of Admin page");
        }
      
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()
            ->route('admin.auth.login')
            ->with('status','Admin has been logged out!');
    }

}