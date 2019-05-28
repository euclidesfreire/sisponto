<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $this->middleware('auth:manager');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matricula = Auth::user()->matricula;
        
        $periodo = $this->geraDatas( Carbon::now()->startOfMonth()
            ->format('d/m/Y') . " - " . Carbon::now()->format('d/m/Y') );

        $registros = $this->getRegistros($matricula, $periodo);

        return view('manager.home', ['registro' => $registros]);
    }

    public function getFuncionarios()
    {
        
    }

}
