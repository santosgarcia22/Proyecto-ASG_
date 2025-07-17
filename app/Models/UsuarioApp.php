<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class UsuarioApp extends Model
{
    use HasFactory;

    protected $table = 'usuarios_app';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'usuario',
        'password',
        'nombre_completo',
        'email',
        'activo',
    ];

    protected $hidden = [
        'password',
    ];
}