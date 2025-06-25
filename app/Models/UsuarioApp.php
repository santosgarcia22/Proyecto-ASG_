<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class UsuarioApp extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios_app';

    protected $fillable = [
        'usuario',
        'password',
        'nombre_completo',
        'email',
    ];

    protected $hidden = [
        'password',
    ];
}