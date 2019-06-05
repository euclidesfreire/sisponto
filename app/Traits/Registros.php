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

        $registros['batidas'] = $this->filterBatidas($periodo,$registros['batidas']);

        return $registros;
    }

    /**
     * Array da Diferenças das Datas do Período
     * E das Datas de Batidas
     *
     * @return array
     */
    public function dateDiff($periodo, $batidas)
    {

        $periodo = CarbonPeriod::create($periodo['dataInicio'], $periodo['dataFim']);

        $datas = array();

        foreach ($periodo as $data) {
            foreach ($data as $key => $value) {
                if($key == 'date'){
                    $dataString = date_create($value);
                    $datas[] = date_format($dataString, 'Y-m-d H:i:s');
                }
            }
        }

        $batidasDatas = array();

        foreach($batidas as $batida)
        {
            $batidasDatas[] = $batida->data;
        }

        $datasDiff = array_diff($datas, $batidasDatas);
    
        return $datasDiff;

    }

    public function filterBatidas($periodo, $batidas)
    {

        $datasDiff = $this->dateDiff($periodo,$batidas);

        $newBatidas = array();

        foreach($batidas as $batida)
        {
            if(in_array($batida->data, $datasDiff))
            {

            } else {

            }
            
        }
        
        return $newBatidas;

    }

    /**
	* Dividir String de Data em um Array
	* Data de Início e Data de Fim
    *
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