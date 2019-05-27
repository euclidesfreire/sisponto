<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthRoleController as Role;
use App\Models\User;

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

    //  public function __construct()
    // {
    //     $this->middleware('guest:user')->except('logout');
    // }

     public function showLoginForm()
    {
        $route = $this->checkGuard();
           
        if(!$route)
            return view('auth.login');

        return redirect()->intended($route);
    }
  
    public function authenticate(Request $request)
    {

        $credentials = $request->only('usuario', 'password');

        /*
        | Sobrescrevendo o method attemp, pois o database não
        | usa o mesmo method de criptografia que o laravel
        */
        $user = User::where('n_folha', $credentials['usuario'])->where('web_senha', $credentials['password'])->first();

        if ($user) {

            Role::role($user); //Define Auth('guard')

           /*
            | PROVISÓRIO 
            | Check Route do Guard Autenticado 
           */
           $route = $this->checkGuard();
           
           return redirect()->intended($route);
        }

        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        $guard = $this->checkGuard();

        Auth::guard($guard)->logout();

        $request->session()->flush();
       
        return redirect('/');
    }

    // protected function guard($guard)
    // {
    //     return Auth::guard($guard);
    // }

    protected function checkGuard()
    {
        if($this->guard('user')->check())
            return 'user';
        else if($this->guard('manager')->check())
            return 'manager';

        return null;
    }
    
}
