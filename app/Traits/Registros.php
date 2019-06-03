<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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

        $periodo = $this->explodeDatas($periodo); 

        $registros = $this->getRegistros($funcionarioId, $periodo);

        return $registros;
    }

    public function postCalculo(Request $request)
    {

        $input = $request->all();

        $funcionario = UserRepository::getUser($input['matricula']);

        $funcionarioId = $funcionario->id;

        $periodo = $this->explodeDatas($input['periodo']);

        $registros = $this->getRegistros($funcionarioId, $periodo);

        return $registros;
    }

    public function getFaltas($periodo)
    {
        $periodo = $this->explodeDatas($periodo);

        $periodo = CarbonPeriod::create($periodo['dataInicio'], $periodo['dataFim']);

        foreach ($p as $data) {
            echo $data . "<br/>";
        }

    }

    /**
	* Dividir String de Data em um Array
	* Data de Início e Data de Fim
	* @return  array('dataInicio','dataFim')
    */
    protected function explodeDatas($datas)
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