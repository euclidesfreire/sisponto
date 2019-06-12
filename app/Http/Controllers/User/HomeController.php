BatidasTrait<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\BatidasTrait;
use Carbon\Carbon;

class HomeController extends Controller
{
     use BatidasTrait;


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $registros = $this->getCalculo();

        return view('user.home', ['registros' => $registros]);
    }

    public function atualizarCalculo(Request $request)
    {
        $calculos = $this->postCalculo($request);

        return view('user.home', ['registros' => $calculos]);
    }
}
