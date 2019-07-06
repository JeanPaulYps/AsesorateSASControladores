<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;

class RolController extends Controller
{
    //Esta peticion crea los roles iniciales del sistema (Estudiante,Administrador) y exige una clave
    public function rolesDefecto(Request $req){
        $data = $req->json()->all();
        $clave = $data["clave"];
        if (Rol::verificarHash($clave)){
            Rol::insert(Rol::rolesIniciales());
            return response()
                ->json(['message'=>'Roles inciales creados correctamente']);
        }
        return response()
            ->json(['message'=>'Clave invalida']);
    }
}
