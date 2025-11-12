<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'Departamento';
    protected $primaryKey = 'Id_departamento';
    public $timestamps = false;

    protected $fillable = [
        'nombre_departamento',
        'desc_departamento',
        'cod_departamento',
    ];

    
}
