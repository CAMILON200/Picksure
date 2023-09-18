<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

  /**
     * @OA\POST(
     *  tags={"Auth"},
     *  summary="Login de Usuario y Generación de Token",
     *  description="Retorna un Json con el Token del Usuario",
     *  path="/api/v1/auth/token",
     *  @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="application/raw",
     *          @OA\Schema(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="flover.sanchez@ziel.com.co"),
     *             @OA\Property(property="password", type="string", example="password"),
     *          )
     *      ),
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="Resultado de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="integer", example="200"),
     *       @OA\Property(property="msg", type="string", example="TTpPem996u4yMZ"),
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
  public function login(Request $request)
  {    	
    $response = ['status' => 404, 'msg' => '' ];
    $data = json_decode($request->getContent());
    $user = User::where('email', $data->email)->first();
    if($user){
      if(Hash::check($data->password, $user->password)){
        //$token = $user->createToken('example');
        $token = $user->id;
        $response['status'] = 200;
        $response['msg'] = $token; 
      }else {
        $response['status'] = 402;
        $response['msg'] = 'Password Incorrecta.';  
      }
    }else {
      $response['status'] = 402;
      $response['msg'] = 'Usuario no existe.';
    }
    return response()->json($response, $response['status']);
  }

	public function index(Request $request)
  {    	
  }

}