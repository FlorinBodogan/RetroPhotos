<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(){
        return view('register');
    }

    public function registerPost(Request $request){
        if ($request->password !== $request->confirm_password) {
            return back()->with('error', 'Parolele nu coincid');
        }

        $user = new User();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);

        event(new UserRegistered(
            $user->name,
            $user->email,
            $user->password
        ));
        return back()->with('succes', 'Inregistrarea a reusit');
    }

    public function login(){
        return view('login');
    }


 
    public function loginPost(Request $request)
    {
    $credentials = [
        'email' => $request->email,
        'password' => $request->password,
    ];
 
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $cookie_name = "user";
        $cookie_value = $user->name . '|' . $user->email;
        $cookie_expire = time() + (86400 * 30);
 
        $cookie = Cookie::make($cookie_name, $cookie_value, $cookie_expire);
        return redirect('/dashboard')->with('success', 'Login Success')->withCookie($cookie);
    }
    
    return back()->with('error', 'Error Email or Password');
    }

    public function logout(Request $request)
    {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
 
    $cookie_name = "user";
    $cookie = Cookie::forget($cookie_name);
    return redirect()->route('home')->withCookie($cookie);
    }
}
