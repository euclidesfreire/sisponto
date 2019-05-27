<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use App\Models\User;
use Auth;

class UserRepository extends BaseRepository
{
	public function __construct()
    {
        $this->model = App\Models\User;
    }

   	public static function getUser($matricula)
    {
    	return User::where('n_folhas', $matricula)->first();
    }

}