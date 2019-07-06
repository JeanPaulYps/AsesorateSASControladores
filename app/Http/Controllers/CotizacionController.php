<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizacion;
use Illuminate\Support\Facades\DB;

class CotizacionController extends Controller
{
    public function registro(Request $req){
        $categoria = [
			"JUNIOR" => 33000,
			"SENIOR BASIC" => 44000,
			"SENIOR MEDIUM" => 50000,
			"SENIOR ADVANCED 1" => 55000,
			"SENIOR ADVANCED 2" => 60000,
		];
		
		$data = $req->json()->all();		
       
        $id_estudiante = $data["id_estudiante"];
        $horas = $data["horas"];
        $nivel = $data["nivel"];		
        $precio = $horas*$categoria[$nivel];

        //validaciones, solo es una prueba
        $cotizacion = Cotizacion::formatoInsert($id_estudiante, $horas,$nivel,$precio);
        Cotizacion::create($cotizacion);
        return response()
                ->json(['message'=>'Cotizacion creada correctamente.','precio'=> $precio]);
    }
}
