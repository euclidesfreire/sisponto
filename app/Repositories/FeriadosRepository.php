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

    public function getFeriado($data) 
    {
    	$feriado = $this->model->where('data', $data)->count();
        
    	return $feriado;
    }

}