<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // use Notifiable;

    protected $table = 'funcionarios';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $rememberTokenName = false;

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array
    //  */
    // protected $fillable = [
    //     'nome', 'n_folha', 'web_senha',
    // ];

    // /**
    //  * The attributes that should be hidden for arrays.
    //  *
    //  * @var array
    //  */
    // protected $hidden = [
    //     'web_senha', 'remember_token',
    // ];
}
