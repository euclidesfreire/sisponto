<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Repositories\UserRepository;
use App\Repositories\BatidaRepository;

trait Registros 
{

	public function showRegistros($matricula, $periodo)
    {
    	$funcionario = UserRepository::getUser($matricula);

    	$periodo = $this->formatDatas($periodo);

    	$batida = BatidaRepository::getBatidas($funcionario, $periodo);

    	$rangePicker = $periodo['dataInicio']->format('d/m/Y') . ' - ' . $periodo['dataFim']->format('d/m/Y');

    	while($periodo['dataInicio']->lessThanOrEqualTo($periodo['dataFim']))
    	{
            $periodo['dataInicio']->addDay();
        }

        return view('home', compact('funcionario', 'batidas', 'departamento', 'rangePicker'));
    }

    /**
	* Dividir String de Data em Data de Início 
	* e Data de Fim
	* @return  array('dataInicio','dataFim')
    */
    protected function formatDatas($datas){
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