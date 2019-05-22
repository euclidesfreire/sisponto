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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

  
    public function authenticate(Request $request)
    {

        $this->middleware('guest')->except('logout'); 

        $credentials = $request->only('usuario', 'password');

        /*
        | Sobrescrevendo o method attemp, pois o database não
        | usa o mesmo method de criptografia que o laravel
        */
        $user = User::where('n_folha', $credentials['usuario'])->where('web_senha', $credentials['password'])->first();

        if ($user) {

            Role::role($user); //Define Auth('role')

            return redirect()->intended('/');
        }

        return redirect()->route('login');
    }

    public function logout(Request $request, $guard = null)
    {

        $request->session()->invalidate();
       
        return redirect('/');
    }

    protected function guard($guard)
    {
        return Auth::guard($guard);
    }
}
