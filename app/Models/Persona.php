<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'Persona';
    protected $primaryKey = 'id_persona';
    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'apellidos',
        'email',
        'genero',
        'celular',
        'cod_persona',
    ];

    public function cargo()
    {
        return $this->hasOne(Cargo::class, 'id_persona', 'id_persona');
    }

    public function rol()
    {
        return $this->hasOne(Rol::class, 'id_persona', 'id_persona');
    }
}
