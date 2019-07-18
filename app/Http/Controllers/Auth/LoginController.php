<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Core\Facades\User;

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


    public function showLoginForm()
    {
        $guard = $this->getGuard();

        
        if(!$guard)
            return view('auth.login');

        return redirect()->route($guard . '.home');
    }
  
    public function authenticate(Request $request)
    {

        $credentials = $request->only('usuario', 'password');

        $user = User::attemp($credentials); 

        if ($user) {

            $role = User::role($user); //Define Auth('guard')
           
            Auth::guard($role)->login($user);

            $guard = $this->getGuard();
                 
            return redirect()->intended($guard);
        }

        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        $guard = $this->getGuard();

        $this->guard($guard)->logout();

        $request->session()->flush();
       
        return redirect('/');
    }

    protected function guard($guard)
    {
        return Auth::guard($guard);
    }

    protected function getGuard()
    {
        if($this->guard('user')->check())
            return 'user';
        else if($this->guard('manager')->check())
            return 'manager';

        return null;
    }
    
}