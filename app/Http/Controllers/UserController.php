<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PaymentHistory;
use App\Models\GiftVoucher;
use App\Models\UserLikeCategory;
use App\Models\UserLikeImageproduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{

  public function index(Request $request)
  {    	
    $user = User::all();
    return response()->json($user, 200);
  }
/**
     * @OA\Post(
     *  tags={"Likes"},
     *  summary="Crea like que un usuario de a las imagenes",
     *  description="Crea like que un usuario de a las imagenes",
     *  path="/api/v1/user/like_imageproduct/{user_id}/{img_id}",
     *  security={{ "bearerAuth": {} }},
     * * @OA\Parameter(
     *    name="user_id",
     *    in="path",
     *    description="Id del usuario",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     * * @OA\Parameter(
     *    name="img_id",
     *    in="path",
     *    description="Id de la imagen",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     * @OA\Response(
     *    response=200,
     *    description="Resultado de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example="200"),
     *       @OA\Property(property="title de la imagen", type="varchar", example="String")
     *    )
     *  ),
     *  @OA\Response(
     *    response=422,
     *    description="Estado Invalido de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="No esxite like"),
     *       @OA\Property(property="errors", type="string", example="..."),
     *    )
     *  )
     * )
     */
  /**Create Like ImageProduct*/
  public function createLikeImageproduct(Request $request,$user_id, $img_id)
  {
    $likeImageproduct = UserLikeImageproduct::create([
      'user_id' => $user_id,
      'imageproduct_id' => $img_id
    ]);
    DB::commit();
    return response()->json($likeImageproduct, 200);
  }
   /**
     * @OA\Get(
     *  tags={"User"},
     *  summary="Devuelve todos los likes realizados por un usuario",
     *  description="Retorna un Json con todos los likes  realizados por un usuario a las imagenes filtrandolo por el idioma",
     *  path="/api/v1/user/like_imageproduct/{user_id}/{lang_id}",
     *  security={{ "bearerAuth": {} }},
     * @OA\Parameter(
     *    name="user_id",
     *    in="path",
     *    description="Id del usuario",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     * * @OA\Parameter(
     *    name="lang_id",
     *    in="path",
     *    description="Id del lenguaje",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     * @OA\Response(
     *    response=200,
     *    description="Resultado de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example="200"),
     *       @OA\Property(property="title de la imagen", type="varchar", example="String")
     *    )
     *  ),
     *  @OA\Response(
     *    response=422,
     *    description="Estado Invalido de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="No esxite like"),
     *       @OA\Property(property="errors", type="string", example="..."),
     *    )
     *  )
     * )
     */
    public function showLikeImageproduct($user_id,$language)
    {
      $user_id = DB::table('user_like_imageproduct')
        ->join('imageproducts', 'imageproducts.id', '=', 'user_like_imageproduct.imageproduct_id')
        ->join('texts_imageproducts','texts_imageproducts.imageproduct_id', '=', 'imageproducts.id')
        ->select('imageproducts.img_url','user_like_imageproduct.user_id', 'imageproducts.id','texts_imageproducts.language','texts_imageproducts.title', 'texts_imageproducts.description')
        ->where('user_like_imageproduct.user_id', $user_id)
        ->where('texts_imageproducts.language', $language)
        ->get();
      if(!count($user_id) > 0){
        $response['status'] = Response::HTTP_NOT_FOUND;
        $response['data'] = [];
       }else{
        $response['status'] = Response::HTTP_OK;
        $response['data'] = $user_id;
      }
      return $response['data'];
    }
    /**
     * @OA\Delete(
     *  tags={"Likes"},
     *  summary="Elimina un like dado por un usuairo",
     *  description="Elimina un like dado por un usuairo a una imagen",
     *  path="/api/v1/user/like_imageproduct/{user_id}/{img_id}",
     *  security={{ "bearerAuth": {} }},
     * * @OA\Parameter(
     *    name="user_id",
     *    in="path",
     *    description="Id del usuario",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     * * @OA\Parameter(
     *    name="img_id",
     *    in="path",
     *    description="Id de la imagen a la que desea eliminarle el like",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     * @OA\Response(
     *    response=200,
     *    description="Resultado de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example="200"),
     *       @OA\Property(property="title de la imagen", type="varchar", example="String")
     *    )
     *  ),
     *  @OA\Response(
     *    response=422,
     *    description="Estado Invalido de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Like eliminado"),
     *       @OA\Property(property="errors", type="string", example="..."),
     *    )
     *  )
     * )
     */
    /**Delete Like ImageProduct*/
  public function deleteLikeImageproduct($user_id, $img_id)
  {
    $delete = DB::table('user_like_imageproduct')
    ->where('user_id', $user_id)  
    ->where('imageproduct_id', $img_id )
    ->delete();
    return response()->json('Se elimino este like', 200);
  }

    /**
     * @OA\Post(
     *  tags={"Likes"},
     *  summary="Crea like que un usuario de a las categorias",
     *  description="Crea like que un usuario de a las categorias",
     *  path="/api/v1/user/like_category/{user_id}/{category_id}",
     *  security={{ "bearerAuth": {} }},
     * * @OA\Parameter(
     *    name="user_id",
     *    in="path",
     *    description="Id del usuario",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     * * @OA\Parameter(
     *    name="category_id",
     *    in="path",
     *    description="Id de la categoria",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     * @OA\Response(
     *    response=200,
     *    description="Resultado de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example="200"),
     *       @OA\Property(property="title de la imagen", type="varchar", example="String")
     *    )
     *  ),
     *  @OA\Response(
     *    response=422,
     *    description="Estado Invalido de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="No esxite like"),
     *       @OA\Property(property="errors", type="string", example="..."),
     *    )
     *  )
     * )
     */
  public function createLikeCategory(Request $request)
  {

    $response = ['status' => 404, 'data' => [] ];

    $delete = DB::table('user_like_category')
    ->where('user_id', $request->user_id)
    ->delete();

    foreach($request->categories as $category){
      $likeCategory = UserLikeCategory::create([
        'user_id' => $request->user_id,
        'category_id' => $category
      ]);
    }    
    $getLikeCategory = $this->showLikeCategory($request->user_id, 'ES');
    $response = ['status' => true, 'data' => $getLikeCategory ];
    return response()->json($response, 200);
  }

/**
     * @OA\Delete(
     *  tags={"Likes"},
     *  summary="Elimina un like dado por un usuario",
     *  description="Elimina un like dado por un usuairo a una categoria",
     *  path="/api/v1/user/like_category/{user_id}/{category_id}",
     *  security={{ "bearerAuth": {} }},
     * * @OA\Parameter(
     *    name="user_id",
     *    in="path",
     *    description="Id del usuario",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     * * @OA\Parameter(
     *    name="category_id",
     *    in="path",
     *    description="Id de la categoria a la cual desea eliminar el like",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     * @OA\Response(
     *    response=200,
     *    description="Resultado de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example="200"),
     *       @OA\Property(property="title de la imagen", type="varchar", example="String")
     *    )
     *  ),
     *  @OA\Response(
     *    response=422,
     *    description="Estado Invalido de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Se eliminó el like a esta categoria"),
     *       @OA\Property(property="errors", type="string", example="..."),
     *    )
     *  )
     * )
     */
  /**Delete Like Category*/
  public function deleteLikeCategory($user_id,$category_id )
  {
    $delete = DB::table('user_like_category')
    ->where('user_id', $user_id)  
    ->where('category_id', $category_id)
    ->delete();

    return response()->json('Se elimino este like', 200);
  }
  /**Select Like Category*/

  /**
     * @OA\Get(
     *  tags={"User"},
     *  summary="Devuelve todos los likes realizados por un usuario",
     *  description="Retorna un Json con todos los likes  realizados por un usuario a las categorias filtrandolo por el lenguaje",
     *  path="/api/v1/user/like_category/{user_id}/{lang_id}",
     *  security={{ "bearerAuth": {} }},
     * @OA\Parameter(
     *    name="user_id",
     *    in="path",
     *    description="Id del usuario",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     *    * @OA\Parameter(
     *    name="lang_id",
     *    in="path",
     *    description="Id del lenguaje",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     * @OA\Response(
     *    response=200,
     *    description="Resultado de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example="200"),
     *       @OA\Property(property="title de la imagen", type="varchar", example="String")
     *    )
     *  ),
     *  @OA\Response(
     *    response=422,
     *    description="Estado Invalido de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="No esxite like"),
     *       @OA\Property(property="errors", type="string", example="..."),
     *    )
     *  )
     * )
     */
  public function showLikeCategory($user_id,$language)
  {
    //$likeCategory = UserLikeCategory::where('user_id', $request->id)->get();
    $user_id = DB::table('user_like_category')
      ->join('categories', 'categories.id', '=', 'user_like_category.category_id')
      ->join('texts_categories','texts_categories.category_id', '=', 'categories.id')
      ->select('user_like_category.user_id', 'categories.id as value','texts_categories.language','texts_categories.name as label')
      ->where('user_like_category.user_id', $user_id)
      ->where('texts_categories.language', $language)
      ->get();
     if(!count($user_id) > 0){
      $response['status'] = Response::HTTP_NOT_FOUND;
      $response['data'] = [];

    }else{
      $response['status'] = Response::HTTP_OK;
      $response['data'] = $user_id;
    }
    return $response['data'];
    
  }

  /**
     * @OA\Post(
     *  tags={"Usuarios"},
     *  summary="Crea un nuevo usuario",
     *  description="Crea un nuevo usuario en el sistema",
     *  path="/api/v1/user/create_users/{user_id}",
     *  security={{ "bearerAuth": {} }},
     * * @OA\Parameter(
     *    name="Name",
     *    in="path",
     *    description="Nombre de usuario",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="varchar",
     *    )
     *  ),
     * * @OA\Parameter(
     *    name="email",
     *    in="path",
     *    description="Correo",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     *  * * @OA\Parameter(
     *    name="password",
     *    in="path",
     *    description="Contraseña",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     * @OA\Response(
     *    response=200,
     *    description="Resultado de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example="200"),
     *       @OA\Property(property="title de la imagen", type="varchar", example="String")
     *    )
     *  ),
     *  @OA\Response(
     *    response=422,
     *    description="Estado Invalido de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="No esxite like"),
     *       @OA\Property(property="errors", type="string", example="..."),
     *    )
     *  )
     * )
     */
  public function CreateUser(Request $request)
  {
    $response = ['status' => 404, 'data' => [] ];
    $data = json_decode($request->getContent());
    $user = new User;
    $user->name = $data->name;
    $user->last_name = $data->last_name;
    $user->email = $data->email;
    $user->password = bcrypt($data->password);
    $user->date_of_birth = $data->date_of_birth;
    $user->location = $data->location;
    $user->phone = $data->phone;
    $user->role_id = $data->role_id;
    
    $user->save();

    $userInfo = User::where('email', $data->email)->first();
    $userInfo["suscriptions"] = [];
    $userInfo["pautantes"] = [];
    $userInfo["pautantes_history"] = [];
    $userInfo["likeCategory"] = [];
    $userInfo["likeImageproduct"] = [];
    //return redirect('/home');
    $response["status"] = 200;
    $response["data"] = $userInfo;
    return response()->json($response, $response['status']);

  }

  /**
     * @OA\Delete(
     *  tags={"Usuarios"},
     *  summary="Elimina un usuario",
     *  description="Elimina un usuario",
     *  path="/api/v1/user/delete_users/{user_id}",
     *  security={{ "bearerAuth": {} }},
     * * @OA\Parameter(
     *    name="user_id",
     *    in="path",
     *    description="Id del usuario",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     * @OA\Response(
     *    response=200,
     *    description="Resultado de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example="200"),
     *       @OA\Property(property="title de la imagen", type="varchar", example="String")
     *    )
     *  ),
     *  @OA\Response(
     *    response=422,
     *    description="Estado Invalido de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Se eliminó este usuario"),
     *       @OA\Property(property="errors", type="string", example="..."),
     *    )
     *  )
     * )
  */
  public function DeleteUser($user_id){

    $delete = DB::table('users')
    ->where('id', $user_id)  
    ->delete();

    return response()->json('Usuario eliminado', 200);
  }

  /**
       * @OA\Put(
       *  tags={"Usuarios"},
       *  summary="Actualiza la información de un usuario",
       *  description="Actualiza la información de un usuario seleccionado",
       *  path="/api/v1/user/update_users/{user_id}",
       *  security={{ "bearerAuth": {} }},
       * * @OA\Parameter(
       *    name="user_id",
       *    in="path",
       *    description="Id del usuario",
       *    required=true,
       *    @OA\Schema(
       *      default="1",
       *      type="integer",
       *    )
       *  ),
       * @OA\Response(
       *    response=200,
       *    description="Resultado de la Operación",
       *    @OA\JsonContent(
       *       @OA\Property(property="status", type="integer", example="200"),
       *       @OA\Property(property="title de la imagen", type="varchar", example="String")
       *    )
       *  ),
       *  @OA\Response(
       *    response=422,
       *    description="Estado Invalido de la Operación",
       *    @OA\JsonContent(
       *       @OA\Property(property="message", type="string", example="No esxite like"),
       *       @OA\Property(property="errors", type="string", example="..."),
       *    )
       *  )
       * )
  */
  public function UpdateUser(Request $request, $user_id, $lang){
    $user = User::find($user_id);
    $user->name = $request->name;
    $user->last_name = $request->last_name;
    $user->phone = $request->phone;
    $user->date_of_birth = $request->date_of_birth;
    $user->update();

    return $this->ShowInfoUser($user_id, $lang);
  }

  public function PaySuscription(Request $request) {
    if(isset($request->gift_voucher)){
      $giftVoucher = GiftVoucher::find($request->gift_voucher);
      $giftVoucher->state = 0;
      $giftVoucher->update();
    }

    $user = User::find($request->id);
    $user->start_date_subscriber = $request->start_date_subscriber;
    $user->end_date_subscriber = $request->end_date_subscriber;
    $user->update();

    $payment_history = new PaymentHistory;
    $payment_history->user_id = $request->id;
    $payment_history->payment_reference = $request->payment_reference;
    $payment_history->amount = $request->amount;
    $payment_history->is_approved = $request->is_approved;
    $payment_history->reference_payment = $request->reference_code;
    $payment_history->date_payment = date("Y-m-d H:i:s");
    $payment_history->save();

    $response["status"] = 200;
    $response["message"] = 'Se actualizo correctamente';

    return response()->json($response, $response['status']);
  }

  public function ConfirmSuscription(Request $request) {
    /* $payHistoryFind = PaymentHistory::where('reference_payment', $request->reference_payment)->first();

    $user = User::find($payHistoryFind->user_id);
    $user->start_date_subscriber = $request->start_date_subscriber;
    $user->end_date_subscriber = $request->end_date_subscriber;
    $user->update();
    */

    $paymentHistory = PaymentHistory::find('reference_payment', $request->reference_payment);
    $paymentHistory->state = $request->transactionState == 4 ? 1 : 0;
    $paymentHistory->update();

    $response["status"] = 200;
    $response["message"] = 'Se actualizo correctamente';

    return response()->json($response, $response['status']);
  }

  /**
     * @OA\Get(
     *  tags={"Usuarios"},
     *  summary="Muestra toda la informacion",
     *  description="Muestra toda la informacion del usuario",
     *  path="/api/v1/user/show_users/{user_id}",
     *  security={{ "bearerAuth": {} }},
     * * @OA\Parameter(
     *    name="user_id",
     *    in="path",
     *    description="Id del usuario",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     * @OA\Response(
     *    response=200,
     *    description="Resultado de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example="200"),
     *       @OA\Property(property="title de la imagen", type="varchar", example="String")
     *    )
     *  ),
     *  @OA\Response(
     *    response=422,
     *    description="Estado Invalido de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="No esxite este usuario"),
     *       @OA\Property(property="errors", type="string", example="..."),
     *    )
     *  )
     * )
  */
  public function ShowInfoUser($user_id, $lang){

    $$user_id = DB::table('users')
      ->join('roles', 'users.role_id', '=', 'roles.id')
      ->select(
        'users.id', 
        'users.name', 
        'users.last_name', 
        'roles.name as name_rol',
        'users.email', 
        'users.date_of_birth', 
        'users.phone', 
        'users.location', 
        'users.created_at',
        'users.email_verified_at',
        'users.start_date_subscriber',
        'users.end_date_subscriber',
        'users.start_date_pautante',
        'users.end_date_pautante',
        'users.avatar'
      )
      ->where('users.id', $user_id)
      ->first();
      if(!$$user_id){
        $response['status'] = Response::HTTP_NOT_FOUND;
        $response['data'] = 'Este usuario no existe';
      }else{
        $payment_suscription = [];
        $payment_pautante = [];

        //if($$user_id->is_subscriber == 1){
        $payment_suscription = DB::table('payment_histories')
        ->select(
          'payment_histories.payment_reference', 
          'payment_histories.amount', 
          'payment_histories.created_at', 
          'payment_histories.reference_payment', 
        )
        ->where('payment_histories.payment_reference', 'SUSCRIPTION')
        ->where('payment_histories.user_id', $user_id)
        ->get();
        //}
        //if($$user_id->is_pautante == 1){
        $payment_pautante = DB::table('payment_histories')
        ->select(
          'payment_histories.payment_reference', 
          'payment_histories.amount', 
          'payment_histories.created_at', 
          'payment_histories.reference_payment', 
        )
        ->where('payment_histories.payment_reference', 'PAUTA')
        ->where('payment_histories.user_id', $user_id)
        ->get();
        //}

        $pautantes_history = DB::select("SELECT pu.id , pu.img_url , pu.destination_url , pu.description , 
        pu.user_id , u.avatar , CONCAT(u.name,' ',u.last_name) as name, pu.start_date, pu.end_date, pu.valor 
        FROM pautas_users pu 
        INNER JOIN users u ON u.id = pu.user_id
        WHERE pu.user_id = $user_id ORDER BY pu.created_at DESC", []);

        $likeCategory = $this->showLikeCategory($user_id, $lang);
        $likeImageproduct = $this->showLikeImageproduct($user_id, $lang);

        $$user_id->suscriptions = $payment_suscription;
        $$user_id->pautantes = $payment_pautante;
        $$user_id->pautantes_history = $pautantes_history;
        $$user_id->likeCategory = $likeCategory;
        $$user_id->likeImageproduct = $likeImageproduct;

        $response['status'] = Response::HTTP_OK;
        $response['data'] = $$user_id;
      }
      return response()->json($response, $response['status']); 
  }

  public function AvatarUser(Request $request) {
    $user = User::find($request["user_id"]);
    
    if ($request->hasFile('img_url')) {
      
      $request->validate([
        'img_url' => 'required|image|max:80000', // Máximo 20 MB (20480 kilobytes)
      ]);

      $file = $request->file('img_url');
      $path = $file->store('users/'.$request["user_id"], 'public');

      $user->avatar = $path;
      $user->save();
      
      $response['status'] = Response::HTTP_OK;
      $response['data'] = $path;
  
      return response()->json($response, $response['status']); 
    }

  }

  public function VerifyEmail(Request $request) {
    $response['status'] = Response::HTTP_OK;
    if (User::where('email', $request->email)->exists()) {
      $response['exist'] = true;
    } else {
      $response['exist'] = false;
    }
    return response()->json($response, $response['status']);
  }

  public function InactiveAccount(Request $request) {
    $user = User::find($request->id);
    $user->status = 0;
    $user->update();

    $response['status'] = Response::HTTP_OK;
    $response['data'] = $user;
    return response()->json($response, $response['status']);
  }

  public function ResetPassword(Request $request) {
    $userData = User::where('email', $request->email)->first();

    $sr = json_encode($userData);
    $encript = base64_encode($sr);
    $response['data'] = 'Se envio un mensaje de texto';

    $url = env('APP_URL')."/resetpassword/". $encript."/".$request->lang;

    $mail = new PHPMailer(true);     // Passing `true` enables exceptions

    try {
      $mail->SMTPDebug = 0;
      $mail->isSMTP();
      $mail->Host = env('MAIL_HOST');
      $mail->SMTPAuth = true;
      $mail->Username = env('MAIL_USERNAME');
      $mail->Password = env('MAIL_PASSWORD');
      $mail->SMTPSecure = env('MAIL_ENCRYPTION');
      $mail->Port = env('MAIL_PORT');

      $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
      $mail->addAddress($request->email);

      $mail->isHTML(true);

      if($request->lang == 'ES'){
        $mail->Subject = 'Recuperar Contraseña';
        $mail->Body    = 'Para cambiar tu contraseña debes ingresar a este link. '. $url;
      }else{
        $mail->Subject = 'Recover Password';
        $mail->Body    = 'To change your password you must enter this link. '. $url;
      }

      if( !$mail->send() ) {
          //return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
          $response['data'] = 'failed", "Email not sent.'.$mail->ErrorInfo;
      } else {
        $response['data'] =  "Email has been sent.";
      }
      
      //$request->email;
      $response['status'] = Response::HTTP_OK;

      $response['valid'] = 'OK';
      return response()->json($response, $response['status']);

    } catch (Exception $e) {
      //$request->email;
      $response['status'] = Response::HTTP_OK;

      $response['valid'] = 'NOK';
      $response['data'] = 'Message could not be sent. '.$e;
      return response()->json($response, $response['status']);
    }

  }

  public function ChangePassword(Request $request) {
    $newpass = bcrypt($request->pass);

    $user = User::find($request->id);
    $user->password = $newpass;
    $user->update();

    $response['status'] = Response::HTTP_OK;
    $response['data'] = $user;
    return response()->json($response, $response['status']);
  }
}