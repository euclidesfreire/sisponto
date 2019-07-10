<?php

namespace App\Core\Facades;

use Illuminate\Support\Facades\Facade;

class User extends Facade 
{
	protected static function getFacadeAccessor()
	{
		return 'UserContract';
	}
}