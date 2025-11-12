<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{

    protected $table = 'Area';
    protected $primaryKey = 'id_area';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'id_area', 'id_area');
    }
}
