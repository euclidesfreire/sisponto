<?php

namespace App\Core\Services;

use App\Core\Contracts\UserContract;

class UserService implements UserContract 
{
	/**
     * The currently authenticated user.
     *
     * @var Array
     */
    protected $user;

	/**
	*Get the current authenticade user
	*
	* @return $user
	*/  
	public function getUser(){

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