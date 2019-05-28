<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use App\Models\Estrutura;

class EstruturaRepository extends BaseRepository
{
	public function __construct(Estrutura $estrutura)
    {
        parent::__construct($estrutura);
    }

   	public static function structResponsible($user)
    {
        /**
        * Verificar se o $user é responsável
        * por algum departamento
        */
        $structResponsible = Estrutura::where('id', $user->estrutura_id)
        ->where('pessoa_responsavel_id', $user->id)->first();
    	
        return $structResponsible;
    }

}