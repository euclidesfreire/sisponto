<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Repositories\UserRepository;

class BatidasController extends Controller
{
	use BatidasTrait;

	public function gettRead(Request $request)
    {
        $registros = $this->getCalculo($request);

        // $funcionarios = $this->getFuncionarios();

        return view('manager.home', ['registros' => $registros]);
    }

    public function postRead(Request $request)
    {
        $registros = $this->postCalculo($request);

        // $funcionarios = $this->getFuncionarios();

        return view('manager.home', ['registros' => $registros]);
    }
}
