<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use App\Models\Departamento;

class DepartamentoRepository extends BaseRepository
{
	public function __construct()
    {
        $this->model = App\Models\Departamento;
    }

}