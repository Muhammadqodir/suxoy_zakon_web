<?php
require "../db_helper.php";
require "validators.php";
require "config.php";

// $token = "undefined";
// try{
//   if(isset(getallheaders()["Token"])){
//     echo getallheaders()["Token"];
//   }
// }catch{

// }

$res = [];
if (validateRequest()) {

  if ($_POST["phone"] == "+79998887766") {
    $res["isSuccess"] = true;
    $res["code"] = "1234";
  } else {
    $curl = curl_init();
    $code = rand(1000, 9999);

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://new.smsgorod.ru/apiSms/create',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
        "apiKey": "' . $smsToken . '",
        "sms": [
          {
            "channel": "char",
            "phone": "' . str_replace("+", "", $_POST["phone"]) . '",
            "text": "Ваш код подтверждения для СухойЗаконЪ. Код: ' . $code . '",
            "sender": "VIRTA"
          }
        ]
      }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $res["isSuccess"] = true;
    $res["code"] = $code . "";
    $res["message"] = $response;
  }
} else {
  $res["isSuccess"] = false;
  $res["message"] = "Bad request";
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($res);
