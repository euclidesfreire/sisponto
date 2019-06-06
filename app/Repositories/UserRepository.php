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
        parent::__construct($user);
    }

   	public static function getUser($matricula)
    {
    	return User::where('n_folha', $matricula)->first();
    }

    public static function attemp($credentials)
    {
    	$user = User::where('n_folha', $credentials['usuario'])
        		->where('web_senha', $credentials['password'])->first();

        return $user;
    }

    public static function getHorario($funcionarioId)
    {
        $userHorario = User::select('horario_num')
                ->where('id', $funcionarioId)->get();

        return $userHorario;
    }


    public static function getFuncionarios($departamentoId)
    {
        /**
        * Selecionar Todos os Funcionarios
        * Do Departamento do Manager
        */
        $funcionarios = User::where('estrutura_id', $departamentoId)->get();
        
        return $funcionarios;
    }

}