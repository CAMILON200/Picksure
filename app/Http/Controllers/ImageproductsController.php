<?php

namespace App\Http\Controllers;

use App\Models\Imageproduct;
use App\Models\Language;
use App\Models\TextsImageproducts;
use App\Models\ImageproductsCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\isEmpty;

class ImageproductsController extends Controller
{
  public $arrayRoles;
 
  public function __construct()
  {
      $this->arrayRoles = ['admin', 'superadmin'];
  }
  //private $arrayRoles = ['admin', 'superadmin'];
  /**
     * @OA\Get(
     *  tags={"Imagenes"},
     *  summary="Devuelve todas las imagenes filtrando el lenguaje",
     *  description="Retorna un Json con los titulos de las imagenes filtradas por lenguaje",
     *  path="/api/v1/imageproducts/{language}",
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
     *    name="offset",
     *    in="query",
     *    description="offset o Limit de datos",
     *    @OA\Schema(
     *      default="0",
     *      type="integer",
     *    )
     *  ),
     *  @OA\Response(
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
     *       @OA\Property(property="message", type="string", example="Lenguaje no existe."),
     *       @OA\Property(property="errors", type="string", example="..."),
     *    )
     *  )
     * )
     */
		public function index(Request $request, $language, $limit, $offset)
    {  	
      if($language){
        $getRoles = DB::table('users')
        ->join('roles', 'roles.id', '=', 'users.role_id')
        ->whereIn('roles.name', $this->arrayRoles)
        ->select('users.id')
        ->get()
        ->toArray();

        $usersId = array_column($getRoles,'id');
        $image = DB::table('imageproducts')
        ->join('texts_imageproducts', 'texts_imageproducts.imageproduct_id', '=', 'imageproducts.id')
        ->select('imageproducts.id', 'texts_imageproducts.language','imageproducts.img_url' ,'texts_imageproducts.title', 'texts_imageproducts.description' )
        ->where('texts_imageproducts.language', '=', $language)
        ->where('imageproducts.status', '=', 1)
        ->where('imageproducts.is_public', '=', 1)
        ->whereIn('imageproducts.user_id', $usersId)
        ->orderBy('imageproducts.created_at', 'DESC')
        ->offset($offset)->limit($limit)
        ->get();
        $response['status'] = 200;
        $response['data'] = $image; 
      }	else {
        $response['status'] = 402;
        $response['data'] = 'Lenguaje no encontrado.';
      }
      return response()->json($response, $response['status']);
    } 

    /**
     * @OA\Get(
     *  tags={"Imagenes"},
     *  summary="Devuelve todas las imagenes filtrando el lenguaje",
     *  description="Retorna un Json con los titulos de las imagenes filtradas por lenguaje",
     *  path="/api/v1/imageproducts/{language}",
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
     *    name="offset",
     *    in="query",
     *    description="offset o Limit de datos",
     *    @OA\Schema(
     *      default="0",
     *      type="integer",
     *    )
     *  ),
     *  @OA\Response(
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
     *       @OA\Property(property="message", type="string", example="Lenguaje no existe."),
     *       @OA\Property(property="errors", type="string", example="..."),
     *    )
     *  )
     * )
     */
		public function imagesForUser (Request $request, $language, $user_id)
    {  	
      if($language){
        $image = DB::table('imageproducts')
        ->join('texts_imageproducts', 'texts_imageproducts.imageproduct_id', '=', 'imageproducts.id')
        ->select('imageproducts.id', 'texts_imageproducts.language','imageproducts.img_url' ,'texts_imageproducts.title', 'texts_imageproducts.description')
        ->where('texts_imageproducts.language', '=', $language)
        ->where('imageproducts.user_id','=', $user_id)
        ->where('imageproducts.status','=', 1)
        ->get();
        $response['status'] = 200;
        $response['data'] = $image; 
      }	else {
        $response['status'] = 402;
        $response['data'] = 'Lenguaje no encontrado.';
      }
      return response()->json($response, $response['status']);
    } 
   /**
     *  @OA\Get(
     *  tags={"Imagenes"},
     *  summary="Devuelve la imagen por el id",
     *  description="Retorna un Json con la imagene seleccionada por le Id ",
     *  path="/api/v1/imageproducts/{language}/{image_id}",
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
     * ),
     * @OA\Parameter(
     *    name="image_id",
     *    in="path",
     *    description="Id de la imagen",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     *  @OA\Parameter(
     *    name="offset",
     *    in="query",
     *    description="offset o Limit de datos",
     *    @OA\Schema(
     *      default="0",
     *      type="integer",
     *    )
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="Resultado de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="id", type="integer", example="1"),
     *       @OA\Property(property="name", type="string", example="imagen"),
     *    )
     *  ),
     *  @OA\Response(
     *    response=422,
     *    description="Estado Invalido de la Operación",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Los datos son incorrectos."),
     *       @OA\Property(property="errors", type="string", example=".."),
     *    )
     *  )
     * )
     */


