<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthRoleController as Role;
use App\Repositories\UserRepository;

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
           
        return redirect()->intended($guard);
    }
  
    public function authenticate(Request $request)
    {

        $credentials = $request->only('usuario', 'password');

        /**
        * Sobrescrevendo o method attemp, pois o database não
        * usa o mesmo method de criptografia que o laravel
        */
        $user = UserRepository::attemp($credentials);

        if ($user) {

            $role = Role::role($user); //Define Auth('guard')

            if($role)
                Auth::guard('manager')->login($user);
            else 
                Auth::guard('user')->login($user);

           /**
           * PROVISÓRIO 
           * Check Route do Guard Autenticado 
           */
           $guard = $this->getGuard();
          //return print('<script> alert("'.$route.'");</script>');
           
           return redirect()->intended($guard);
        }

        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        $guard = $this->getGuard();

        Auth::guard($guard)->logout();

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