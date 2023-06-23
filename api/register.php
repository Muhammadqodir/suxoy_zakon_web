<?php
require "db_helper.php";
require "validators.php";

// $token = "undefined";
// try{
//   if(isset(getallheaders()["Token"])){
//     echo getallheaders()["Token"];
//   }
// }catch{

// }

$res = [];
if(validateRequest()){
  $db = new DBHelper();
  $user = $db->register($_POST["phone"]);
  
  $res["isSuccess"] = true;
  $res["message"] = "Готово";
  $res["data"] = $user;
}else{
  $res["isSuccess"] = false;
  $res["message"] = "Bad request";
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($res);