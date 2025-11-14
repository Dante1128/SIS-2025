<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoPersona extends Model
{
    use HasFactory;

    protected $table = 'CargoPersona';
    protected $primaryKey = 'id_cargopersona';
    public $timestamps = false;

    protected $fillable = [
        'id_cargo',
        'id_persona',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'id_cargo', 'id_cargo');
    }
}
