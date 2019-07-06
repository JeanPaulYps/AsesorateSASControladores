<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Tutor;
use App\Models\Aspirante;
use App\Models\Rol;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EstudianteController extends Controller
{
    public function registro(Request $req){
        $data = $req->json()->all();
        $cedula = $data["cedula"];
        $nombre = $data["nombre"];
        $correo = $data["correo"];
        $contrasena = $data["contrasena"];
        $telefono = $data["telefono"];
        $error_contrasena = "";
        $estudiante = new Estudiante();

        $count = Estudiante::where('correo', '=', $correo)->count();

        //validaciones
        if (Estudiante::verificarDatos($cedula,$nombre,$correo,$contrasena,$telefono) &&
            Estudiante::validarContrasena($contrasena,$error_contrasena) && $count==0){
                $estudiante->nombre = $nombre;
                $estudiante->cedula = $cedula;
                $estudiante->correo = $correo;
                $estudiante->telefono = $telefono;
                $estudiante->contrasenia = Hash::make($contrasena);
                $estudiante->save();
                $estudiante->roles()->attach('Estudiante');
                return response()
                        ->json(['message'=>'El estudiante se ha registrado correctamente.']);
            }
        return response()
            ->json(['message'=>'Todos los campos son obligatorios o el correo ya esta registrado.',
            'msgContrasena'=>$error_contrasena]);
    }

    public function registroAdminInicial(Request $req){
        $data = $req->json()->all();
        $clave = $data["clave"];
        $admin = new Estudiante;

        if (Rol::verificarHash($clave)){
            $admin->nombre = 'Admin';
            $admin->cedula = '0';
            $admin->correo = '000@asesoratesas.com';
            $admin->telefono = '000';
            $admin->contrasenia = Hash::make('A123456dmin');
            $admin->save();
            $admin->roles()->attach('Administrador');
            return response()
                ->json(['message'=>'Administrador registrado correctamente.']);
        }
        return response()
            ->json(['message'=>'Clave invalida']);
    }

    public function verificarCorreo(Request $req){
        $data = $req->json()->all();
        $correo = $data["correo"];
        $modelo = $data["modelo"];
        $count = 1;
        if($modelo=='Estudiante'){
            $count = Estudiante::where('correo', '=', $correo)->count();
        }elseif($modelo=='Tutor'){
            $count = Tutor::where('correo', '=', $correo)->count();
        }elseif($modelo=='Aspirante'){
            $count = Aspirante::where('correo', '=', $correo)->count();
        }
        
        if ($count==0){
            return response()
            ->json(['message'=>True]);
        }
        return response()
        ->json(['message'=>False]);
    }

    public function verificarCedula(Request $req){
        $data = $req->json()->all();
        $cedula = $data["cedula"];
        $modelo = $data["modelo"];
        $count = 1;
        if($modelo=='Estudiante'){
            $count = Estudiante::where('cedula', '=', $cedula)->count();
        }elseif($modelo=='Tutor'){
            $count = Tutor::where('cedula', '=', $cedula)->count();
        }elseif($modelo=='Aspirante'){
            $count = Aspirante::where('cedula', '=', $cedula)->count();
        }
        
        if ($count==0){
            return response()
            ->json(['message'=>True]);
        }
        return response()
        ->json(['message'=>False]);
    }

    public function ingreso(Request $req){
        $data = $req->json()->all();
        $correo = $data["correo"];
        $password = $data["password"];
        
        $estudiante = Estudiante::where('correo','=', $correo) -> get();
        $count = Estudiante::where('correo', '=',$correo) ->count();
        if($count == 0){
            return response()
                ->json(['message'=>'No hay una cuenta asociada con ese correo']);
        }
        
        $passwordHashed = $estudiante[0]['contrasenia'];
        $cedula = $estudiante[0]['cedula'];
        $rol = DB::table('estudiantes')
            ->where('estudiantes.cedula','=',$cedula)
            ->join('asignacion_roles', 'estudiantes.cedula', '=', 'asignacion_roles.cedula')
            ->join('roles', 'roles.rol', '=', 'asignacion_roles.rol')
            ->select('roles.rol')
            ->get();
            
        if(Hash::check($password, $passwordHashed)){
            return response()
                ->json(['message' => 'ingresado',
                        'cedula' => $cedula,
                        'pass' => $passwordHashed,
                        'rol' => $rol]);
        }
        return response()
            -> json(['message' => 'Usuario y/o contraseña están incorrectas']);
    }

    public function validarSesion(Request $req){
        $data = $req->json()->all();
        $cedula = $data["cedula"];
        $contrasena = $data["contrasena"];
        $rol = $data["rol"];

        $identidad = DB::table('estudiantes')
        ->where('estudiantes.cedula','=',$cedula)
        ->where('estudiantes.contrasenia','=',$contrasena)
        ->join('asignacion_roles', 'estudiantes.cedula', '=', 'asignacion_roles.cedula')
        ->join('roles', 'roles.rol', '=', 'asignacion_roles.rol')
        ->where('roles.rol','=',$rol)
        ->select('roles.rol')->count();

        if ($identidad>0){
            return response()
                ->json(['verif' => True]);
        }else{
            return response()
            ->json(['verif' => False]);
        }

        
    }
}