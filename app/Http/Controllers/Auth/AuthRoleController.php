<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Estrutura;

class AuthRoleController extends Controller
{
    static public function role($user)
    {
    	$estrutura = Estrutura::where('id', $user->estrutura_id)->where('pessoa_responsavel_id', $user->id)->first();

    	if($estrutura){
    		return auth('manager')->login($user);
     	}

     	return auth('user')->login($user);
    }
}
