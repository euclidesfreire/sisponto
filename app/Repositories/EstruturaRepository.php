<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use App\Models\Estrutura;

class EstruturaRepository extends BaseRepository
{
	public function __construct(Estrutura $estrutura)
    {
        $this->model = $estrutura;
    }

   	public function structResponsible($user)
    {
        /**
        * Verificar se o $user é responsável
        * por algum departamento
        */
        $structResponsible = $this->model->where('id', $user->estrutura_id)
        ->where('pessoa_responsavel_id', $user->id)->first();
    	
        return $structResponsible;
    }

}