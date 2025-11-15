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

    public function cargoPersona()
    {
        return $this->hasOne(CargoPersona::class, 'id_persona', 'id_persona');
    }

    public function cargo()
    {
        return $this->hasOneThrough(
            Cargo::class,
            CargoPersona::class,
            'id_persona',
            'id_cargo',
            'id_persona',
            'id_cargo'
        );
    }
}
