<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
 
        return view('user.home', ['registros' => $registros]);
    }

    public function postRead(Request $request)
    {
        $dataFuncionario = array(
            'matricula' => $request->input('matricula'),
            'periodo' => $request->input('periodo'),
        );

        $funcionarioId = Auth::user()->id;

         $departamento = Auth::user()->departamento_id;

        $registros = $this->postCalculo($funcionarioId, $departamento, $dataFuncionario['periodo']);
 
        return view('user.home', ['registros' => $registros]);
    }


}
