<?php 

namespace App\Core\Facades;

use Illuminate\Support\Facades\Facade;

class BatidasFacade extends Facade {

	protected static function getBatidasAccessor()
	{
		return 'BatidasContract';
	}

}