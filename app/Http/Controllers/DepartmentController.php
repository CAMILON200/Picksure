<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DepartmentController extends Controller
{
  /**
     * @OA\Get(
     *  tags={"Departamento"},
     *  summary="Devuelve todos los Departamentos",
     *  description="Retorna un Json con los Datos de los Departamentos.",
     *  path="/api/v1/department",
     *  security={{ "bearerAuth": {} }},
     *  @OA\Response(
     *    response=200,
     *    description="Resultado de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="integer", example="1"),
     *       @OA\Property(property="name", type="string", example="Valle del Cauca"),
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
  public function index(Request $request)
  {    	
    $department = Department::select(['id', 'name'])
    ->orderBy('name','asc')
    ->get();
    return response()->json($department, 200);
  }
}