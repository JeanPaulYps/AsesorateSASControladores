<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutor;

class GestionTutorController extends Controller
{
    //
    public function registrarTutor(Request $req){
        $data = $req->json()->all();
        $cedula = $data["cedula"];
        $nombre = $data["nombre"];
        $correo = $data["correo"];
        $area = $data["area"];
        $nivel = $data["nivel"];
        $porcentaje = $data["porcentaje"];
        $banco = $data["banco"];
        $tipo_cuenta = $data["tipo_cuenta"];
        $numero_cuenta = $data["numero_cuenta"];
        $telefono = $data["telefono"];
        $tutor = new Tutor();

        $count = Tutor::where('correo', '=', $correo)->count();

        //validaciones
        if (Tutor::verificarDatos($cedula,$nombre,$correo,$area,$nivel,$telefono,
            $porcentaje,$banco,$tipo_cuenta,$numero_cuenta) &&
             $count==0){
            $tutor->nombre = $nombre;
            $tutor->cedula = $cedula;
            $tutor->correo = $correo;
            $tutor->telefono = $telefono;
            $tutor->area = $area;
            $tutor->nivel = $nivel;
            $tutor->porcentaje = $porcentaje;
            $tutor->banco = $banco;
            $tutor->tipo_cuenta = $tipo_cuenta;
            $tutor->numero_cuenta = $numero_cuenta;
            $tutor->save();
            return response()
                    ->json(['message'=>'success']);
        }
        return response()
            ->json(['message'=>'Todos los campos son obligatorios o el correo ya esta registrado.']);
    }
    
    public function modificarTutor(Request $req){
        $data = $req->json()->all();
        $cedula = $data["cedula"];
        $nombre = $data["nombre"];
        $correo = $data["correo"];
        $area = $data["area"];
        $nivel = $data["nivel"];
        $porcentaje = $data["porcentaje"];
        $banco = $data["banco"];
        $tipo_cuenta = $data["tipo_cuenta"];
        $numero_cuenta = $data["numero_cuenta"];
        $telefono = $data["telefono"];

        $count = Tutor::where('correo', '=', $correo)->where('cedula', '!=', $cedula)->count();

        //validaciones
        if (Tutor::verificarDatos($cedula,$nombre,$correo,$area,$nivel,$telefono,
            $porcentaje,$banco,$tipo_cuenta,$numero_cuenta) &&
             $count==0){
                Tutor::where('cedula',$cedula)->update([
                    'nombre'=>$nombre,
                    'correo'=>$correo,
                    'area'=>$area,
                    'nivel'=>$nivel,
                    'telefono'=>$telefono,
                    'porcentaje'=>$porcentaje,
                    'banco'=>$banco,
                    'tipo_cuenta'=>$tipo_cuenta,
                    'numero_cuenta'=>$numero_cuenta
                    ]);
                return response()
                ->json(['message'=>'success']);
        }
        return response()
            ->json(['message'=>'Todos los campos son obligatorios o el correo ya esta registrado.']);
    }
    
    public function eliminarTutor(Request $req){
        $data = $req->json()->all();
        $cedula = $data["cedula"];

        $tutor = Tutor::where('cedula','=',$cedula);

        if($tutor->count()>0){
            $tutor->delete();
            return response()
            ->json(['message'=>'success']);
        }
        return response()
            ->json(['message'=>'El tutor no existe.']);
    }

    public function verTutores(Request $req){
        $tutores = Tutor::all();
        return response()
            ->json(['tutores'=>$tutores]);
    }

    public function verificarCorreoModificar(Request $req){
        $data = $req->json()->all();
        $correo = $data["correo"];
        $cedula = $data["cedula"];
        $count = Tutor::where('correo', '=', $correo)->where('cedula', '!=', $cedula)->count();
        if ($count==0){
            return response()
            ->json(['message'=>True]);
        }
        return response()
        ->json(['message'=>False]);
    }
}
