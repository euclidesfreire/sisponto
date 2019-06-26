<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use App\Models\Horarios;

class HorariosRepository extends BaseRepository
{
	public function __construct(Horarios $horarios)
    {
       $this->model = $horarios;
    }

    public function getHorarios($funcionario) 
    {
        $horario = $this->model
        ->where('numero', $funcionario['horario'])
        ->where('dia_semana', $funcionario['diaSemana'])->get();
        
        return $horario;
    }

    public function getFolga($funcionario) 
    {
    	$folga = $this->model->select('folga')
        ->where('numero', $funcionario['horario'])
    	->where('dia_semana', $funcionario['diaSemana'])->get();
        
    	return $folga;
    }

}