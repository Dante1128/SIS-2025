<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CursoCuerpo extends Model
{
    protected $table = 'Curso_cuerpo';
    protected $primaryKey = 'id_curso_cuerpo';
    public $timestamps = false;

    protected $fillable = [
        'id_curso',
        'criterio_desempeno',
        'unidad_didactica',
        'react_desarrollo',
        'react_evaluacion',
        'cargah_teoria',
        'cargah_practica',
        'cargah_laboratorio',
        'porc_eval_ateorico',
        'porc_eval_apractico',
        'porc_eval_alaboratorio',
        'pond_global_udidactica',
        'semanas'
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso', 'id_curso');
    }
}
