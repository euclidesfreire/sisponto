<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Repositories\UserRepository;
use App\Repositories\BatidaRepository;

trait Registros 
{

	public function getRegistros($funcionarioId, $periodo)
    {

    	$batidas = BatidaRepository::getBatidas($funcionarioId, $periodo);

    	$rangePicker = $periodo['dataInicio']->format('d/m/Y') . ' - ' . $periodo['dataFim']->format('d/m/Y');

        return compact('batidas', 'rangePicker');
    }

    public function getCalculo()
    {

        $funcionarioId = Auth::user()->id;

        $periodo = Carbon::now()->startOfMonth()->format('d/m/Y') . ' - ' . Carbon::now()->format('d/m/Y');      

        $periodo = $this->formatDatas($periodo); 

        $registros = $this->getRegistros($funcionarioId, $periodo);

        return $registros;
    }

    public function postCalculo(Request $request)
    {

        $input = $request->all();

        $funcionario = UserRepository::getUser($input['matricula']);

        $funcionarioId = $funcionario->id;

        $periodo = $this->formatDatas($input['periodo']);

        $registros = $this->getRegistros($funcionarioId, $periodo);

        return $registros;
    }

    /**
	* Dividir String de Data em um Array
	* Data de Início e Data de Fim
	* @return  array('dataInicio','dataFim')
    */
    protected function formatDatas($datas)
    {
        $periodo = explode(' - ', $datas);
        $dataInicio = Carbon::createFromFormat('!d/m/Y', $periodo[0]);
        $dataFim = Carbon::createFromFormat('!d/m/Y',$periodo[1]);

        return compact('dataInicio', 'dataFim');
    }

    protected function guard($guard)
    {
        return Auth::guard($guard);
    }
}