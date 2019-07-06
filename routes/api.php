<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('registroEstudiante','EstudianteController@registro');
Route::post('rolesPorDefecto','RolController@rolesDefecto'); //Ejecutar primero
Route::post('verificarCorreo','EstudianteController@verificarCorreo');
Route::post('verificarCedula','EstudianteController@verificarCedula');
Route::post('verificarSesion','EstudianteController@validarSesion');
Route::post('registroAdminInicial','EstudianteController@registroAdminInicial');
Route::post('logged', 'EstudianteController@ingreso');

////gestion de tutores
Route::post('registroTutor', 'GestionTutorController@registrarTutor');
Route::post('modificarTutor', 'GestionTutorController@modificarTutor');
Route::post('eliminarTutor', 'GestionTutorController@eliminarTutor');
Route::get('verTutores', 'GestionTutorController@verTutores');
Route::post('verificarCorreoModificar', 'GestionTutorController@verificarCorreoModificar');

//ASPIRANTE
Route::post('registroAspirante', 'AspiranteController@registroAspirante');

//COTIZACION
Route::post('registroCotizacion','CotizacionController@registro');
