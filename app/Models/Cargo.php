<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;

    protected $table = 'Cargo';
    protected $primaryKey = 'id_cargo';
    public $timestamps = false;

    protected $fillable = [
        'nombre_cargo',
        'desc_cargo',
    ];

    public function cargoPersona()
    {
        return $this->hasMany(CargoPersona::class, 'id_cargo', 'id_cargo');
    }
}