    public function showOne(Request $request, $language, $image_id)
    {    	
      $languageData = Language::where('abreviatura', $language)->first();

      $image_id = DB::table('imageproducts')
      ->join('texts_imageproducts','texts_imageproducts.imageproduct_id', '=', 'imageproducts.id')
      ->select('imageproducts.id', 'texts_imageproducts.language_id','texts_imageproducts.title', 'texts_imageproducts.description','imageproducts.img_url')
      ->where('texts_imageproducts.language_id', '=', $languageData->id)
      ->where('imageproducts.id', '=', $image_id)
      ->get();
      if(!count($image_id) > 0){
        $response['status'] = Response::HTTP_NOT_FOUND;
        $response['data'] = 'Esta imagen no existe o no existe dentro del lenguaje especificado';
      }else{
        $response['status'] = Response::HTTP_OK;
        $response['data'] = $image_id;
      }
      return response()->json($response, $response['status']); 
    }

  /**
     * @OA\Get(
     *  tags={"Imagenes"},
     *  summary="Devuelve todas las imagenes por categoria",
     *  description="Retorna un Json con los las imagenes dependiendo la categoria ",
     *  path="/api/v1/imageproducts/category/{language}/{category_id}",
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
     *    name="category_id",
     *    in="path",
     *    description="Id de la categoria",
     *    required=true,
     *    @OA\Schema(
     *      default="1",
     *      type="integer",
     *    )
     *  ),
     *  @OA\Parameter(
     *    name="offset",
     *    in="query",
     *    description="offset o Limit de datos",
     *    @OA\Schema(
     *      default="0",
     *      type="integer",
     *    )
     *  ),
     *  @OA\Response(
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
     *       @OA\Property(property="message", type="string", example="Categoria no existe."),
     *       @OA\Property(property="errors", type="string", example="..."),
     *    )
     *  )
     * )
  */

  // Consultar ImagenProduct por Id de Categoría
  public function categoryId(Request $request, $language, $category_id)
  {  
    //$languageData = Language::where('abreviatura', $language)->first();
    $images = DB::table('imageproducts')
      ->join('texts_imageproducts','texts_imageproducts.imageproduct_id', '=', 'imageproducts.id')
      ->join('imageproducts_category', 'imageproducts_category.imageproduct_id', '=', 'imageproducts.id')
      ->join('categories', 'categories.id', '=', 'imageproducts_category.category_id')
      ->join('texts_categories', 'texts_categories.category_id', '=', 'categories.id')
      ->select('imageproducts.id', 'texts_imageproducts.language', 'texts_imageproducts.title', 'texts_imageproducts.description','imageproducts.img_url','texts_categories.name')
      ->where('texts_imageproducts.language', $language)
      ->where('texts_categories.language', $language)
      ->where('imageproducts_category.category_id', $category_id)
      ->where('imageproducts.is_public', 1)
      ->where('imageproducts.status', 1)
      ->get();
      if(!count($images) > 0){
        $response['status'] = Response::HTTP_NOT_FOUND;
        $response['data'] = [];
      }else{
        $response['status'] = Response::HTTP_OK;
        $response['data'] = $images;
      } 
      return response()->json($response, $response['status']);
  }

