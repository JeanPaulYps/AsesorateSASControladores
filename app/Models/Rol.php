<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    //
    public $timestamps = false;
    protected $table = "roles";
    protected $primaryKey = 'rol';
    protected $fillable = [
        'rol'
    ];

    public function estudiantes(){
    	return $this-> belongsToMany('App\Models\Estudiante',"asignacion_roles",'cedula','rol');
    }

    public function aspirantes(){
    	return $this-> belongsToMany('App\Models\Aspirante',"asignacion_roles",'cedula','rol');
    }

    public static function verificarDatos($cedula,$rol){
        if($rol!=''){
            return true;
        }
        else
            return false;
    }

    public static function verificarHash($hash){
        if ($hash == "9ca116b2e62fa6bde111b32197f3cdc9") {
            return true;
        }
        return false;
    }

    public static function rolesIniciales(){
        return [
            ['rol'=>'Administrador'],
            ['rol'=>'Estudiante']
        ];
    }
}
