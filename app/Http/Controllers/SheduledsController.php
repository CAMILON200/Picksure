<?php
namespace App\Http\Controllers;

use App\Models\User;
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
use GuzzleHttp\Client;

date_default_timezone_set('America/Bogota');
class SheduledsController extends Controller
{
  private function updateStatusPautasPayU(){

    $api_login = Parameters::where('name_parameter', 'api_login')->first();
    $api_key = Parameters::where('name_parameter', 'api_key')->first();
    $merchant_id = Parameters::where('name_parameter', 'merchant_id')->first();

    $image = DB::select("SELECT reference_payment 
      FROM payment_histories ph 
      WHERE ph.payment_reference = 'PAUTA' AND ph.estado_tx = 'PENDING' AND ph.is_approved = 1
    ", []);
    if(count($image) > 0){
      $data_message = '';
      // URL de la API externa a la que quieres enviar datos mediante POST
      $apiUrl = 'https://api.payulatam.com/reports-api/4.0/service.cgi';
      foreach ($image as $key) {
        //$data_payment = $key->data_payment != '' ? json_decode($key->data_payment, true);
        // Datos que deseas enviar a la API
        $postData = [
          "test" => false,
          "language" => "en",
          "command" => "ORDER_DETAIL_BY_REFERENCE_CODE",
          "merchant" => [
            "apiLogin" => $api_login->value_parameter,
            "apiKey" => $api_key->value_parameter
          ],
          "details" => [
            "referenceCode" => $key->reference_payment
          ]
        ];

        $jsonData = json_encode($postData);
        // Crear una instancia del cliente Guzzle
        $client = new Client();

        try {
          // Realizar la solicitud POST a la API con los datos en formato raw
          $response =  $client->post($apiUrl, [
              'body' => $jsonData,
              'headers' => [
                  'Content-Type' => 'application/json', // Especificar el tipo de contenido
                  'Accept' => 'application/json'
                  // Puedes agregar otros encabezados si son necesarios
              ]
          ]);

          // Obtener la respuesta de la API
          $data = $response->getBody()->getContents();
          // Puedes manipular los datos como desees
          // Por ejemplo, decodificar una respuesta JSON
          $decodedData = json_decode($data,true);
          $resultPay = $decodedData['result'];
          if(!is_null($resultPay)){
            if(!is_null($resultPay['payload'])){
              $postDataForTransactionId = [
                "test" => false,
                "language" => "en",
                "command" => "TRANSACTION_RESPONSE_DETAIL",
                "merchant" => [
                  "apiLogin" => $api_login->value_parameter,
                  "apiKey" => $api_key->value_parameter
                ],
                "details" => [
                  "transactionId" => $resultPay['payload'][0]['processedTransactionId']
                ]
              ];
  
              $jsonDataForTransactionId = json_encode($postDataForTransactionId);
  
              // Crear una instancia del cliente Guzzle
              $clientForTransactionId = new Client();
              // Realizar la solicitud POST a la API con los datos en formato raw
              $responseForTransactionId = $clientForTransactionId->post($apiUrl, [
                'body' => $jsonDataForTransactionId,
                'headers' => [
                    'Content-Type' => 'application/json', // Especificar el tipo de contenido
                    'Accept' => 'application/json'
                    // Puedes agregar otros encabezados si son necesarios
                ]
              ]);
  
              // Obtener la respuesta de la API
              $dataForTransactionId = $responseForTransactionId->getBody()->getContents();
  
              // Puedes manipular los datos como desees
              // Por ejemplo, decodificar una respuesta JSON
              $decodedDataForTransactionId = json_decode($dataForTransactionId,true);
              
              $resultPayForTransactionId = $decodedDataForTransactionId['result'];
              $responseCode = $resultPayForTransactionId['payload']['responseCode'];
              $operationDate = intval($resultPayForTransactionId['payload']['operationDate'] / 1000);;
  
              // Hacer algo con los datos obtenidos
              DB::table('payment_histories')
              ->where('reference_payment', $key->reference_payment)
              ->update([
                'reference_pol' => $resultPay['payload'][0]['processedTransactionId'], 
                'estado_tx' => $responseCode, 
                'buyer_email' => $resultPay['payload'][0]['buyer']['emailAddress'], 
                'is_approved' => $responseCode != 'DECLINED' || $responseCode != 'REJECTED' ? $responseCode == 'APPROVED' ? 2 : 1 : 0,
                'date_payment' => date("Y-m-d H:i:s", $operationDate)
              ]);

              $data_message = 'SE ACTUALIZO CORRECTAMENTE'; 
            }else{
              DB::table('payment_histories')
              ->where('reference_payment', $key->reference_payment)
              ->update([
                'reference_pol' => $resultPay['payload'][0]['processedTransactionId'], 
                'estado_tx' => 'ERROR',
              ]);

              $data_message = 'ORDER_DETAIL_BY_REFERENCE_CODE RESULT PAYLOAD NULL'; 
            }
          }else{
            DB::table('payment_histories')
            ->where('reference_payment', $key->reference_payment)
            ->update([
              'estado_tx' => 'ERROR',
            ]);
            $data_message = 'ORDER_DETAIL_BY_REFERENCE_CODE RESULT NULL'; 
          }

        } catch (\Exception $e) {
          // Manejar cualquier error que ocurra al hacer la solicitud a la API
          // Hacer algo con los datos obtenidos
          DB::table('payment_histories')
          ->where('reference_payment', $key->reference_payment)
          ->update([
            'estado_tx' => 'ERROR',
          ]);

          $data = 'error = '. $e;
        }
      }

      $return['status'] = 200;
      $return['data'] = $data_message; 
      
      return response()->json($return, $return['status']);
    }else{
      $return['status'] = 200;
      $return['data'] = 'NO HAY ACTUALIZACIONES PENDIENTES'; 

      return response()->json($return, $return['status']);
    }
  }
  private function updateStatusSuscriptionsPayU(){

    $api_login = Parameters::where('name_parameter', 'api_login')->first();
    $api_key = Parameters::where('name_parameter', 'api_key')->first();
    $merchant_id = Parameters::where('name_parameter', 'merchant_id')->first();

    $image = DB::select("SELECT reference_payment, data_payment 
      FROM payment_histories ph 
      WHERE ph.payment_reference = 'SUSCRIPTION' AND ph.estado_tx = 'PENDING' AND ph.is_approved = 1
    ", []);

    if(count($image) > 0){
      $data = '';
      // URL de la API externa a la que quieres enviar datos mediante POST
      $apiUrl = 'https://api.payulatam.com/reports-api/4.0/service.cgi';
      foreach ($image as $key) {
        // Datos que deseas enviar a la API
        $postData = [
          "test" => false,
          "language" => "en",
          "command" => "ORDER_DETAIL_BY_REFERENCE_CODE",
          "merchant" => [
            "apiLogin" => $api_login->value_parameter,
            "apiKey" => $api_key->value_parameter
          ],
          "details" => [
            "referenceCode" => $key->reference_payment
          ]
        ];

        $jsonData = json_encode($postData);
        // Crear una instancia del cliente Guzzle
        $client = new Client();

        try {
          // Realizar la solicitud POST a la API con los datos en formato raw
          $response =  $client->post($apiUrl, [
              'body' => $jsonData,
              'headers' => [
                  'Content-Type' => 'application/json', // Especificar el tipo de contenido
                  'Accept' => 'application/json'
                  // Puedes agregar otros encabezados si son necesarios
              ]
          ]);

          // Obtener la respuesta de la API
          $data = $response->getBody()->getContents();
          // Puedes manipular los datos como desees
          // Por ejemplo, decodificar una respuesta JSON
          $decodedData = json_decode($data,true);
          $resultPay = $decodedData['result'];
          if(!is_null($resultPay)){
            if(!is_null($resultPay['payload'])){
              $postDataForTransactionId = [
                "test" => false,
                "language" => "en",
                "command" => "TRANSACTION_RESPONSE_DETAIL",
                "merchant" => [
                  "apiLogin" => $api_login->value_parameter,
                  "apiKey" => $api_key->value_parameter
                ],
                "details" => [
                  "transactionId" => $resultPay['payload'][0]['processedTransactionId']
                ]
              ];
  
              $jsonDataForTransactionId = json_encode($postDataForTransactionId);
  
              // Crear una instancia del cliente Guzzle
              $clientForTransactionId = new Client();
              // Realizar la solicitud POST a la API con los datos en formato raw
              $responseForTransactionId = $clientForTransactionId->post($apiUrl, [
                'body' => $jsonDataForTransactionId,
                'headers' => [
                    'Content-Type' => 'application/json', // Especificar el tipo de contenido
                    'Accept' => 'application/json'
                    // Puedes agregar otros encabezados si son necesarios
                ]
              ]);
  
              // Obtener la respuesta de la API
              $dataForTransactionId = $responseForTransactionId->getBody()->getContents();
  
              // Puedes manipular los datos como desees
              // Por ejemplo, decodificar una respuesta JSON
              $decodedDataForTransactionId = json_decode($dataForTransactionId,true);
              
              $resultPayForTransactionId = $decodedDataForTransactionId['result'];
              $responseCode = $resultPayForTransactionId['payload']['responseCode'];
              $operationDate = intval($resultPayForTransactionId['payload']['operationDate'] / 1000);
  
              // Hacer algo con los datos obtenidos
              DB::table('payment_histories')
              ->where('reference_payment', $key->reference_payment)
              ->update([
                'reference_pol' => $resultPay['payload'][0]['processedTransactionId'], 
                'estado_tx' => $responseCode, 
                'buyer_email' => $resultPay['payload'][0]['buyer']['emailAddress'], 
                'is_approved' => $responseCode != 'DECLINED' || $responseCode != 'REJECTED' ? $responseCode == 'APPROVED' ? 2 : 1 : 0,
                'date_payment' => date("Y-m-d H:i:s", $operationDate)
              ]);

              if($responseCode == 'APPROVED'){
                $data_payment = $key->data_payment;
                $data_payment2 = json_decode(json_decode($data_payment, true),true);
                if(isset($data_payment2['gift_voucher'])){
                  $giftVoucher = GiftVoucher::find($data_payment2['gift_voucher']);
                  $giftVoucher->state = 0;
                  $giftVoucher->update();
                }
            
                $user = User::find($data_payment2['id']);
                $user->start_date_subscriber = $data_payment2['start_date_subscriber'];
                $user->end_date_subscriber = $data_payment2['end_date_subscriber'];
                $user->update();
              }

              $data = 'SE ACTUALIZO CORRECTAMENTE'; 
              
            }else{
              DB::table('payment_histories')
              ->where('reference_payment', $key->reference_payment)
              ->update([
                'reference_pol' => $resultPay['payload'][0]['processedTransactionId'], 
                'estado_tx' => 'ERROR',
              ]);

              $data = 'ORDER_DETAIL_BY_REFERENCE_CODE RESULT PAYLOAD NULL'; 
            }
          }else{
            DB::table('payment_histories')
            ->where('reference_payment', $key->reference_payment)
            ->update([
              'estado_tx' => 'ERROR',
            ]);

            $data = 'ORDER_DETAIL_BY_REFERENCE_CODE RESULT NULL'; 
          }

        } catch (\Exception $e) {
          // Manejar cualquier error que ocurra al hacer la solicitud a la API
          // Hacer algo con los datos obtenidos
          DB::table('payment_histories')
          ->where('reference_payment', $key->reference_payment)
          ->update([
            'estado_tx' => 'ERROR',
          ]);

          $data = 'error = '. $e; 
        }
      }

      $return['status'] = 200;
      $return['data'] = $data;
      
      return response()->json($return, $return['status']);
    }else{
      $return['status'] = 200;
      $return['data'] = 'NO HAY ACTUALIZACIONES PENDIENTES'; 
      
      return response()->json($return, $return['status']);
    }
  }

  public function checkPayments(){
    $date = date("Y-m-d H:i:s");
    try {
      $checkSuscription = $this->updateStatusSuscriptionsPayU();
      $checkPauta = $this->updateStatusPautasPayU();
      $response['status'] = 200;
      $response['data'] = 'Se actualizo información '. $date; 
      return response()->json($response, $response['status']);
    } catch (\Exception $e) {
      $response['status'] = 400;
      $response['data'] = 'Hubo un error a consultar información... '. $date; 
      return response()->json($response, $response['status']);
    }
  }
}