  /**
   * @OA\Get(
   *  tags={"Imagenes"},
   *  summary="Devuelve todas las imagenes filtrando el lenguaje",
   *  description="Retorna un Json con los titulos de las imagenes filtradas por lenguaje",
   *  path="/api/v1/imageproducts/filter/search/{language}",
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
   *  @OA\Parameter(
   *    name="keyword",
   *    in="query",
   *    description="Frase clave",
   *    @OA\Schema(
   *      default="casa",
   *      type="string",
   *    )
   *  ),
   *  @OA\Parameter(
   *    name="category",
   *    in="query",
   *    description="ID de la Categoria",
   *    @OA\Schema(
   *      default="1",
   *      type="integer",
   *    )
   *  ),
   *  @OA\Parameter(
   *    name="offset",
   *    in="query",
   *    description="offset o Limit de datos",
   *    @OA\Schema(
   *      default="0",
   *      type="integer",
   *    )
   *  ),
   *  @OA\Response(
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
   *       @OA\Property(property="message", type="string", example="Lenguaje no existe."),
   *       @OA\Property(property="errors", type="string", example="..."),
   *    )
   *  )
   * )
  */
  // Consultar ImagenProduct modalidad Search
  public function search(Request $request, $language, $limit, $offset)
  {    	
    //$languageData = Language::where('abreviatura', $language)->first();
    
    $getRoles = DB::table('users')
      ->join('roles', 'roles.id', '=', 'users.role_id')
      ->whereIn('roles.name', $this->arrayRoles)
      ->select('users.id')
      ->get()
      ->toArray();

      $usersId = array_column($getRoles,'id');

    $image = DB::table('imageproducts')
      ->join('texts_imageproducts', 'texts_imageproducts.imageproduct_id', '=', 'imageproducts.id')
      ->join('imageproducts_category', 'imageproducts_category.imageproduct_id', '=', 'imageproducts.id')
      ->select('imageproducts.id', 'texts_imageproducts.language','imageproducts.img_url' ,'texts_imageproducts.title', 'texts_imageproducts.description', 'imageproducts_category.category_id' )
      ->where('texts_imageproducts.language', '=', $language)
      ->where('imageproducts.status', '=', 1)
      ->whereIn('imageproducts.user_id', $usersId)
      ->when(!empty($request->category), function($category) use ($request) {
        return $category->where('imageproducts_category.category_id', '=', $request->category);
      })
      ->when(!empty($request->keyword), function($keyword) use ($request) {
        return $keyword->where( function($query) use ($request) {
          return $query->where('texts_imageproducts.title', 'LIKE', '%'.$request->keyword.'%')
            ->orWhere('texts_imageproducts.description', 'LIKE', '%'.$request->keyword.'%');
        });
      })
      ->orderBy('imageproducts.created_at', 'DESC')
      ->offset($offset)->limit($limit)
      ->get();
      //->toSql();
    $response['status'] = Response::HTTP_OK;
    $response['data'] = $image;
    
    return response()->json($response, $response['status']);
  }
  /*
  public function indexFilter($id)
  {
    $users = User::where(function ($query) use ($id) {
      $query->where('firstname', 'like', '%'.$id.'%')
        ->orWhere('lastname', 'like', '%'.$id.'%')
        ->orWhere('phone', 'like', '%'.$id.'%')
        ->orWhere('email', 'like', '%'.$id.'%');
    })->get();
    return response()->json($users, 200);
  }

  public function showOneUser($id)
  {
    return response()->json(User::find($id));
  }

  public function create(Request $request)
  {
    $this->validate($request, [
      'firstname' => 'required',
      'lastname' => 'required',
      'phone' => 'required',
      'email' => 'required|email|unique:users'
    ]);

    $User = User::create($request->all());

    return response()->json($User, 201);
  }

  public function update($id, Request $request)
  {
    $User = User::findOrFail($id);
    $User->update($request->all());

    return response()->json($User, 200);
  }

  public function delete($id)
  {
    User::findOrFail($id)->delete();
    return response('Deleted Successfully', 200);
  }*/


