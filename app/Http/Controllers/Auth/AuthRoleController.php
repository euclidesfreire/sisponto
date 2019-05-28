<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\EstruturaRepository;

class AuthRoleController extends Controller
{
    static public function role($user)
    {
    	$structResponsible = EstruturaRepository::structResponsible($user);

    	if($structResponsible){
    		return auth('manager')->login($user);
     	}

     	return auth('user')->login($user);
    }
}
