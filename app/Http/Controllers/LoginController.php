<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function Login()
    {
        $page = DB::table('login_page')->first();
        return view('front.login', compact('page'));
    }

    public function LoginCheck(Request $request)
    {
        $request->validate([
            'username' =>  'required',
            'password'  =>  'required'
        ]);

        $credentials = ["username" => $request->username, "password" => $request->password];
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if(Auth::user()->belongs_to !== null) {
                $user_admin = User::where(['id' => Auth::user()->belongs_to])->first();
                if($user_admin && $user_admin->status != 1) {
                    Auth::logout();
                    Session::flash('message', 'Access Denied.');
                    Session::flash('alert-type', 'error');
                    return redirect()->back();
                }
            }
            if (Auth::user()->status == 1) {
                if (Auth::user()->role == 1) {
                    return redirect('/admin/dashboard');
                } else {
                    return redirect('/users/dashboard');
                }
            } else {
                Auth::logout();
                Session::flash('message', 'Access Denied.');
                Session::flash('alert-type', 'error');
                return redirect()->back();
            }
        } else {
            Session::flash('message', 'Wrong Username or Password.');
            Session::flash('alert-type', 'error');
            return redirect()->back();
        }
    }

    public function RegisterSave(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' =>  'required|min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password'  =>  'required|min:6'
        ]);

        $exists = User::find(['email', $request->email]);
        if(count($exists) > 0) {
            Session::flash('message', 'Your account has been activated. Please login to continue...');
            Session::flash('alert-type', 'success');
            return redirect()->back();
        }
        $hash_password = Hash::make($request->password);
        User::insert([
            'name'  =>  $request->name,
            'email'  =>  $request->email,
            'password'  =>  $hash_password
        ]);
        Session::flash('message', 'An email has been sent to your email id which contains the email verification link. Activate your email id to continue...');
        return redirect('/');
    }

    public function Logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
