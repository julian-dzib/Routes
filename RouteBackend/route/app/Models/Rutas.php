<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rutas extends Model
{
    //
    protected $table = "rutas";
    protected $primaryKey = "IDRUTAS";
    protected $fillable = [
        'NOMBRE',
        'FECHA',
        'IDCHOFER',
    ];

    //Definir la relación con el modelo Choferes
    //Una ruta pertenece a un chofer
    public function chofer(){
        return $this->belongsTo(Choferes::class, 'IDCHOFER', 'IDCHOFER');
    }

    //Definir la relación con el modelo PuntosEntregas
    //Una ruta tiene varios puntos de entrega
    public function puntosEntregas(){
        return $this->hasMany(PuntosEntrega::class, 'IDRUTAS', 'IDRUTAS');
    }
}
