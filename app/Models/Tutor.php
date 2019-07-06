<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    //
    public $timestamps = false;
    protected $table = "tutores";
    protected $primaryKey = 'cedula';
    protected $fillable = [
        'cedula','nombre', 'correo',
        'area','nivel','telefono','porcentaje',
        'banco','tipo_cuenta','numero_cuenta'
    ];

    
    public static function verificarDatos($cedula,$nombre,$correo,$area,$nivel,$telefono,
                                        $porcentaje,$banco,$tipo_cuenta,$numero_cuenta){
        if($cedula!=''&&$nombre!=''&&$correo!=''&&$area!=''&&$telefono!=''&&$nivel!=''&&
            $porcentaje!=''&&$banco!=''&&$tipo_cuenta!=''&&$numero_cuenta!=''){
            return true;
        }
        else
            return false;
    }
}
