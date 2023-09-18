<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *   title="PICKSURE - ZIEL DOCUMENTATIONS",
 *   version="1.0.0",
 *   contact={
 *     "email": "info@ziel.com.co"
 *   }
 * )
 * @OA\SecurityScheme(
 *  type="http",
 *  description="Token de acceso obtenido en la autenticación",
 *  name="bearerAuth",
 *  in="header",
 *  scheme="Bearer",
 *  bearerFormat="JWT",
 *  securityScheme="bearerAuth"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
