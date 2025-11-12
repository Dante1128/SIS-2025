<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subsecuente extends Model
{

    protected $table = 'Subsecuente';
    protected $primaryKey = 'id_subsecuente';
    public $timestamps = false;

    protected $fillable = [
        'id_curso',
        'desc_subsecuente',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso', 'id_curso');
    }
}
