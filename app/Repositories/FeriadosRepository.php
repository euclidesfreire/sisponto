<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use App\Models\Feriados;

class FeriadosRepository extends BaseRepository
{
	public function __construct(Feriados $feriados)
    {
       $this->model = $feriados;
    }

    public function getFeriado($data, $departamento) 
    {
    	$feriado = $this->model->where('data', $data)
    	->join('feriados_departamentos', 'feriados_departamentos.feriado_id', '=', 'feriados.id')
    	->where('feriados_departamentos.departamento_id', $departamento)
    	->count();
        
    	return $feriado;
    }

}