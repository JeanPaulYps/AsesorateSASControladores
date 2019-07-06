<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirante extends Model
{
    //

    public $timestamps = false;
    protected $table = "aspirantes";
    protected $primaryKey = 'cedula';
    protected $fillable = [
        'cedula','nombre', 'correo',
        'campo_de_area','nivel','telefono'
    ];

    
    public static function verificarDatos($cedula,$nombre,$correo,$campo_de_area,$nivel,$telefono){
        if($cedula!=''&&$nombre!=''&&$correo!=''&&$campo_de_area!=''&&$telefono!=''&&$nivel!=''){
            return true;
        }
        else
            return false;
    }
}
