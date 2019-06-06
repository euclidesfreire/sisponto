<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use App\Models\Feriados;

class FeriadosRepository extends BaseRepository
{
	public function __construct(Horarios $horarios)
    {
        parent::__construct($horarios);
    }

    public static function getFeriado($data) 
    {
    	$feriado = Feriados::where('data', $data)->count();
        
    	return $feriado;
    }

}