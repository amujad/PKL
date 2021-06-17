<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function authenticate(Request $request){
        $credentials = $request->only('email','password');

        if (Auth::attempt($credentials)){
            $user = Auth::user();
            if($user->user_type == 'admin'){
                return redirect()->route('dashboardAdmin');
            }
            else if($user->user_type == 'pos'){
                return redirect()->route('dashboardPos');
            }
            else if($user->user_type == 'mejaIII'){
                return redirect()->route('mejaIII');
            }
        }
        else{
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    public function logout(Request $request){
        $request->session()->flush();
        Auth::logout();
        return Redirect('login');
    }
}