	public function createDirectory(Request $request, $id)
	{
		$carpetaPrincipal = 'usersdemo';

    $directorio = $carpetaPrincipal . '/' . 'usersdemo';
    Storage::makeDirectory($carpetaPrincipal);
    return response()->json(['success' => true, 'data' => $directorio]);
	}

  public function addImageProducts(Request $request){
    $image = new Imageproduct;
    $image->user_id = $request["user_id"];
    $image->is_public = 0;
    $image->status = 1;
    
    if ($request->hasFile('img_url')) {
      
      $request->validate([
        'img_url' => 'required|image|max:20000', // Máximo 20 MB (20480 kilobytes)
      ]);

      $file = $request->file('img_url');

      $path = $file->store('imageproducts/users/'.$request["user_id"], 'public');

      $image->img_url = $path;
    }

    $image->save();
    
    $result_image = $image->id;
    
    $itemProducts = $request['text_products'];
    $itemProductsARR = json_decode($itemProducts, true);
    if(count($itemProductsARR) > 0){
      foreach ($itemProductsARR as $key => $value) {
        $texts = TextsImageproducts::create([
          'title' => $value["title"],
          'description' => $value["description"],
          'imageproduct_id' => $result_image,
          'language' => $value["language"],
        ]);
      } 	
      DB::commit();
    }

    $itemCategory = $request['categories'];
    $itemCategoryARR = json_decode($itemCategory, true);
    if(count($itemCategoryARR) > 0){
      foreach ($itemCategoryARR as $key => $value) {
        $texts = ImageproductsCategory::create([
          'imageproduct_id' => $result_image,
          'category_id' => $value,
        ]);
      } 	
      DB::commit();
    }

    $imageAdd = DB::table('imageproducts')
      ->join('texts_imageproducts', 'texts_imageproducts.imageproduct_id', '=', 'imageproducts.id')
      ->leftJoin('images_pautas', 'imageproducts.id', '=', 'images_pautas.imageproducts_id')
      ->select('imageproducts.id', 'texts_imageproducts.language','imageproducts.img_url' ,'texts_imageproducts.title', 'texts_imageproducts.description', 'images_pautas.id as id_pautas')
      ->where('texts_imageproducts.language', '=', $request["language"])
      ->where('imageproducts.user_id', '=', $request["user_id"])
      ->where('imageproducts.id', '=', $result_image)
      ->get();

    return response()->json(['success' => true, 'data' => $imageAdd]);
  }

  private function groupArray($array,$groupkey)
  {
    if (count($array)>0)
    {
      $keys = array_keys($array[0]);
      $removekey = array_search($groupkey, $keys);		
      
      if ($removekey===false)
        return array("Clave \"$groupkey\" no existe");
      else
        unset($keys[$removekey]);

      $groupcriteria = array();
      $return=array();
      foreach($array as $value)
      {
        $item=null;
        foreach ($keys as $key)
        {
          $item[$key] = $value[$key];
        }
        $busca = array_search($value[$groupkey], $groupcriteria);
        if ($busca === false)
        {
          $groupcriteria[]=$value[$groupkey];
          $return[]=array($groupkey=>$value[$groupkey],'groupeddata'=>array());
          $busca=count($return)-1;
        }
        $return[$busca]['groupeddata'][]=$item;
      }
      return $return;
    }
    else
      return array();
  }

