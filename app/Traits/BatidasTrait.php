<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

trait BatidasTrait 
{
    /**
    * Read Batidas 
    *
    * @param Integer $funcionarioId
    * @param Array Time $periodo 
    * @return Array $batidas
    */
	public function getBatidas($funcionarioId, $periodo)
    {
    	$batidas = $this->batidaRepository->getBatidas($funcionarioId, $periodo);

        return $batidas;
    }


    /**
    * Get Index  
    *
    * @return Array Compat ('batidas','periodoString')
    */
    public function getCalculo()
    {
        $funcionarioId = Auth::user()->id;

        $periodoString = Carbon::now()->startOfMonth()->format('d/m/Y') . ' - ' . Carbon::now()->format('d/m/Y');      

        $periodo = $this->explodeDatas($periodoString); 

        $batidas = $this->getBatidas($funcionarioId, $periodo);

        $batidas = $this->filterBatidas($batidas);

        $batidas = $this->checkBatidas($funcionarioId, $batidas, $periodo);

        $batidas = $this->formatTime($batidas);

        return compact('batidas','periodoString');
    }


    /**
    * Post Atualizar Calculo  
    *
    * @return Array $registros
    */
    public function postCalculo(Request $request)
    {
        $input = array(
            'matricula' => $request->input('matricula'),
            'periodo' => $request->input('periodo'),
        );

        $funcionario = $this->userRepository->getUser($input['matricula']);

        $funcionarioId = $funcionario->id;

        $periodo = $this->explodeDatas($input['periodo']);

        $batidas = $this->getBatidas($funcionarioId, $periodo);

        $batidas = $this->filterBatidas($batidas);

        $batidas = $this->checkBatidas($funcionarioId, $batidas, $periodo);

        $batidas = $this->formatTime($batidas);

        $periodoString = $input['periodo'];

        return compact('batidas','periodoString');
    }

    /**
    * Filter Dados de Batidas 
    *
    * @return Array $newBatidas
    */
    public function filterBatidas($batidas)
    {
        $newBatidas = array();

        foreach($batidas as $batida)
        {
            $calculos = $this->calcular($batida);

            $newBatidas[] = [
                'data' => $batida->data,
                'entrada1' => $batida->entrada1,
                'saida1' => $batida->saida1,
                'entrada2' => $batida->entrada2,
                'saida2' => $batida->saida2,
                'carga' => $calculos['carga'],
                'debito'=> 'debito' ,
                'credito'=> 'credito',
                'total' => 'total',
            ];
            
        }
    
        return $newBatidas;

    }

    /**
    * Calcular Batidas (Carga, Debito, credito, total)
    *
    * @param Arrya $batida
    * @return Compact
    */
    public function calcular($batida)
    {
        $horarios = $debito = array();                

        for($i=1;$i<=5;$i++){

            $entrada = 'mem_entrada' . $i;
            $saida = 'mem_saida' . $i;

            $entrada = $batida->$entrada;
            $saida = $batida->$saida;

            if(!(is_null($entrada)) || !(is_null($saida))){
               $horarios[] = $this->timeDiff($entrada, $saida);
            }
        }

        $carga = $horarios[0];

        if(count($horarios) > 1){

            $minutos = array(0 => 0, 1 => 0);

            foreach ($horarios as $horario) {
                $aux = explode(':', $horario);
                $minutos[0] += $aux[0];
                $minutos[1] += $aux[1];
            }

            $minutos = ($minutos[0] * 60) + $minutos[1];

            if( $minutos < 0 ) $minutos += 24 * 60;

            $carga = ($minutos / 60) . ':' . ($minutos % 60);

        }

        $bool = TRUE;
        
        // while ($bool) {
        //     # code...
        // }

        for($i=1;$i<=5;$i++){

            $entrada = 'entrada' . $i;
            $saida = 'saida' . $i;

            $entrada = $batida->$entrada;
            $saida = $batida->$saida;

            if(!(is_null($entrada)) || !(is_null($saida))){
               $debito[] = $this->timeDiff($entrada, $saida);
            }
        }


        return  compact('carga');
        
    }

    public function timeDiff($entrada, $saida = 0)
    {
        $entrada = explode( ':', $entrada);
        $saida   = explode( ':', $saida);

        $minutos = (($saida[0] - $entrada[0]) * 60) + ($saida[1] - $entrada[1]);

        if( $minutos < 0 ) $minutos += (24 * 60);

        $diff = ((int)($minutos / 60)) . ':' . ($minutos % 60);

        return $diff;
    }

    /**
     * Formatar Datas de Batidas 'd-m-Y - Dia da Semana'
     *
     * @param Array $batidas
     * @return Array $newBatias
     */
    public function formatTime($batidas)
    {
        $newBatidas = $batidas;

         $semana = array(
            'Mon' => 'Seg',
            'Tue' => 'Ter',
            'Wed' => 'Qua',
            'Thu' => 'Qui',
            'Fri' => 'Sex',
            'Sat' => 'Sáb',
            'Sun' => 'Dom', 
        );

        foreach($newBatidas as &$batida)
        {
            $data =  $semana[date_format(date_create($batida['data']), 'D')];

            $batida['data'] = date_format(date_create($batida['data']), 'd-m-Y') . " - " . $data;

        }

        return $newBatidas;
    }

    /**
     * Verificar Batidas ('Falta','Folga','Feriado')
     *
     * @param Int $funcionarioId
     * @param Array $batidas
     * @param Array $periodo
     * @return Array $newBatidas
     */
    public function checkBatidas($funcionarioId, $batidas, $periodo)
    {
        $newBatidas = array();
        $BatidasCombine = array_combine(array_column($batidas, 'data'),$batidas);
        $datas = $this->datePeriod($periodo);

        $semana = array(
            'Mon' => 1,
            'Tue' => 2,
            'Wed' => 3,
            'Thu' => 4,
            'Fri' => 5,
            'Sat' => 6,
            'Sun' => 7, 
        );

        foreach($datas as $data)
        {
            if(in_array($data, array_column($batidas, 'data')))
            {
                $newBatidas[] =  $BatidasCombine[$data];

            } else {

                $dayOff = 'Falta';

                $funcionario = array('horario' => 0, 'diaSemana' => 0);

                $funcionario['horario'] = $this->userRepository->getHorario($funcionarioId);

                $funcionario['horario'] = $funcionario['horario'][0]->horario_num;

                $dataString = date_create($data);

                $funcionario['diaSemana'] =  $semana[date_format($dataString, 'D')];

                $folga = $this->horariosRepository->getFolga($funcionario);

                $feriado = $this->feriadosRepository->getFeriado(date_format($dataString, 'Y/d/m'));

                if($folga[0]->folga){
                    $dayOff = "Folga";
                } elseif($feriado){
                    $dayOff = "Feriado";
                }

                $newBatidas[] = [
                    'data' => $data,
                    'entrada1' => $dayOff,
                    'saida1' => $dayOff,
                    'entrada2' => $dayOff,
                    'saida2' => $dayOff,
                    'carga' => 'carga',
                    'debito'=> 'debito',
                    'credito'=> 'credito',
                    'total' => 'total',
                ];

    
            }

        }

        return $newBatidas;

    }


    /**
     * Array do Intervalo de Datas De Batidas
     *
     * @param Array Time $periodo
     * @return Array $datas
     */
    public function datePeriod($periodo)
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


    /**
	* Dividir String de Data em um Array
	* Data de Início e Data de Fim
    *
    * @param String $datas
	* @return  array compact ('dataInicio','dataFim')
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