<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dominio extends Model
{
    use HasFactory;

    protected $table = 'dominio';
    protected $primaryKey = 'id_dominio';
    public $timestamps = false;

    protected $fillable = ['descripcion', 'estado'];

    public function subdominios()
    {
        return $this->hasMany(Subdominio::class, 'id_dominio', 'id_dominio');
    }
}
