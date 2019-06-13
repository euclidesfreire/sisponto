<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
 
        return view('user.home', ['registros' => $registros]);
    }

    public function postRead(Request $request)
    {
        $registros = $this->postCalculo($request);
 
        return view('user.home', ['registros' => $registros]);
    }


}
