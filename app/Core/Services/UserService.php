<?php

namespace App\Core\Services;

use App\Core\Contracts\UserContract;
use App\Repositories\UserRepository;
use App\Repositories\EstruturaRepository;

class UserService implements UserContract 
{
	/**
     * The currently authenticated user.
     *
     * @var Array
     */
    protected $user;

	protected $userRepository;
	protected $estruturaRepository;

	public function __construct
	(
		UserRepository $user,
		EstruturaRepository $estrutura
	)
	{
		$this->userRepository = $user;
		$this->estruturaRepository = $estrutura;
	} 

	/**
	*Get the current authenticade user
	*
	* @return $user
	*/  
	public function getUser(){

	}

	/**
	*Loggin
	*
	* @return $user
	*/  
	public function attemp($credentials)
	{
		$user = $this->userRepository->attemp($credentials);

		return $user;
	}

	/**
	* Role Auth Guard
	*
	* @return $guard
	*/  
	public function role($user)
	{
		$structResponsible = $this->estruturaRepository->structResponsible($user);

    	if($structResponsible){
    		$guard = 'manager';
     	} else {
     		$guard = 'user';
     	}

     	return $guard;
	}

	/**
	* Check if the authenticated user has the given permission.
	 *
     * @param string $rota
     *
     * @return bool
	*/  
	public function haspermission($rota){
		

	}
}