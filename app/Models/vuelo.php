<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vuelo extends Model
{
    use HasFactory;

    protected $table = 'vuelo'; //tabla
    protected $primarykey = 'id_vuelo'; // llave primaria
    protected $fillable = ['fecha','numero_vuelo']; //datos para asigancion de forma masiva


}
