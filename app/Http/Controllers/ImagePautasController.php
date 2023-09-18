<?php

namespace App\Http\Controllers;

use App\Models\Parameters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ImagePautasController extends Controller
{

  /**
     * @OA\Get(
     *  tags={"Categorias"},
     *  summary="Devuelve todas los Categorias filtrando el lenguage recibido",
     *  description="Retorna un Json con los Datos de las Categorias.",
     *  path="/api/v1/categories/{language}",
     *  security={{ "bearerAuth": {} }},
     *  @OA\Parameter(
     *    name="language",
     *    in="path",
     *    description="Prefijo del idioma",
     *    required=true,
     *    @OA\Schema(
     *      default="ES",
     *      type="string",
     *    )
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="Resultado de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example="200"),
     *       @OA\Property(type="array",@OA\Items(type="array",@OA\Items())),
     *    )
     *  ),
     *  @OA\Response(
     *    response=422,
     *    description="Estado Invalido de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Los datos son incorrectos."),
     *       @OA\Property(property="error", type="string", example="..."),
     *    )
     *  )
     * )
     */
  public function index(Request $request, $user_id, $language)
  {  	
    $image = DB::select("SELECT i.id , i.img_url, ti.title , ti.description , ti.`language` 
    FROM images_pautas ip
    LEFT JOIN pautas_users pu ON pu.id = ip.pautasuser_id 
    INNER JOIN imageproducts i ON i.id = ip.imageproducts_id 
    LEFT JOIN texts_imageproducts ti ON ti.imageproduct_id = i.id 
    WHERE pu.user_id  = $user_id AND ti.language = '$language'", []);
    
    $response['status'] = 200;
    $response['data'] = $image; 
    
    return response()->json($response, $response['status']);
  } 

  /**
     * @OA\Get(
     *  tags={"Categorias"},
     *  summary="Devuelve las categorias y si el usuario las tiene marcada con Like(Me gusta)",
     *  description="Retorna Categorias con Like",
     *  path="/api/v1/categories/user/{language}",
     *  security={{ "bearerAuth": {} }},
     *  @OA\Parameter(
     *    name="language",
     *    in="path",
     *    description="Prefijo del Idioma",
     *    required=true,
     *    @OA\Schema(
     *      default="ES",
     *      type="string",
     *    )
     *  ),
     *  @OA\Parameter(
     *    name="user_id",
     *    in="query",
     *    description="ID del Usuario",
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
  public function categoryUser(Request $request, $language = 'ES'){
    return response()->json($language, 200);
  }
  
}