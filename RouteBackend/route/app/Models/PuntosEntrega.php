<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuntosEntrega extends Model
{
    //
    protected $table = "puntos_entregas";
    protected $primaryKey = "IDPUNTOS_ENTREGA";
    protected $fillable = [
        'IDRUTAS',
        'DIRECCION',
        'ORDEN',
        'ENTREGADO',
    ];

    //Establecer la relación con la tabla rutas
    //Un punto de entrega pertener a una ruta
    public function ruta(){
        return $this->belongsTo(Rutas::class, 'IDRUTAS', 'IDRUTAS');
    }
}
