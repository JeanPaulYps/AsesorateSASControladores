<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspirante;

class AspiranteController extends Controller
{
    //
    public function registroAspirante(Request $req){
        $data = $req->json()->all();
        $cedula = $data["cedula"];
        $nombre = $data["nombre"];
        $correo = $data["correo"];
        $campo_de_area = $data["campo_de_area"];
        $nivel = $data["nivel"];
        $telefono = $data["telefono"];

        $aspirante = new Aspirante();

        $count = Aspirante::where('correo', '=', $correo)->count();

                //validaciones
        if (Aspirante::verificarDatos($cedula,$nombre,$correo,$campo_de_area,$nivel,$telefono) &&
            $count==0){
            $aspirante->nombre = $nombre;
            $aspirante->cedula = $cedula;
            $aspirante->correo = $correo;
            $aspirante->telefono = $telefono;
            $aspirante->campo_de_area = $campo_de_area;
            $aspirante->nivel = $nivel;
            $aspirante->save();
            return response()
                ->json(['message'=>'El aspirante se ha registrado correctamente.']);
           }
        return response()
           ->json(['message'=>'Todos los campos son obligatorios o el correo ya esta registrado.']);
    }

}
