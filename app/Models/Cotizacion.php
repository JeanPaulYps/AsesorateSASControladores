<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    public $timestamps = false;
    protected $table = "cotizacion";
    protected $primaryKey = 'id_cotizacion';
    protected $fillable = [
        'id_cotizacion','id_estudiante', 'horas',
        'nivel','precio'
    ];
    public static function formatoInsert($id_estudiante, $horas,$nivel,$precio){
        $cotizacion = ['id_estudiante' =>$id_estudiante,'horas' =>$horas,'nivel' =>$nivel,'precio' =>$precio];
        return $cotizacion;
    }
}
