<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function Profile()
    {
        $user = User::where(['id' => Auth::user()->id])->first();
        return view('dashboard.profile', compact('user'));
    }

    public function SaveProfile(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $user = User::find(Auth::user()->id);


        $user->name = $request->name;
        $user->facebook = $request->facebook;
        $user->twitter = $request->twitter;
        $user->instagram = $request->instagram;
        $user->save();
        
        return redirect()->back();
    }
}
