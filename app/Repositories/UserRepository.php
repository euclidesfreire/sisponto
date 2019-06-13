<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use App\Models\User;
use Auth;

class UserRepository extends BaseRepository
{
	public function __construct(User $user)
    {
        $this->model = $user;
    }

   	public function getUser($matricula)
    {
    	return $this->model->where('n_folha', $matricula)->first();
    }

    public function attemp($credentials)
    {
    	$user = $this->model->where('n_folha', $credentials['usuario'])
        		->where('web_senha', $credentials['password'])->first();

        return $user;
    }

    public function getHorario($funcionarioId)
    {
        $userHorario = $this->model->select('horario_num')
                ->where('id', $funcionarioId)->get();

        return $userHorario;
    }


    public function getFuncionarios($departamentoId)
    {
        /**
        * Selecionar Todos os Funcionarios
        * Do Departamento do Manager
        */
        $funcionarios = $this->model->where('estrutura_id', $departamentoId)->get();
        
        return $funcionarios;
    }

}