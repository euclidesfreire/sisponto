<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\BatidasTrait;
use Carbon\Carbon;
use App\Repositories\UserRepository;

class HomeController extends Controller
{

    use BatidasTrait;

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

    public function getFuncionarios()
    {
        $departamentoId = Auth::user()->estrutura_id;

        $funcionarios = UserRepository::getFuncionarios($departamentoId);

        return $funcionarios;
    }

}
