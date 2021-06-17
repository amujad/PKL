<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
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
                'email' => 'Email atau password tidak sesuai',
                'password' => 'Email atau password tidak sesuai',
            ]);
        }
    }
    
    public function logout(Request $request){
        $request->session()->flush();
        Auth::logout();
        return Redirect('login');
    }
}
