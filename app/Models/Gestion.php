<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    protected $table = 'Gestion';
    protected $primaryKey = 'id_gestion';
    public $timestamps = false;

    protected $fillable = [
        'desc_gestion',
        'num_resolucion',
        'fecha_inicio',
        'fecha_final',
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_final' => 'datetime',
    ];
}
