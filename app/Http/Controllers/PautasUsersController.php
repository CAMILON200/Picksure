<?php

namespace App\Http\Controllers;

use App\Models\Parameters;
use App\Models\PaymentHistory;
use App\Models\PautasUsers;
use App\Models\CategoriesPauta;
use App\Models\LocationsPauta;
use App\Models\Imageproduct;
use App\Models\ImagesPautas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PautasUsersController extends Controller
{
  /**
   * STATUS PAUTAS
   * 1 = PENDIENTE
   * 2 = APROBADO
   * 0 = RECHAZADO
   */
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
  public function index(Request $request, $location)
  {  	
    $image = [];
    if($location != ''){
      $image = DB::select("SELECT pu.id , pu.img_url , pu.destination_url , pu.description , 
        pu.user_id , u.avatar , CONCAT(u.name,' ',u.last_name) as name, pu.start_date, pu.end_date, pu.valor 
        FROM pautas_users pu 
        INNER JOIN users u ON u.id = pu.user_id
        LEFT JOIN locations_pautas lp ON lp.pauta_id = pu.id
        WHERE CURRENT_DATE() BETWEEN pu.start_date
        and pu.end_date and pu.status = 2 and lp.location_prefix = '$location'", []);
    }
      
    $response['status'] = 200;
    $response['data'] = $image; 
    
    return response()->json($response, $response['status']);
  } 
  
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
  public function pautaForCategory(Request $request, $location, $category_id)
  {  	
    $image = [];
    if($location != ''){
      $image = DB::select("SELECT pu.id , pu.img_url , pu.destination_url , pu.description , 
        pu.user_id , u.avatar , CONCAT(u.name,' ',u.last_name) as name, pu.start_date, pu.end_date, pu.valor 
        FROM pautas_users pu 
        INNER JOIN users u ON u.id = pu.user_id
        LEFT JOIN locations_pautas lp ON lp.pauta_id = pu.id
        LEFT JOIN categories_pautas cp ON cp.pauta_id = pu.id 
        WHERE CURRENT_DATE() BETWEEN pu.start_date AND pu.end_date 
        AND pu.status = 2 AND lp.location_prefix = '$location' AND cp.category_id = $category_id", []);
    }
      
    $response['status'] = 200;
    $response['data'] = $image; 
    
    return response()->json($response, $response['status']);
  } 

  public function payPauta(Request $request) {
    $imgsData = Imageproduct::where('id', intval($request->imgs_pauta[0]))->first();
  
    $pauta = new PautasUsers;
    $pauta->user_id = $request->user_id;
    $pauta->start_date = $request->start_date;
    $pauta->end_date = $request->end_date;
    $pauta->valor = $request->valor;
    $pauta->description = $request->description_pauta;
    $pauta->destination_url = $request->destination_url;
    $pauta->img_url = $imgsData->img_url;
    $pauta->status = 1;
    $pauta->save();
    
    $result_id = $pauta->id;
  
    $imgs_pauta = $request->imgs_pauta;
    if(count($imgs_pauta) > 0){
      foreach ($imgs_pauta as $key => $value) {
        $images_pautas = ImagesPautas::create([
          'imageproducts_id' => $value,
          'pautasuser_id' => $result_id
        ]);
      } 	
      DB::commit();
    }

    $categories_pauta = $request->categories_pauta;
    if(count($categories_pauta) > 0){
      foreach ($categories_pauta as $key => $value) {
        $category_pauta = CategoriesPauta::create([
          'category_id' => $value,
          'pauta_id' => $result_id
        ]);
      } 	
      DB::commit();
    }
    
    $locations_pauta = $request->locations_pauta;
    if(count($locations_pauta) > 0){
      foreach ($locations_pauta as $key => $value) {
        $location_pauta = LocationsPauta::create([
          'location_prefix' => $value,
          'pauta_id' => $result_id
        ]);
      } 	
      DB::commit();
    }

    $payment_history = new PaymentHistory;
    $payment_history->user_id = $request->user_id;
    $payment_history->payment_reference = 'PAUTA';
    $payment_history->amount = $request->valor;
    $payment_history->is_approved = 1;
    $payment_history->reference_payment = $request->reference_payment;
    $payment_history->date_payment = date("Y-m-d H:i:s");
    $payment_history->save();

    $response["status"] = 200;
    $response["id"] = $result_id;
    $response["message"] = 'La pauta creada exitosamente.';

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
  public function activePauta(Request $request) {
    $pauta = PautasUsers::find($request->id);
    $pauta->status = $request->status;
    $pauta->save();

    $response["status"] = 200;
    $response["data"] = $pauta;
    $response["message"] = 'La pauta se actualizo exitosamente.';

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