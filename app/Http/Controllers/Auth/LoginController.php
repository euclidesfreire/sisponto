<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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

        $user = User::where('n_folha', $credentials['usuario'])->where('web_senha', $credentials['password'])->first();

        if ($user) {
            // Authentication passed...
            auth('user')->loginUsingId($user->id);

            return redirect()->intended('/');
        }

        return "ERROR";
    }

    public function logout(Request $request, $guard = null)
    {
        // $this->guard($guard)->logout();

        $request->session()->invalidate();
       
        return redirect('/');
    }

    protected function guard($guard)
    {
        return Auth::guard($guard);
    }
}
