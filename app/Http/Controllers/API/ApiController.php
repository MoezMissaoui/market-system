<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Market System Project API Documentation",
 *      description="Enjoy with our documentation of Market System project API.",
 *      @OA\Contact(
 *          email="admin@admin.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Demo API Server"
 * )
 *
 * @OA\SecurityScheme(
 *      securityScheme="bearer",
 *      type="http",
 *      scheme="Bearer",
 *      bearerFormat="JWT",
 * )

 */

class ApiController extends Controller
{
    use ApiResponser;
}
