<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\EstruturaRepository;

class AuthRoleController extends Controller
{

	protected $estruturaRepository;

	public function __construct(EstruturaRepository $estrutura)
	{
		$this->estruturaRepository = $estrutura;
	}

    public function role($user)
    {
    	$structResponsible = $this->estruturaRepository->structResponsible($user);

    	if($structResponsible){
    		return true;
     	}

     	return false;
    }
}
