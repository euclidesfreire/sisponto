<?php

namespace App\Core\Contracts;

interface UserContract {

	/**
	*Get the current authenticade user
	*
	* @return $user
	*/  
	public function getUser();

	/**
	*Loggin
	*
	* @return $user
	*/  
	public function attemp($credentials);

	/**
	* Role Auth Guard
	*
	* @return $guard
	*/  
	public function role($user);

	/**
	* Check if the authenticated user has the given permission.
	 *
     * @param string $rota
     *
     * @return bool
	*/  
	public function haspermission($rota);


}