<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{

    protected $table = 'Curso';
    protected $primaryKey = 'id_curso';
    public $timestamps = false;

    protected $fillable = [
        'id_programa',
        'id_area',
        'codigo_curso',
        'nombre_curso',
        'id_semestre',
        'id_ciclo_formacion',
        'cant_semanas_sem',
        'competencia_curso',
    ];

    // Relaciones
    public function programa()
    {
        return $this->belongsTo(Programa::class, 'id_programa', 'id_programa');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id_area');
    }

    public function bibliografias()
    {
        return $this->hasMany(Bibliografia::class, 'id_curso', 'id_curso');
    }

    public function cursoCuerpo()
    {
        return $this->hasOne(CursoCuerpo::class, 'id_curso', 'id_curso');
    }

    public function perfiles()
    {
        return $this->hasMany(Perfil::class, 'id_curso', 'id_curso');
    }

    public function prerequisitos()
    {
        return $this->hasMany(Prerequisitos::class, 'id_curso', 'id_curso');
    }

    public function subsecuentes()
    {
        return $this->hasMany(Subsecuente::class, 'id_curso', 'id_curso');
    }
}
