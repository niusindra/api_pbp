<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $fillable = [
        'nama', 
        'nim', 
        'fakultas', 
        'prodi', 
        'jenis_kelamin', 
        'username', 
        'password',
    ];
    protected $hidden = [
        'password',
    ];
    public $timestamps=false;
}
