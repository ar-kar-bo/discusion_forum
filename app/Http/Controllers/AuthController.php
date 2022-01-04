<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required|min:8',
            'image'=>'required|mimes:png,jpg,jpeg'

        ]);
        $image = $request->file('image');
        $image_name = $image->getClientOriginalName();
        $image_path = 'image/'.$image_name;
        $image->storeAs('image',$image_name);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'image'=>$image_path
        ]);
        return redirect(url('/login'))->with('success','Welcome '.$user->name.'. Please Login!');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email'=>'required',
            'password'=>'required|min:8'
        ]);
        if(User::where('email',$request->email)->first()){
            if(Auth::attempt($request->only('email','password'))){
                return redirect(url('/'))->with('success','Success Logged');
            }else{
                return redirect()->back()->with('error','Incorrect Password!');
            }
        }else{
            return redirect()->back()->with('error','Email is not exist!');
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect(url('/login'));
    }
}
