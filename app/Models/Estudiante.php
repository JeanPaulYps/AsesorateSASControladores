<?php

namespace App\Models;

//use Illuminate\Notifications\Notifiable;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Estudiante extends Model //extends Authenticatable
{
    //use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $table = "estudiantes";
    protected $primaryKey = 'cedula';
    protected $fillable = [
        'cedula','nombre', 'correo',
        'contrasenia','telefono'
    ];

    public function roles(){
    	return $this-> belongsToMany('App\Models\Rol',"asignacion_roles",'cedula','rol');
    }

    
    public static function validarContrasena($contrasena,&$error_contrasena){
        if(strlen($contrasena) < 6){
          $error_contrasena = "La contraseña debe tener al menos 6 caracteres";
          return false;
       }
       if(strlen($contrasena) > 16){
          $error_contrasena = "La contraseña no puede tener más de 16 caracteres";
          return false;
       }
       if (!preg_match('`[a-z]`',$contrasena)){
          $error_contrasena = "La contraseña debe tener al menos una letra minúscula";
          return false;
       }
       if (!preg_match('`[A-Z]`',$contrasena)){
          $error_contrasena = "La contraseña debe tener al menos una letra mayúscula";
          return false;
       }
       if (!preg_match('`[0-9]`',$contrasena)){
          $error_contrasena = "La contraseña debe tener al menos un caracter numérico";
          return false;
       }
       $error_contrasena = "";
       return true;
    }

    public static function verificarDatos($cedula,$nombre,$correo,$contrasena,$telefono){
        if($cedula!=''&&$nombre!=''&&$correo!=''&&$contrasena!=''&&$telefono!=''){
            return true;
        }
        else
            return false;
    }

}
