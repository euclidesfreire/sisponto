<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use App\Models\Batida;

class BatidaRepository extends BaseRepository
{
	public function __construct()
    {
        $this->model = App\Models\Batida;
    }

    public static function getBatidas($funcionario, $periodo) 
    {
    	$batidas = Batida::where('funcionario_id', $funcionario->id)
    				->whereBetween('data', [$periodo['dataInicio']->format('Y/d/m'), 
    								$periodo['dataFim']->format('Y/d/m') ])->get();
    	return $batidas;
    }

}