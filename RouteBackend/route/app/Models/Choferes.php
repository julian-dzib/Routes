<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choferes extends Model
{
    //Definir mi modelo ORM
    use HasFactory;

    //Tabla name
    protected $table = 'choferes';
    //Primary key
    protected $primaryKey = 'IDCHOFER';
    //Campos de mi modelo chofer
    protected $fillable = [
        'NOMBRE',
        'TELEFONO',
    ];

    //Definir la relacion que va a tener
    public function rutas(){
        //Un chofer puede tener varias rutas
        return $this->hasMany(Rutas::class, 'IDCHOFER', 'IDCHOFER');
    }

}
