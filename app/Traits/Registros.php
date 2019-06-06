<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Repositories\UserRepository;
use App\Repositories\BatidaRepository;
use App\Repositories\HorariosRepository; 
use App\Repositories\FeriadosRepository;

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

        $registros['batidas'] = $this->filterBatidas($funcionarioId, $periodo, $registros['batidas']);

        return $registros;
    }

    /**
     * Array das Datas do Período
     * De Batidas
     *
     * @return array
     */
    public function datePeriod($periodo, $batidas)
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

    
        return $datas;

    }

    public function filterBatidas($funcionarioId, $periodo, $batidas)
    {


        $datas = $this->datePeriod($periodo,$batidas);

         $semana = array(
            'Mon' => 1,
            'Tue' => 2,
            'Wed' => 3,
            'Thu' => 4,
            'Fri' => 5,
            'Sat' => 6,
            'Sun' => 7, 
        );

        $newBatidas = array();

        foreach($batidas as $batida)
        {
            $newBatidas[] = [
                'data' => $batida->data,
                'entrada1' => $batida->entrada1,
                'saida1' => $batida->saida1,
                'entrada2' => $batida->entrada2,
                'saida2' => $batida->saida2,
            ];
            
        }

        $newBatidasCombine = array_combine(array_column($newBatidas, 'data'),$newBatidas);

        $tmpBatidas = array();


        foreach($datas as $data)
        {
            if(in_array($data, array_column($newBatidas, 'data')))
            {
                $tmpBatidas[] =  $newBatidasCombine[$data];

            } else {

                $dayOff = 'Falta';

                $funcionario = array('horario' => 0, 'diaSemana' => 0);

                $funcionario['horario'] = UserRepository::getHorario($funcionarioId);

                $funcionario['horario'] = $funcionario['horario'][0]->horario_num;

                $dataString = date_create($data);

                $funcionario['diaSemana'] =  $semana[date_format($dataString, 'D')];

                $folga = HorariosRepository::getFolga($funcionario);

                $feriado = FeriadosRepository::getFeriado(date_format($dataString, 'Y/d/m'));

                if($folga[0]->folga){
                    $dayOff = "Folga";
                } elseif($feriado){
                    $dayOff = "Feriado";
                }

                $tmpBatidas[] = [
                    'data' => $batida->data,
                    'entrada1' => $dayOff,
                    'saida1' => $dayOff,
                    'entrada2' => $dayOff,
                    'saida2' => $dayOff,
                ];

    
            }

        }
        
        
       return $tmpBatidas;

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