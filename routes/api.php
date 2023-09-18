<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguagesController;
use App\Http\Controllers\ImageproductsController;
use App\Http\Controllers\PautasUsersController;
use App\Http\Controllers\ImagePautasController;
use App\Http\Controllers\ParametersController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TownController;
use App\Http\Controllers\CategoriesController as Category;
use App\Http\Controllers\QualifyController;



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

/**Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
middleware('auth:sanctum')-> */

//Auth
Route::post('/auth/token', [AuthController::class, 'login']);

//Users
Route::middleware('auth:sanctum')->get('/user/like_category/{user_id}/{lang_id}', [UserController::class, 'showLikeCategory']);
Route::post('/user/like_category', [UserController::class, 'createLikeCategory']);
Route::delete('/user/like_category/{user_id}/{category_id}', [UserController::class, 'deleteLikeCategory']);
Route::post('/user/add_like_imageproduct/{user_id}/{img_id}', [UserController::class, 'createLikeImageproduct']);
Route::middleware('auth:sanctum')->get('/user/like_imageproduct/{user_id}/{lang_id}', [UserController::class, 'showLikeImageproduct']);
Route::delete('/user/remove_like_imageproduct/{user_id}/{img_id}', [UserController::class, 'deleteLikeImageproduct']);
Route::post('/user/create_users', [UserController::class, 'CreateUser']);
Route::post('/user/avatar_users', [UserController::class, 'AvatarUser']);
Route::post('/user/pay_suscription', [UserController::class, 'PaySuscription']);
Route::delete('/user/delete_users/{user_id}', [UserController::class, 'DeleteUser']);
Route::put('/user/update_users/{user_id}', [UserController::class, 'UpdateUser']);
Route::get('/user/show_users/{user_id}', [UserController::class, 'ShowInfoUser']);
//Categories
Route::get('/categories/{language}', [Category::class, 'index']);
Route::get('/categories/user/{language}', [Category::class, 'categoryUser']);

//Departments
Route::middleware('auth:sanctum')->get('/department', [DepartmentController::class, 'index']);
//Route::get('/department', [DepartmentController::class, 'index']);

//Towns
Route::get('/town/department/{id}', [TownController::class, 'department']);

//Qualifies
Route::get('/qualify', [QualifyController::class, 'index']);
Route::get('/qualify/{id}', [QualifyController::class, 'rateApp']);
Route::post('/qualify/{id}', [QualifyController::class, 'createQualifyApp']);

//languages
Route::get('/languages', [LanguagesController::class, 'index']);

//Images
Route::get('/imageproducts/create_folder/{id}', [ImageproductsController::class, 'createDirectory']);
Route::post('/imageproducts/add', [ImageproductsController::class, 'addImageProducts']);
Route::get('/imageproducts/user/{language}/{user_id}', [ImageproductsController::class, 'imagesForUser']);
Route::get('/imageproducts/{language}/{limit}/{offset}', [ImageproductsController::class, 'index']);
Route::get('/imageproducts/{language}/{image_id}', [ImageproductsController::class, 'showOne']); 
Route::get('/imageproducts_category/{language}/{category_id}', [ImageproductsController::class, 'categoryId']);
Route::get('/imageproducts/filter/search/{language}', [ImageproductsController::class, 'search']);
Route::post('/imageproducts_searchimage/{language}/{limit}/{offset}', [ImageproductsController::class, 'search']);

//Pautas
Route::get('/pautasusers', [PautasUsersController::class, 'index']);
Route::post('/pautasusers/create', [PautasUsersController::class, 'payPauta']);

//Imagenes Pautadas
Route::get('/imagepautas/{user_id}/{language}', [ImagePautasController::class, 'index']);

//parameters
Route::get('/parameters', [ParametersController::class, 'index']);

Route::get('/greeting', function () {
    return 'Hello World';
});