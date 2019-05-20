<?php

namespace App\Http\Controllers\Gestor\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/gestor';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:gestor')->except('logout');
    }

    public function showLoginForm()
    {
        return view('gestor.auth.login');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
       
        return redirect('/gestor/login');
    }

    protected function guard()
    {
        return Auth::guard('gestor');
    }
}
