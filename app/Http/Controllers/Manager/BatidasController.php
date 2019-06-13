<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use App\Repositories\BatidaRepository;
use App\Repositories\HorariosRepository; 
use App\Repositories\FeriadosRepository;
use App\Traits\BatidasTrait;

class BatidasController extends Controller
{
	use BatidasTrait;

    protected $userRepository;
    protected $batidaRepository;
    protected $horariosRepository;
    protected $feriadosRepository;

    public function __construct(
        UserRepository $user,
        BatidaRepository $batida, 
        HorariosRepository $horarios, 
        FeriadosRepository $feriados
    )
    {
        $this->userRepository = $user;
        $this->batidaRepository = $batida;
        $this->horariosRepository = $horarios;
        $this->feriadosRepository = $feriados;
    }

	public function getRead()
    {
        $registros = $this->getCalculo();

        $funcionarios = $this->getFuncionarios(); 
 
        return view('manager.home', ['registros' => $registros, 'funcionarios' => $funcionarios]);
    }

    public function postRead(Request $request)
    {
        $registros = $this->postCalculo($request);

        $funcionarios = $this->getFuncionarios(); 
 
        return view('manager.home', ['registros' => $registros, 'funcionarios' => $funcionarios]);
    }

    public function getFuncionarios()
    {
        $departamentoId = Auth::user()->estrutura_id;

        $funcionarios = $this->userRepository->getFuncionarios($departamentoId);

        return $funcionarios;
    }
}
