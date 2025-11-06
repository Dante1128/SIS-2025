<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdominio extends Model
{
    use HasFactory;

    protected $table = 'subdominio';
    protected $primaryKey = 'id_subdominio';
    public $timestamps = false;

    protected $fillable = ['descripcion', 'estado', 'id_dominio'];

    public function dominio()
    {
        return $this->belongsTo(Dominio::class, 'id_dominio', 'id_dominio');
    }
}
