<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\Registros;
use Carbon\Carbon;

class HomeController extends Controller
{
     use Registros;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $funcionarioId = Auth::user()->id;

        $periodo = Carbon::now()->startOfMonth()->format('d/m/Y') . ' - ' . Carbon::now()->format('d/m/Y');      

        $periodo = $this->formatDatas($periodo); 

        $registros = $this->getRegistros($funcionarioId, $periodo);

        return view('user.home', ['registros' => $registros]);
    }
}
