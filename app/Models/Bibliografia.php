<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bibliografia extends Model
{

    protected $table = 'Bibliografia';
    protected $primaryKey = 'id_biblio';
    public $timestamps = false;

    protected $fillable = [
        'id_curso',
        'autor',
        'anio',
        'titulo',
        'editorial',
        'id_edicion',
        'pais_ciudad',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso', 'id_curso');
    }
}
