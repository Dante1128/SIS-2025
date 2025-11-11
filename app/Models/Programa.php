<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    protected $table = 'Programa';
    protected $primaryKey = 'id_programa';
    protected $timestamps = false;

    protected $fillable = [
        'cod_programa',
        'nombre_programa',
        'num_resolucion',
    ];
}
