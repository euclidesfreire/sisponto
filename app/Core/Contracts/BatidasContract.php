<?php

namespace App\Core\Contracts;

interface BatidasContract {

	/**
    * Read Batidas 
    *
    * @param Integer $funcionarioId
    * @param Array Time $periodo 
    *
    * @return Array $batidas
    */
	public function getBatidas($funcionarioId, $periodo);

	/**
    * Get Batidas Index  
    *
    * @return Array Compact ('batidas','periodoString')
    */
    public function getCalculo($funcionarioId);

    /**
    * Post Refresh Calculations
    *
    * @return Array $registros
    */
    public function postCalculo($matricula, $periodo)
   
}