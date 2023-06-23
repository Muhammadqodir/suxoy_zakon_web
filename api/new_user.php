<?php
require "db_helper.php";

$res = [];

if(isset($_POST["phone"])){

  $phone = $_POST["phone"];

  $db = new DBHelper();

  $db->newUser($phone);

  $res["isSuccess"] = true;
  $res["message"] = "ok";
  
  $db->closeConnection();
}else{
  $res["isSuccess"] = false;
  $res["message"] = "phone field is required";
}

echo json_encode($res);



?>