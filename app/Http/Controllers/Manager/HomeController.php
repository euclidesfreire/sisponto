<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\Registros;
use Carbon\Carbon;
use App\Repositories\UserRepository;

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
        $registros = $this->getCalculo();

        $funcionarios = $this->getFuncionarios();

        return view('manager.home', ['funcionarios' => $funcionarios, 'registros' => $registros]);
    }

    public function atualizarCalculo(Request $request)
    {
        $registros = $this->postCalculo($request);

        $funcionarios = $this->getFuncionarios();

        // return view('manager.home', ['funcionarios' => $funcionarios, 'registros' => $registros]);
    }

    public function getFuncionarios()
    {
        $departamentoId = Auth::user()->estrutura_id;

        $funcionarios = UserRepository::getFuncionarios($departamentoId);

        return $funcionarios;
    }

}
