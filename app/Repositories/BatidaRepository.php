<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use App\Models\Batida;

class BatidaRepository extends BaseRepository
{
	public function __construct(Batida $batida)
    {
        parent::__construct($batida);
    }

    public static function getBatidas($funcionarioId, $periodo) 
    {
    	$batidas = Batida::where('funcionario_id', $funcionarioId)
    				->whereBetween('data', [$periodo['dataInicio']->format('Y/d/m'), 
    								$periodo['dataFim']->format('Y/d/m') ])->get();
    	return $batidas;
    }

}