<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estrutura extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\Models\User', 'pessoa_responsavel_id');
    }
}
