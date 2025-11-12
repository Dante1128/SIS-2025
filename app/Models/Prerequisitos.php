<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prerequisitos extends Model
{

    protected $table = 'Prerequisitos';
    protected $primaryKey = 'id_prerequisitos';
    public $timestamps = false;

    protected $fillable = [
        'id_curso',
        'desc_prerequisito',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'id_curso', 'id_curso');
    }
}
