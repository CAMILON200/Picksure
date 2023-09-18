<?php

namespace App\Http\Controllers;

use App\Models\Town;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class TownController extends Controller
{
    /**
     * @OA\Get(
     *  tags={"Municipios"},
     *  summary="Devuelve todos los Municipios asignados a un departamento",
     *  description="Retorna un Json con los Datos de los Municipios.",
     *  path="/api/v1/town/department/{idDepartment}",
     *  security={{ "bearerAuth": {} }},
     *  operationId="index",
     *  @OA\Parameter(
     *    name="idDepartment",
     *    in="path",
     *    description="ID del Departamento",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="Resultado de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="integer", example="1"),
     *       @OA\Property(property="name", type="string", example="Cali"),
     *    )
     *  ),
     *  @OA\Response(
     *    response=422,
     *    description="Estado Invalido de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Los datos son incorrectos."),
     *       @OA\Property(property="errors", type="string", example="..."),
     *    )
     *  )
     * )
     */
  public function department($depar_id)
  {    	
    $town = Town::select(['id', 'name'])
    ->where('department_id', $depar_id)
    // ->orderBy('name', 'asc')
    ->get();
    if(!count($town) > 0){
      $response['status'] = Response::HTTP_NOT_FOUND;
      $response['data'] = 'No existe este departamento';
      
    }else{
      $response['status'] = Response::HTTP_OK;
      $response['data'] = $town;
    }
    return response()->json($response, $response['status']);

    

  }
}