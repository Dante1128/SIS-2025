<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{

    protected $table = 'Perfil';
    protected $primaryKey = 'id_perfil';
    public $timestamps = false;

    protected $fillable = [
        'id_programa',
        'id_curso',
    ];

    public function programa()
    {
        return $this->belongsTo(Programa::class, 'id_programa', 'id_programa');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso', 'id_curso');
    }
}
