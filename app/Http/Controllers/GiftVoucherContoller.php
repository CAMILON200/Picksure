<?php

namespace App\Http\Controllers;

use App\Models\GiftVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GiftVoucherContoller extends Controller
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
  public function read(Request $request, $code, $type)
  {  	
    $gift = DB::select("SELECT * from gift_voucher where code = '$code' and type_gift = '$type'", []);
    $response = count($gift) > 0 ? $gift[0] : false;
    return response()->json(['success' => true, 'data' => $response]);
  } 
  
}