  public function uploadFile(Request $request)
  {
    if ($request->hasFile('image_product_2')) {

			$upload = $request->file('image_product_2');

			$filePath = $upload->getRealPath();

			$file=fopen($filePath, 'r');
			
			$header=fgetcsv($file, 0, ',');
			
			$escapedHeader=[];
			foreach($header as $key => $value) {
				array_push($escapedHeader, trim($value));
			}

      $datos = array();
      
      while ($row = fgetcsv($file)) {
        $arr = array();
        $header[0] = 'URL_Imagen';
        foreach ($header as $i => $col)
          $arr[$col] = trim($row[$i]);
          
        $datos[] = $arr;
      }

      $maintance_datos = $this->groupArray($datos, 'URL_Imagen');

      foreach($maintance_datos as $data) {
        $url_image = 'imageproducts/'.$data['URL_Imagen'];
        $data_group = $data['groupeddata'];

        $image = new Imageproduct;
        $image->user_id = 1;
        $image->is_public = 1;
        $image->status = 1;
        $image->img_url = $url_image;
        $image->save();
        $result_image = $image->id;

        if(count($data_group) > 0){
          $catSelected = [];
          foreach ($data_group as $datosImg) {
            if(trim($datosImg["Categoria"]) != ''){
              $xplCategories = explode('|',trim($datosImg["Categoria"]));
              foreach ($xplCategories as $v) {
                if (!in_array(trim($v), $catSelected)) {
                  array_push($catSelected, "'".trim($v)."'");
                }
              }
            }

            $texts = TextsImageproducts::create([
              'title' => $datosImg["Titulo"],
              'language' => $datosImg["Idioma"],
              'description' => $datosImg["Descripcion"],
              'imageproduct_id' => $result_image,
            ]);
          } 	
          DB::commit();

          $idCategories = DB::select("SELECT id FROM categories WHERE slug in (".implode(",", $catSelected).")", []);//revisar con un replace el implode

          foreach ($idCategories as $cat) {
            $category = ImageproductsCategory::create([
              'imageproduct_id' => $result_image,
              'category_id' => $cat->id,
            ]);
          } 	
          DB::commit();
        }
      }
      
      return response()->json(['success' => true, 'data' => $result_image]);
      /*
 
       foreach($datos as $data) {
         $Title = $data['Titulo'];
         $Language = $data['Idioma'];
         $Image_Url = $data['Imagen_Url'];
         $Description = $data['Descripcion'];
         $Category = $data['Categoria'];
 
         $dataImage = ImageProduct::where('img_url', iconv("ISO-8859-1", "UTF-8", $Image_Url))->value('id'); 
 
         if($dataImage!= null)
         {
           $TypeText = new TextsImageproducts();
           $TypeText->imageproduct_id=$dataImage;
           $TypeText->language=iconv("ISO-8859-1", "UTF-8", trim($Language));
           $TypeText->title=iconv("ISO-8859-1", "UTF-8", trim($Title));
           $TypeText->description=iconv("ISO-8859-1", "UTF-8", trim($Description));
           $TypeText->save();
         } else {
           $dataNew = new $dataType->model_name();
           $dataNew->img_url=iconv("ISO-8859-1", "UTF-8", 'imageproducts/'.trim($Image_Url));
           $dataNew->user_id=1;
           $dataNew->is_public=1;
           $dataNew->status=1;
           $dataNew->save();
   
           if($dataNew!= null){
             $TypeText = new TextsImageproducts();
             $TypeText->imageproduct_id = $dataNew->id;
             $TypeText->language = iconv("ISO-8859-1", "UTF-8", trim($Language));
             $TypeText->title = iconv("ISO-8859-1", "UTF-8", trim($Title));
             $TypeText->description = iconv("ISO-8859-1", "UTF-8", trim($Description));
             $TypeText->save();
             
             $newCat = new ImageproductsCategory();
             $newCat->imageproduct_id=$dataNew->id;
             $newCat->category_id=$Category;
             $newCat->save();
           }
         }
       }
 
       $data = $dataType['model_name']::limit(1)->orderBy('created_at', 'DESC')->get();
       event(new BreadDataAdded($dataType, $data));
 
     
 
       if (!$request->has('_tagging')) {
         if (auth()->user()->can('browse', $data[0])) {
           $redirect = redirect()->route("voyager.{$dataType->slug}.index");
         } else {
           $redirect = redirect()->back();
         }
 
         return $redirect->with([
           'message'    => __('voyager::generic.successfully_added_new')." {$dataType->getTranslatedAttribute('display_name_singular')}",
           'alert-type' => 'success',
         ]);
       } else {
         return response()->json(['success' => true, 'data' => $data]);
       }
       
      */
		}
  }

  public function deleteImageProducts(Request $request, $id){
    $image = Imageproduct::find($request->id);
    $image->status = 0;
    $image->save();
    
    return response()->json(['success' => true, 'data' => $image, 'message' => 'Se eliminó correctamente']);
  }
}