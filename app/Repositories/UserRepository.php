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

     /**
    * Verificar dados do Login
    *
    * @param $credentials 
    *
    * @return $user
    */
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

    /**
    * Selecionar Todos os Funcionarios
    * Do Departamento do Manager
    *
    * @param $departamentoId 
    *
    * @return $funcionario
    */
    public function getFuncionarios($departamentoId)
    {
        $funcionarios = $this->model->where('estrutura_id', $departamentoId)->get();
        
        return $funcionarios;
    }

}