<?php
require "../db_helper.php";

$res = [];

if(isset($_POST["phone"])){

  $phone = $_POST["phone"];

  $db = new DBHelper();

  $db->newUser($phone);

  $res["status"] = 200;
  $res["message"] = "ok";
  
  $db->closeConnection();
}else{
  $res["status"] = 500;
  $res["message"] = "phone field is required";
}

echo json_encode($res);



?>