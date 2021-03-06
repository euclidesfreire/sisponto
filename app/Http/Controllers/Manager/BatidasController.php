<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Core\Facades\User;
use App\Repositories\UserRepository;
use App\Repositories\BatidaRepository;
use App\Repositories\HorariosRepository; 
use App\Repositories\FeriadosRepository;
use App\Core\Traits\BatidasTrait;

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

	public function getIndex()
    {
        $funcionarioId = Auth::user()->id;

        $departamento = Auth::user()->departamento_id;

        $registros = $this->getCalculo($funcionarioId, $departamento);

        $funcionarios = $this->getFuncionarios(); 
 
        return view('manager.home', ['registros' => $registros, 'funcionarios' => $funcionarios]);
    }

    public function postRead(Request $request)
    {
        $dataFuncionario = array(
            'matricula' => $request->input('matricula'),
            'periodos' => $request->input('periodo'),
        );

        $funcionario = $this->userRepository->getUser($dataFuncionario['matricula']);

        $funcionarioId = $funcionario->id;

        $departamento = Auth::user()->departamento_id;

        $registros = $this->postCalculo($funcionarioId, $departamento, $dataFuncionario['periodos']);

        $funcionarios = $this->getFuncionarios(); 

        return view('manager.home', ['registros' => $registros, 'funcionarios' => $funcionarios]);
    }

    /**
    * Read Funcionarios do departamendo do Manager
    *
    * @return Array $funcionarios 
    */
    public function getFuncionarios()
    {
        $departamentoId = Auth::user()->estrutura_id;

        $funcionarios = $this->userRepository->getFuncionarios($departamentoId);

        return $funcionarios;
    }
}
