<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    protected $table = 'Programa';
    protected $primaryKey = 'id_programa';
    public $timestamps = false;

    protected $fillable = [
        'id_departamento',
        'id_gestion',
        'cod_programa',
        'nombre_programa',
        'num_resolucion',
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id_departamento');
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class, 'id_gestion', 'id_gestion');
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'id_programa', 'id_programa');
    }

    public function perfiles()
    {
        return $this->hasMany(Perfil::class, 'id_programa', 'id_programa');
    }
}
